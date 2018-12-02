<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;
use Zend\Mail\Message as ZendMessage;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Protocol\Smtp as SmtpProtocol;
use Faonni\Smtp\Model\LogManagement;

/**
 * Smtp Transport
 */
class Transport implements TransportInterface
{
    /**
     * Message
     *
     * @var \Magento\Framework\Mail\MessageInterface
     */     
    protected $_message;
	
    /**
     * Log management
     *
     * @var \Faonni\Smtp\Model\LogManagement
     */
    protected $_logManager;	
    
    /**
     * Smtp transport
     *
     * @var \Zend\Mail\Transport\Smtp
     */
    private $_smtpTransport;
    
    /**
	 * Initialize transport
	 *	
     * @param MessageInterface $message
     * @param LogManagement $logManager	 
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(
		MessageInterface $message,
		LogManagement $logManager,
		array $config
	) {
        $this->_message = $message;
		$this->_logManager = $logManager;
		$this->_smtpTransport = new Smtp( 
			new SmtpOptions($config)
		);
    }

    /**
     * Send a mail using smtp transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        $error = null;
        $message = ZendMessage::fromString(
			$this->_message->getRawMessage()
		);
		
        try {
            $this->_smtpTransport->send($message);
        } catch (\Exception $e) {
            $error = new Phrase($e->getMessage());
            throw new MailException($error, $e);
        }
        finally {
			$this->_logManager->add($message, $error);			
		}
    }
    
    /**
     * Test the smtp connection protocol
     *
     * @return bool
     */
    public function testConnection()
    {
        $result = false;
        $option = $this->_smtpTransport->getOptions();
        $connection = $this->_smtpTransport->getConnection();
        if (!($connection instanceof SmtpProtocol) || !$connection->hasSession()) {
			$config = $option->getConnectionConfig();
			$config['host'] = $option->getHost();
			$config['port'] = $option->getPort();            
            $connection = $this->_smtpTransport->plugin($option->getConnectionClass(), $config);
        }
        
		$connection->connect();
		$connection->helo($option->getName());
		$result = true;        
		// Reset connection to ensure reliable transaction
		$connection->rset();

		return $result;
    } 
	
    /**
     * Retrieve message
     *
     * @return \Magento\Framework\Mail\MessageInterface
     */
    public function getMessage()
	{
		return $this->_message;
	}	
}
