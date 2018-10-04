<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Block\Widget;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Test\Weather\Api\WeatherRepositoryInterface;

/**
 * Class Weather
 */
class Weather extends Template implements BlockInterface
{
    const BEFORE_TEXT = 'text_before_weather';
    const AFTER_TEXT  = 'text_after_weather';

    const NO_WEATHER_SAVED_MESSAGE  = '';

    /** @var string */
    protected $_template = 'widget/weather.phtml';

    /** @var WeatherRepositoryInterface */
    protected $weatherRepository;

    /**
     * Weather constructor.
     *
     * @param WeatherRepositoryInterface $weatherRepository
     * @param Template\Context           $context
     * @param array                      $data
     */
    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->weatherRepository = $weatherRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getFullText()
    {
        return $this->getTextBeforeTemplate() . ' ' . $this->getWeather() . ' ' . $this->getTextAfterTemplate();
    }

    /**
     * @return string
     */
    public function getTextBeforeTemplate()
    {
        return (string) $this->getData(self::BEFORE_TEXT);
    }

    /**
     * @return string
     */
    public function getTextAfterTemplate()
    {
        return (string) $this->getData(self::AFTER_TEXT);
    }

    /**
     * @return string
     */
    public function getWeather()
    {
        try {
            return $this->weatherRepository->getLatest()->getWeather();
        } catch (NoSuchEntityException $e) {
            return self::NO_WEATHER_SAVED_MESSAGE;
        }
    }
}
