<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Logger\Detailed;

use Test\Weather\Helper\Config;

/**
 * Class Logger
 */
class Logger extends \Monolog\Logger
{
    /** @var Config */
    protected $config;

    /**
     * Logger constructor.
     *
     * @param Config $config
     * @param string $name
     * @param array  $handlers
     * @param array  $processors
     */
    public function __construct(
        Config $config,
        string $name,
        $handlers = array(),
        $processors = array()
    ) {
        $this->config = $config;
        parent::__construct($name, $handlers, $processors);
    }

    /**
     * Adds a log record.
     *
     * @param  int     $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = array())
    {
        if ($this->config->isLogsDetailedEnabled()) {
            return parent::addRecord($level, $message, $context);
        }
        return false;
    }
}
