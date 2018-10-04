<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model\Source;

/**
 * Class Unit
 */
class Unit extends AbstractSource
{
    /** @var array */
    protected $values = [
        'metric',
        'imperial'
    ];
}
