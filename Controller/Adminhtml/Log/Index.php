<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Log as LogAbstract;

/**
 * Index Log Controller
 */
class Index extends LogAbstract
{
    /**
     * Result Page Factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * Initialize Controller
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        
        parent::__construct(
			$context
		);
    }
   
    /**
     * Index Action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        
        $resultPage->setActiveMenu('Faonni_Smtp::log');
        $resultPage->addBreadcrumb(
			__('Sending Emails'), 
			__('Sending Emails')
		);
		
        $resultPage->getConfig()->getTitle()
			->prepend(
				__('Sending Emails')
			);

        return $resultPage;
    }
}