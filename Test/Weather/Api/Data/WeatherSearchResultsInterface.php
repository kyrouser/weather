<?php
/**
 * @package   test\weather
 * @author    Mateusz
 * @copyright 2018
 */

namespace Test\Weather\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface WeatherSearchResultsInterface
 */
interface WeatherSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Weather list.
     * @return WeatherInterface[]
     */
    public function getItems();

    /**
     * Set Weather list.
     * @param WeatherInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
