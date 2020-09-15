<?php

namespace Luis\MagentoTest\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Framework\Phrase;

class LayoutProcessor implements LayoutProcessorInterface
{
    public function process($jsLayout)
    {
        // remove couple fields
        unset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['company']);
        unset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']);

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'])) {
            foreach ($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'] as &$child) {
                if (isset($child['label'])) {
                    $label = $child['label'];

                    if ($label instanceof Phrase) {
                        $label = $label->getText();
                    }

                    $child['label'] = __(strrev($label));
                }
            }
        }

        return $jsLayout;
    }
}