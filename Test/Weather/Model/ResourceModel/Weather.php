<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model\ResourceModel;

use Test\Weather\Api\Data\WeatherInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Weather
 */
class Weather extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(WeatherInterface::TABLE, WeatherInterface::ID);
    }
}
