<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Log Model
 */
class Log extends AbstractModel
{
    /**
     * Log Status Success
     */
    const STATUS_SUCCESS = 1;
    
    /**
     * Log Status Failed
     */
    const STATUS_FAILED = 0;
    
    /**
     * Initialize Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Faonni\Smtp\Model\ResourceModel\Log');
    }
}
