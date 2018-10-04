<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder\Proxy as ProxySearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Test\Weather\Api\Data\WeatherInterface;
use Test\Weather\Api\Data\WeatherInterfaceFactory;
use Test\Weather\Api\Data\WeatherSearchResultsInterfaceFactory;
use Test\Weather\Api\WeatherRepositoryInterface;
use Test\Weather\Model\ResourceModel\Weather as Resource;
use Test\Weather\Model\ResourceModel\Weather\CollectionFactory;

/**
 * Class WeatherRepository
 */
class WeatherRepository implements WeatherRepositoryInterface
{
    /** @var WeatherInterface[] */
    private $instances = [];

    /** @var WeatherInterfaceFactory */
    protected $factory;

    /** @var Resource */
    protected $resource;

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var WeatherSearchResultsInterfaceFactory */
    protected $searchResultsFactory;

    /** @var CollectionProcessorInterface */
    protected $collectionProcessor;

    /** @var ProxySearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /** @var SortOrderBuilder */
    protected $sortOrderBuilder;

    /**
     * WeatherRepository constructor.
     *
     * @param WeatherInterfaceFactory              $factory
     * @param Resource                             $resource
     * @param CollectionFactory                    $collectionFactory
     * @param WeatherSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface         $collectionProcessor
     * @param ProxySearchCriteriaBuilder           $searchCriteriaBuilder
     * @param SortOrderBuilder                     $sortOrderBuilder
     */
    public function __construct(
        WeatherInterfaceFactory $factory,
        Resource $resource,
        CollectionFactory $collectionFactory,
        WeatherSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        ProxySearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->factory               = $factory;
        $this->resource              = $resource;
        $this->collectionFactory     = $collectionFactory;
        $this->searchResultsFactory  = $searchResultsFactory;
        $this->collectionProcessor   = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
    }

    /**
     * @inheritdoc
     */
    public function save(WeatherInterface $weather)
    {
        try {
            $this->resource->save($weather);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(self::COULD_NOT_SAVE_EXCEPTION_MESSAGE), $e);
        }

        return $weather;
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        if (!isset($this->instances[$id])) {
            /** @var WeatherInterface $weather */
            $entity = $this->factory->create();
            $this->resource->load($entity, $id);
            if (!$entity->getId()) {
                throw NoSuchEntityException::singleField('id', $id);
            }
            $this->instances[$id] = $entity;
        }

        return $this->instances[$id];
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var \Test\Weather\Model\ResourceModel\Weather\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function delete(WeatherInterface $weather)
    {
        try {
            $this->resource->delete($weather);
        } catch (\Exception $e) {
            throw new StateException(__(self::COULD_NOT_DELETE_EXCEPTION_MESSAGE));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id)
    {
        /** @var \Test\Weather\Api\Data\WeatherInterface $weather */
        $weather = $this->factory->create();
        $this->resource->load($weather, $id);

        if (!$weather->getId()) {
            throw new NoSuchEntityException(__(self::COULD_NOT_DELETE_BY_ID_EXCEPTION_MESSAGE, $id));
        }

        $this->delete($weather);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getLatest()
    {
        $direction = SortOrder::SORT_DESC;
        $field     = WeatherInterface::FIELD_CREATED_AT;
        $sortOrder = $this->sortOrderBuilder->setField($field)->setDirection($direction)->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $result         = $this->getList($searchCriteria)->getItems();

        return reset($result);
    }
}
