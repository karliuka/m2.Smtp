<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source of option values in a form of value-label pairs
 */
class Ssl implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '',    'label' => __('None')],
            ['value' => 'ssl', 'label' => __('SSL')],
            ['value' => 'tls', 'label' => __('TLS')],
        ];
    }
}
