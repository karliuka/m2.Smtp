<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Plugin\Framework\Mail; 

use Magento\Framework\Mail\MessageInterface;
use Faonni\Smtp\Helper\Data as SmtpHelper;
use Faonni\Smtp\Model\Attachment\Image as ImageAttachment;

/**
 * Message Plugin
 */
class Message
{
    /**
     * Helper
     *
     * @var \Faonni\Smtp\Helper\Data
     */
    protected $_helper;
    
    /**
     * Image Attachment
     *
     * @var \Faonni\Smtp\Model\Attachment\Image
     */
    protected $_imageAttachment;    
	
    /**
     * Message Type
     *
     * @var string
     */
    protected $_messageType = MessageInterface::TYPE_TEXT;
    
    /**
	 * Initialize Mail
	 *	
     * @param SmtpHelper $helper
     * @param ImageAttachment $imageAttachment    
     */
    public function __construct(
        SmtpHelper $helper,
        ImageAttachment $imageAttachment
    ) {
        $this->_helper = $helper;
        $this->_imageAttachment = $imageAttachment;
    }
	
    /**
     * Set Message Body
     *
     * @param MessageInterface $subject
     * @param string $body
     * @return string
     */	
    public function beforeSetBody(MessageInterface $subject, $body) 
    {
		if ($this->_helper->isImageAttachment() && $this->isTypeHtml()) {
			$body = $this->_prepareBodyHtml($subject, $body);
		}
		return [$body];
    }	
	
    /**
     * Set Message Type
     *
     * @param MessageInterface $subject	
     * @param string $type
     * @return string
     */	
    public function beforeSetMessageType(MessageInterface $subject, $type) 
    {
        $this->_messageType = $type;
		return [$type];
    }
	
    /**
     * Check if Type Message is Html
     *
     * @return bool
     */
    public function isTypeHtml()
    {
        return $this->_messageType == MessageInterface::TYPE_HTML;
    }
	
    /**
     * Prepare Body Html
     *
     * @param MessageInterface $message 
     * @param string $body
     * @return string
     */
    protected function _prepareBodyHtml(MessageInterface $message, $body)
    {
        return $this->_imageAttachment->prepareBodyHtml($message, $body);
    }	
}
