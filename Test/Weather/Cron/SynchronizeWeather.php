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
use Test\Weather\Logger\Base\Logger;
use Test\Weather\Logger\Detailed\Logger as DetailedLogger;

/**
 * Class SynchronizeWeather
 */
class SynchronizeWeather
{
    const CRON_START = 'start weather cron';
    const CRON_END   = 'end weather cron';
    const CRON_ERROR = 'Error occured: ';

    /** @var Config */
    protected $config;

    /** @var Connector */
    protected $connector;

    /** @var WeatherRepository */
    protected $weatherRepository;

    /** @var WeatherInterfaceFactory */
    protected $weatherFactory;

    /** @var Logger */
    protected $logger;

    /** @var DetailedLogger */
    protected $detailedLogger;

    /**
     * SynchronizeWeather constructor.
     *
     * @param Config                     $config
     * @param Connector                  $connector
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherInterfaceFactory    $weatherFactory
     * @param Logger                     $logger
     * @param DetailedLogger             $detailedLogger
     */
    public function __construct(
        Config $config,
        Connector $connector,
        WeatherRepositoryInterface $weatherRepository,
        WeatherInterfaceFactory $weatherFactory,
        Logger $logger,
        DetailedLogger $detailedLogger
    ) {
        $this->config            = $config;
        $this->connector         = $connector;
        $this->weatherRepository = $weatherRepository;
        $this->weatherFactory    = $weatherFactory;
        $this->logger            = $logger;
        $this->detailedLogger    = $detailedLogger;
    }

    public function synchronize()
    {
        if (!$this->config->isWeatherModuleEnabled() || !$this->config->isWeatherCronEnabled()) {
            return;
        }
        $this->detailedLogger->info(self::CRON_START);
        try {
            $city    = $this->config->getCity();
            $weather = $this->connector->getWeather($city);

            /** @var \Test\Weather\Api\Data\WeatherInterface $weatherModel */
            $weatherModel = $this->weatherFactory->create();
            $weatherModel->setWeather($weather);

            $this->weatherRepository->save($weatherModel);
        } catch (\Exception $e) {
            $this->detailedLogger->info(self::CRON_ERROR . $e->getMessage());
            $this->logger->error($e->getMessage());
        }
        $this->detailedLogger->info(self::CRON_END);
    }
}
