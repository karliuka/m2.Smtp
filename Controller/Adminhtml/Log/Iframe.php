<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Registry;
use Faonni\Smtp\Controller\Adminhtml\Log as LogAbstract;

/**
 * Iframe Log Controller
 */
class Iframe extends LogAbstract
{
    /**
     * Result Forward Factory
     *
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;
    
    /**
     * Result Raw Factory
     *
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultFactory;    
    
    /**
     * Registry
     *
     * @var Magento\Framework\Registry
     */
    protected $_registry;    

    /**
     * Initialize Controller
     *
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param RawFactory $resultPageFactory    
     * @param Registry $registry     
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        RawFactory $resultFactory,
        Registry $registry
    ) {
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_resultFactory = $resultFactory;        
        $this->_registry = $registry;
        
        parent::__construct(
			$context
		);
    }

    /**
     * View Action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id', false);
        $log = $this->_objectManager->get('Faonni\Smtp\Model\Log')
            ->load($id);          
        
        if (!$log->getId()) {
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        
        $resultRaw = $this->_resultFactory
			->create();
			
        return $resultRaw->setContents($log->getMessageBody());
    }
}
