<?php

namespace Make\Ship\Model\Ways\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allShippingMethods;

    public function __construct(\Make\Ship\Model\Ways $allShippingMethods)
    {
        $this->allShippingMethods = $allShippingMethods;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allShippingMethods->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
