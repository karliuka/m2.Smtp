<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Log Resource Model
 */
class Log extends AbstractDb
{
    /**
     * Initialize Resource Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('faonni_smtp_log', 'log_id');
    }
}