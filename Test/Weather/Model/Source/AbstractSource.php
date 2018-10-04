<?php
/**
 * @package   Test\Weather
 * @author    Mateusz
 */

namespace Test\Weather\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class AbstractSource
 */
class AbstractSource implements ArrayInterface
{
    /** @var array */
    protected $options;

    /** @var array */
    protected $values = [];

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [];
            foreach ($this->values as $value) {
                $this->options[] = [
                    'value' => $value,
                    'label' => $this->getLabel($value)
                ];
            }
        }

        return $this->options;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function getLabel(string $value)
    {
        return ucwords(str_replace('_', ' ', $value));
    }
}
