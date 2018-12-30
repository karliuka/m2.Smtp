<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Faonni\Smtp\Model\Log;

/**
 * Status Source Option
 */
class Status implements ArrayInterface
{
    /**
     * Retrieve array of Options as Value-Label Pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Log::STATUS_FAILED , 'label' => __('Failed')],
            ['value' => Log::STATUS_SUCCESS, 'label' => __('Success')]
        ];
    }
}
