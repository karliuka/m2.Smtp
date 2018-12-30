<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Model\AbstractModel;
use Faonni\Smtp\Model\ResourceModel\Log as LogResource;

/**
 * Log Model
 * @api
 */
class Log extends AbstractModel
{
    /**
     * Log status success
     */
    const STATUS_SUCCESS = 1;

    /**
     * Log status failed
     */
    const STATUS_FAILED = 0;

    /**
     * Initialize model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(LogResource::class);
    }
}
