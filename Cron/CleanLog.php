<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Cron;

use Faonni\Smtp\Model\LogManagement;

/**
 * Clean Log Job
 */
class CleanLog
{
    /**
     * Log Management
     *
     * @var \Faonni\Smtp\Model\LogManagement
     */
    protected $_logManager;
    
    /**
	 * Initialize Job
	 *	
     * @param LogManagement $logManager	 
     */
    public function __construct(
		LogManagement $logManager
	) {
		$this->_logManager = $logManager;
    }
    
    /**
     * Clean Log
     *
     * @return void
     */
    public function execute()
    {
        $this->_logManager->deleteExpire();
    }
}
