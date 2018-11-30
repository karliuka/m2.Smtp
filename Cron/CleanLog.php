<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Cron;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Faonni\Smtp\Model\LogManagement;

/**
 * Clean Log Job
 */
class CleanLog
{
    /**
     * Last Clean Config Path
     */
    const XML_CONFIG_LAST_CLEAN = 'system/smtp/last_clean';
    
    /**
     * Log Management
     *
     * @var \Faonni\Smtp\Model\LogManagement
     */
    protected $_logManager;
    
    /**
     * Config Writer
     *
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */    
    protected $_configWriter;
    
    /**
     * Locale Date
     *
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;    
    
    /**
	 * Initialize Job
	 *	
     * @param LogManagement $logManager	
     * @param WriterInterface $configWriter 
     * @param TimezoneInterface $localeDate     
     */
    public function __construct(
		LogManagement $logManager,
		WriterInterface $configWriter,
		TimezoneInterface $localeDate
	) {
		$this->_logManager = $logManager;
		$this->_configWriter = $configWriter;
		$this->_localeDate = $localeDate;
    }
    
    /**
     * Clean Log
     *
     * @return void
     */
    public function execute()
    {
        $this->_logManager->deleteExpire();
        $this->_updateLastClean();
    }
    
    /**
     * Update Last Clean
     *
     * @return void
     */
    protected function _updateLastClean()
    {
        $this->_configWriter->save(
			self::XML_CONFIG_LAST_CLEAN,  
			$this->_localeDate->formatDate()
		);
    }    
}
