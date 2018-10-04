<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Model\Api;

use Test\Weather\Api\Data\ApiProvidersInterface;
use Test\Weather\Helper\Config;
use Test\Weather\Model\Api\Providers\AbstractProvider;
use Test\Weather\Model\Api\Providers\OpenWeatherMapFactory;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class Connector
 */
class Connector implements ApiProvidersInterface
{
    /** @var Config */
    protected $config;

    /** @var OpenWeatherMapFactory */
    protected $openWeatherMapFactory;

    /**
     * Connector constructor.
     *
     * @param Config                $config
     * @param OpenWeatherMapFactory $openWeatherMapFactory
     */
    public function __construct(
        Config $config,
        OpenWeatherMapFactory $openWeatherMapFactory
    ) {
        $this->config                = $config;
        $this->openWeatherMapFactory = $openWeatherMapFactory;
    }

    /**
     * @param string $city
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function getWeather(string $city)
    {
        $client = $this->getApiClient();

        return $client->getWeather($city);
    }

    /**
     * @return AbstractProvider
     * @throws NotFoundException
     */
    protected function getApiClient()
    {
        switch ($this->config->getApiProvider()) {
            case ApiProvidersInterface::PROVIDER_OPEN_WEATHER_MAP:
                return $this->openWeatherMapFactory->create();
                break;
            default:
                throw new NotFoundException(__(self::PROVIDER_NOT_FOUND_EXCEPTION_MESSAGE));
        }
    }
}
