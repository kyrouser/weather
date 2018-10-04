<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model;

use Magento\Framework\Model\AbstractModel;
use Test\Weather\Api\Data\WeatherInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Weather
 */
class Weather extends AbstractModel implements WeatherInterface, IdentityInterface
{
    const CACHE_TAG = 'test_weather_weather';

    protected $_cacheTag = 'test_weather_weather';
    protected $_eventPrefix = 'test_weather_weather';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Weather::class);
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setWeather($weather)
    {
        return $this->setData(self::FIELD_WEATHER, $weather);
    }

    /**
     * {@inheritdoc}
     */
    public function getWeather()
    {
        return $this->getData(self::FIELD_WEATHER);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::FIELD_CREATED_AT, $createdAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::FIELD_CREATED_AT);
    }
}
