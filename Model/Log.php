<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
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
     * Initialize Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Faonni\Smtp\Model\ResourceModel\Log');
    }
}
