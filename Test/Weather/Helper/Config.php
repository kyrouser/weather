<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 */
class Config extends AbstractHelper
{
    const WEATHER_GENERAL_ENABLE            = 'weather/general/enable';
    const WEATHER_GENERAL_CRON_ENABLE       = 'weather/general/cron_enable';
    const WEATHER_API_PROVIDER              = 'weather/api/provider';
    const WEATHER_API_CITY                  = 'weather/api/city';
    const WEATHER_OPEN_WEATHER_MAP_UNIT     = 'weather/open_weather_map/unit';
    const WEATHER_OPEN_WEATHER_MAP_LANGUAGE = 'weather/open_weather_map/language';
    const WEATHER_OPEN_WEATHER_MAP_API_KEY  = 'weather/open_weather_map/api_key';

    /**
     * @return bool
     */
    public function isWeatherModuleEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::WEATHER_GENERAL_ENABLE);
    }

    /**
     * @return bool
     */
    public function isWeatherCronEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::WEATHER_GENERAL_CRON_ENABLE);
    }

    /**
     * @return string
     */
    public function getApiProvider(): string
    {
        return (string) $this->scopeConfig->getValue(self::WEATHER_API_PROVIDER);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return (string) $this->scopeConfig->getValue(self::WEATHER_API_CITY);
    }

    /**
     * @return string
     */
    public function getOpenWeatherMapUnit(): string
    {
        return (string) $this->scopeConfig->getValue(self::WEATHER_OPEN_WEATHER_MAP_UNIT);
    }

    /**
     * @return string
     */
    public function getOpenWeatherMapLanguage(): string
    {
        return (string) $this->scopeConfig->getValue(self::WEATHER_OPEN_WEATHER_MAP_LANGUAGE);
    }

    /**
     * @return string
     */
    public function getOpenWeatherMapApiKey(): string
    {
        return (string) $this->scopeConfig->getValue(self::WEATHER_OPEN_WEATHER_MAP_API_KEY);
    }
}
