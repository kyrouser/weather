<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Model\Api\Providers;

use Test\Weather\Api\ProviderInterface;
use Test\Weather\Helper\Config;
use Test\Weather\Exception\NotEnabledException;

/**
 * Class AbstractProvider
 */
abstract class AbstractProvider implements ProviderInterface
{
    /** @var Config */
    protected $config;

    /**
     * Connector constructor.
     *
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }

    /**
     * @throws NotEnabledException
     */
    public function init()
    {
        if (!$this->config->isWeatherModuleEnabled()) {
            throw new NotEnabledException(__(self::MODULE_NOT_ENABLED_EXCEPTION_MESSAGE));
        }
    }

    /**
     * @param string $city
     *
     * @return string
     */
    abstract public function getWeather(string $city);
}
