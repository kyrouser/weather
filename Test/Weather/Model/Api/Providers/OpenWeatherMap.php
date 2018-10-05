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
use Test\Weather\Logger\Detailed\Logger as DetailedLogger;

/**
 * Class OpenWeatherMap
 */
class OpenWeatherMap extends AbstractProvider
{
    const FULL_OBJECT_MESSAGE = 'Full weather object data: ';

    /** @var CmfCmfOpenWeatherMap */
    protected $client;

    /** @var DetailedLogger */
    protected $detailedLogger;

    /**
     * OpenWeatherMap constructor.
     *
     * @param Config               $config
     * @param CmfCmfOpenWeatherMap $client
     * @param DetailedLogger       $detailedLogger
     */
    public function __construct(
        Config $config,
        CmfCmfOpenWeatherMap $client,
        DetailedLogger $detailedLogger
    ) {
        $this->client         = $client;
        $this->detailedLogger = $detailedLogger;
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
            $this->detailedLogger->debug(self::FULL_OBJECT_MESSAGE);
            $this->detailedLogger->debug(serialize($weather));

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
