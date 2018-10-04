<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Cron;

use Test\Weather\Api\Data\WeatherInterfaceFactory;
use Test\Weather\Helper\Config;
use Test\Weather\Model\Api\Connector;
use Test\Weather\Api\WeatherRepositoryInterface;

/**
 * Class SynchronizeWeather
 */
class SynchronizeWeather
{
    /** @var Config */
    protected $config;

    /** @var Connector */
    protected $connector;

    /** @var WeatherRepository */
    protected $weatherRepository;

    /** @var WeatherInterfaceFactory */
    protected $weatherFactory;

    /**
     * SynchronizeWeather constructor.
     *
     * @param Config                     $config
     * @param Connector                  $connector
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherInterfaceFactory    $weatherFactory
     */
    public function __construct(
        Config $config,
        Connector $connector,
        WeatherRepositoryInterface $weatherRepository,
        WeatherInterfaceFactory $weatherFactory
    ) {
        $this->config            = $config;
        $this->connector         = $connector;
        $this->weatherRepository = $weatherRepository;
        $this->weatherFactory    = $weatherFactory;
    }

    public function synchronize()
    {
        if (!$this->config->isWeatherModuleEnabled() || !$this->config->isWeatherCronEnabled()) {
            return;
        }
        $city    = $this->config->getCity();
        $weather = $this->connector->getWeather($city);

        /** @var \Test\Weather\Api\Data\WeatherInterface $weatherModel */
        $weatherModel = $this->weatherFactory->create();
        $weatherModel->setWeather($weather);

        $this->weatherRepository->save($weatherModel);
    }
}
