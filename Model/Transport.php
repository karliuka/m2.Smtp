<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;

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
     * Application Event Dispatcher
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;	
    
    /**
	 * Initialize Transport
	 *	
     * @param MessageInterface $message
     * @param ManagerInterface $eventManager	 
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(
		MessageInterface $message,
		ManagerInterface $eventManager,
		$host = '127.0.0.1', 
		array $config = []
	) {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException(
				'The message should be an instance of \Zend_Mail'
			);
        } 
		
        $this->_message = $message;
		$this->_eventManager = $eventManager;
		
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
			$this->_eventManager->dispatch(
				'faonni_smtp_send_after', [
					'message' => $this->_message,
					'error'   => $error
				]
			); 			
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
