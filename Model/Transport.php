<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;
use Faonni\Smtp\Model\LogManagement;

/**
 * Smtp Transport
 */
class Transport extends \Zend_Mail_Transport_Smtp implements TransportInterface
{
    /**
     * Object Manager
     *
     * @var \Magento\Framework\Mail\MessageInterface
     */     
    protected $_message;
	
    /**
     * Log Management
     *
     * @var \Faonni\Smtp\Model\LogManagement
     */
    protected $_logManager;	
    
    /**
	 * Initialize Transport
	 *	
     * @param MessageInterface $message
     * @param LogManagement $logManager	 
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(
		MessageInterface $message,
		LogManagement $logManager,
		$host = '127.0.0.1', 
		array $config = []
	) {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException(
				'The message should be an instance of \Zend_Mail'
			);
        } 
		
        $this->_message = $message;
		$this->_logManager = $logManager;
		
		parent::__construct(
			$host, 
			$config
		);
    }

    /**
     * Send a Mail Using this Transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
		$error = null;
		try {
            parent::send($this->_message);
        } 
        catch (\Exception $e) {
            $error = new Phrase($e->getMessage());
			throw new MailException($error, $e);
        } 
        finally {
			$this->_logManager->add($this->_message, $error);			
		}
    }
    
    /**
     * Test the Smtp Connection Protocol
     *
     * @return bool
     */
    public function testConnection()
    {
        $result = false;
        if (!($this->_connection instanceof Zend_Mail_Protocol_Smtp)) {
            // Check if authentication is required and determine required class
            $connectionClass = 'Zend_Mail_Protocol_Smtp';
            if ($this->_auth) {
                $connectionClass .= '_Auth_' . ucwords($this->_auth);
            }
            if (!class_exists($connectionClass)) {
                #require_once 'Zend/Loader.php';
                Zend_Loader::loadClass($connectionClass);
            }
            $this->setConnection(
				new $connectionClass(
					$this->_host, 
					$this->_port, 
					$this->_config
				)
			);
            $this->_connection->connect();
            $this->_connection->helo($this->_name);
            $result = true;
        } 
		// Reset connection transaction
		$this->_connection->rset();
		
		return $result;
    } 
	
    /**
     * Retrieve Message
     *
     * @return \Magento\Framework\Mail\MessageInterface
     */
    public function getMessage()
	{
		return $this->_message;
	}
}
