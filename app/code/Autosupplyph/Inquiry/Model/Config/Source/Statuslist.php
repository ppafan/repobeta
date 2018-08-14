<?php

namespace Autosupplyph\Inquiry\Model\Config\Source;

/**
 * Comment statuses
 */
class Statuslist implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const string
     */
    const PROGRESS = 0;

    /**
     * @const int
     */
    const ADDRESSED = 1;
    
    /**
     * Options int
     *
     * @return array
     */
    public function toOptionArray()
    {
        return  [
            ['value' => self::PROGRESS, 'label' => __('In Progress')],
            ['value' => self::ADDRESSED, 'label' => __('Issue is Addressed')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
