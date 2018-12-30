<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Log as Action;
use Faonni\Smtp\Model\Log;

/**
 * View controller
 */
class View extends Action
{
    /**
     * Result forward factory
     *
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Core registry
     *
     * @var Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Initialize controller
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
     * View action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id', false);
        $log = $this->_objectManager->get(Log::class)
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
                __($log->getSubject()),
                __($log->getSubject())
            );

        $resultPage->getConfig()->getTitle()
            ->prepend(__('Sending Emails'));

        $resultPage->getConfig()->getTitle()
            ->prepend(__($log->getSubject()));

        return $resultPage;
    }
}
