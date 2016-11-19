<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_Smtp
 * @copyright   Copyright (c) 2016 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\Smtp\Model;

use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;

/**
 * Faonni Smtp Transport
 */
class Transport extends \Zend_Mail_Transport_Smtp implements TransportInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\Mail\MessageInterface
     */     
    protected $_message;
    
    /**
     * @param MessageInterface $message
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(MessageInterface $message, $host = '127.0.0.1', array $config = []) 
    {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('The message should be an instance of \Zend_Mail');
        }
        parent::__construct($host, $config);
        $this->_message = $message;
    }

     /**
     * Send a mail using this transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        try {
            parent::send($this->_message);
        } catch (\Exception $e) {
            throw new MailException(new Phrase($e->getMessage()), $e);
        }
    }
}
