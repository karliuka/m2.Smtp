<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Mail\MessageInterface;
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
     * Add Log Record
     *
     * @param MessageInterface $message
     * @param string $error
     * @return void
     */
    public function add(MessageInterface $message, $error)
	{
        if (!$this->_helper->isLogEnabled()) {
            return;
        }
        
		$log = $this->_collection->getNewEmptyItem();		
		$recipients = $message->getRecipients();
		$recipient = reset($recipients);

		$log->setData([
			'subject'         => $message->getSubject(),
			'message_body'    => $message->getBody()->getRawContent(),
			'from'            => $message->getFrom(),
			'recipient_email' => $recipient,
			'error'           => $error,
			'status'          => $error ? 0 : 1
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