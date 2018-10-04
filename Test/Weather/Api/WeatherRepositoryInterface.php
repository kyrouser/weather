<?php
 /**
 * @package  Test\Weather 
 * @author Mateusz
 */

namespace Test\Weather\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\Weather\Api\Data\WeatherInterface;
use Test\Weather\Api\Data\WeatherSearchResultsInterface;

/**
 * Interface WeatherRepositoryInterface
 */
interface WeatherRepositoryInterface
{
    const COULD_NOT_SAVE_EXCEPTION_MESSAGE = 'Could not save weather entity';
    const COULD_NOT_DELETE_EXCEPTION_MESSAGE = 'Cannot delete entity.';
    const COULD_NOT_DELETE_BY_ID_EXCEPTION_MESSAGE = 'Entity with id "%1" does not exist.';

    /**
     * Create or update a Weather
     *
     * @param WeatherInterface $model
     * @return WeatherInterface
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws AlreadyExistsException
     */
    public function save(WeatherInterface $model);

    /**
     * Returns Weather by ID
     *
     * @param int $id
     * @return WeatherInterface
     * @throws NoSuchEntityException
     */
    public function get($id);

    /**
     * Removes Weather entity
     *
     * @param WeatherInterface $model
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(WeatherInterface $model);

    /**
     * Delete a Weather entity by id
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById($id);

    /**
     * Returns the list of Weather entities. The list is an array of objects,
     * and detailed information about item attributes might not be included.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return WeatherSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Returns Latest saved Weather
     *
     * @return WeatherInterface
     * @throws NoSuchEntityException
     */
    public function getLatest();
}
