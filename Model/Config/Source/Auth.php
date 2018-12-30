<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Auth Source Option
 */
class Auth implements ArrayInterface
{
    /**
     * Retrieve array of Options as Value-Label Pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => ''     , 'label' => __('Authentication Not Required')],
            ['value' => 'plain', 'label' => __('Plain')],
            ['value' => 'login', 'label' => __('Login')],
            ['value' => 'crammd5', 'label' => __('CRAM-MD5')]
        ];
    }
}
