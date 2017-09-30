<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Faonni\Smtp\Controller\Adminhtml\Log as LogAbstract;

/**
 * View Log Controller
 */
class View extends LogAbstract
{
    /**
     * Result Forward Factory
     *
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;
    
    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;    
    
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
     * @param PageFactory $resultPageFactory    
     * @param Registry $registry     
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_resultPageFactory = $resultPageFactory;        
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
        
        $this->_registry->register('faonni_smtp_log', $log);
	
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->addHandle('faonni_smtp_log_view'); 
        
        $resultPage->setActiveMenu('Faonni_Smtp::log');
        $resultPage
            ->addBreadcrumb(
                __('Sending Emails'), 
                __('Sending Emails')
            )->addBreadcrumb(
                __('Message'), 
                __('Message')
            );
		
        $resultPage->getConfig()->getTitle()
			->prepend(__('Sending Emails'));
			
		$resultPage->getConfig()->getTitle()
            ->prepend(__('Message'));
			
        return $resultPage;
    }
}
