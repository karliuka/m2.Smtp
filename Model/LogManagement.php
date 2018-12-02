<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Zend\Mail\Message;
use Zend\Mail\AddressList;
use Faonni\Smtp\Helper\Data as SmtpHelper;
use Faonni\Smtp\Model\ResourceModel\Log\CollectionFactory;

/**
 * Log Management
 */
class LogManagement
{
    /**
     * Helper
     *
     * @var \Faonni\Smtp\Helper\Data
     */
    protected $_helper;
	
    /**
     * Log Collection
     *
     * @var \Faonni\Smtp\Model\ResourceModel\Log\Collection
     */
    protected $_collection; 
	
    /**
     * Initialize Management
     * 
     * @param SmtpHelper $helper 
     * @param CollectionFactory $collectionFactory 	 
     */
    public function __construct(
        SmtpHelper $helper,
		CollectionFactory $collectionFactory
    ) {      
        $this->_helper = $helper;
		$this->_collection = $collectionFactory->create();
    }
    
    /**
     * Retrieve emails
     *
     * @param AddressList $addressList  
     * @return string
     */
    protected function _getEmail(AddressList $addressList)
    {
        $emails = [];
        $addressList->rewind();
		while ($addressList->valid()) {
			$address = $addressList->current();
			$emails[] = $address->getEmail();
			$addressList->next();
		}
		return implode(',', $emails);
    }
    
    /**
     * Add Log Record
     *
     * @param Message $message
     * @param string $error
     * @return void
     */
    public function add(Message $message, $error)
	{
        if (!$this->_helper->isLogEnabled()) {
            return;
        }
        
		$log = $this->_collection->getNewEmptyItem();
		$log->setData([
			'subject' => $message->getSubject(),
			'message_body' => $message->getBodyText(),
			'from' => $this->_getEmail($message->getFrom()),
			'recipient_email' => $this->_getEmail($message->getTo()),
			'error' => $error,
			'status' => $error ? 0 : 1
		]);
		$log->save();
	}
	
    /**
     * Delete Expire Log
     *
     * @return void
     */
    public function deleteExpire()
	{
        if (!$this->_helper->isCleanEnabled()) {
            return;
        }
        
		$collection = $this->_collection
            ->addExpireDateFilter(
                $this->_helper->getDays()
            );
		
		foreach ($collection as $log) {
			$log->delete();
		}
	}	
}