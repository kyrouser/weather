<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Test\Weather\Api\Data\WeatherInterface;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{

    /** @var string */
    protected $_idFieldName = WeatherInterface::ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Test\Weather\Model\Weather::class,
            \Test\Weather\Model\ResourceModel\Weather::class
        );
    }
}
