<?php
/**
 * @package  Test\Weather
 * @author   Mateusz
 */

namespace Test\Weather\Api\Data;

/**
 * Interface WeatherInterface
 */
interface WeatherInterface
{
    /** DB table name */
    const TABLE = 'test_weather';

    /** Table fields */
    const ID               = 'entity_id';
    const FIELD_WEATHER    = 'weather';
    const FIELD_CREATED_AT = 'created_at';

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $weather
     *
     * @return $this
     */
    public function setWeather($weather);

    /**
     * @return string
     */
    public function getWeather();

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getCreatedAt();
}
