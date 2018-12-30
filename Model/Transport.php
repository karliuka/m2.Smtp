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
use Faonni\Smtp\Model\LogManagement;

/**
 * Smtp transport
 */
class Transport extends \Zend_Mail_Transport_Smtp implements TransportInterface
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
        array $config = [],
        $host = '127.0.0.1'
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
     * Send a mail using this transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        $error = null;
        try {
            parent::send($this->_message);
        } catch (\Exception $e) {
            $error = new Phrase($e->getMessage());
            throw new MailException($error, $e);
        } finally {
            $this->_logManager->add($this->_message, $error);
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
     * Retrieve message
     *
     * @return \Magento\Framework\Mail\MessageInterface
     */
    public function getMessage()
    {
        return $this->_message;
    }
}
