<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model\Source;

/**
 * Class Language
 */
class Language extends AbstractSource
{
    /** @var array */
    protected $values = [
        'en',
        'pl'
    ];

    /**
     * @param string $value
     *
     * @return string
     */
    protected function getLabel(string $value)
    {
        return strtoupper(parent::getLabel($value));
    }
}
