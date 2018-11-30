<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Ssl Source Option
 */
class Ssl implements ArrayInterface
{
    /**
     * Retrieve array of Options as Value-Label Pairs
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
