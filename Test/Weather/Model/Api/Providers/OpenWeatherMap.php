<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Model\Api\Providers;

use CmfCmf\OpenWeatherMap\Exception as CmfCmfOpenWeatherMapException;
use Cmfcmf\OpenWeatherMap as CmfCmfOpenWeatherMap;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Test\Weather\Exception\ApiException;
use Test\Weather\Exception\NotEnabledException;
use Test\Weather\Helper\Config;

/**
 * Class OpenWeatherMap
 */
class OpenWeatherMap extends AbstractProvider
{
    /** @var CmfCmfOpenWeatherMap */
    protected $client;

    /**
     * OpenWeatherMap constructor.
     *
     * @param Config               $config
     * @param CmfCmfOpenWeatherMap $client
     */
    public function __construct(
        Config $config,
        CmfCmfOpenWeatherMap $client
    ) {
        $this->client = $client;
        parent::__construct($config);
    }

    /**
     * @param string $city
     *
     * @return string
     * @throws ApiException
     * @throws NotEnabledException
     */
    public function getWeather(string $city)
    {
        $this->init();
        $apiKey   = $this->config->getOpenWeatherMapApiKey();
        $unit     = $this->config->getOpenWeatherMapUnit();
        $language = $this->config->getOpenWeatherMapLanguage();

        try {
            $this->client->setApiKey($apiKey);
            $weather = $this->client->getWeather($city, $unit, $language);

            return $this->parse($weather);
        } catch (CmfCmfOpenWeatherMapException $e) {
            $message = __CLASS__ . ': ' . $e->getMessage();
            throw new ApiException(__($message));
        }
    }

    /**
     * @param CurrentWeather $currentWeather
     * @param string         $parseTo
     *
     * @return mixed
     */
    public function parse(CurrentWeather $currentWeather, $parseTo = 'string')
    {

        echo '<pre>';
        print_r($currentWeather);
        echo '</pre>';


        $parsed = '';
        switch ($parseTo) {
            case 'string':
            case 'default':
                $parsed = 'weather: ' . $currentWeather->weather->description;
                $parsed .= ', temperature: ' . $currentWeather->temperature->now->getFormatted();
                $parsed .= ', pressure: ' . $currentWeather->pressure->getFormatted();
                $parsed .= ', wind direction: ' . $currentWeather->wind->direction->getFormatted();
                $parsed .= ', wind speed: ' . $currentWeather->wind->speed->getFormatted();
        }
        return $parsed;
    }
}
