<?php
/**
 * Mail Template Transport Builder
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Faonni\Smtp\Model\Framework\Mail\Template;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder as OriginTransportBuilder;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\Mail\MessageInterfaceFactory;

/**
 * Transport builder
 */
class TransportBuilder extends OriginTransportBuilder
{
    /**
	 * Initialize transport builder
	 *	
     * @param FactoryInterface $templateFactory
     * @param MessageInterface $message
     * @param SenderResolverInterface $senderResolver
     * @param ObjectManagerInterface $objectManager
     * @param TransportInterfaceFactory $mailTransportFactory
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        FactoryInterface $templateFactory,
        MessageInterface $message,
        SenderResolverInterface $senderResolver,
        ObjectManagerInterface $objectManager,
        TransportInterfaceFactory $mailTransportFactory,
        MessageInterfaceFactory $messageFactory = null
    ) {
        $this->templateFactory = $templateFactory;
        $this->objectManager = $objectManager;
        $this->_senderResolver = $senderResolver;
        $this->mailTransportFactory = $mailTransportFactory;
        $this->messageFactory = $messageFactory ?: $this->objectManager->get(MessageInterfaceFactory::class);
        $this->message = $message;
    }
}
