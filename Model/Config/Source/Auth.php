<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
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
            ['value' => 'login', 'label' => __('Login/Password')],
        ];
    }
}
