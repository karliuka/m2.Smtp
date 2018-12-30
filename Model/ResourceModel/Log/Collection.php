<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Faonni\Smtp\Model\ResourceModel\Log as LogResource;
use Faonni\Smtp\Model\Log;

/**
 * Log ResourceModel Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'faonni_smtp_log_collection';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'collection';

    /**
     * Identifier field name for collection items
     *
     * @var string
     */
    protected $_idFieldName = 'log_id';

    /**
     * Initialize Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Log::class, LogResource::class);
    }

    /**
     * Limit collection by expire date
     *
     * @param string $interval
     * @return $this
     */
    public function addExpireDateFilter($interval)
    {
        $this->getSelect()->where(
            "created_at <= NOW() - INTERVAL ? DAY",
            (int)$interval
        );
        return $this;
    }
}
