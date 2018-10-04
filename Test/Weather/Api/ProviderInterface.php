<?php
 /**
 * @package  Test\Weather 
 * @author Mateusz
 */

namespace Test\Weather\Api;

/**
 * Interface ProviderInterface
 */
interface ProviderInterface
{
    const MODULE_NOT_ENABLED_EXCEPTION_MESSAGE = 'Weather module is disabled';

    /**
     * @param string $city
     *
     * @return string
     */
    public function getWeather(string $city);
}
