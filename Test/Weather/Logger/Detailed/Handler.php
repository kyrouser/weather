<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Logger\Detailed;

use Magento\Framework\Logger\Handler\Base as MagentoBase;

/**
 * Class Handler
 */
class Handler extends MagentoBase
{
    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/test-weather-detailed.log';

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}
