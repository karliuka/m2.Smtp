<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Log as Action;
use Faonni\Smtp\Model\Log;

/**
 * Delete controller
 */
class Delete extends Action
{
    /**
     * Result forward factory
     *
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->_resultForwardFactory = $resultForwardFactory;

        parent::__construct(
            $context
        );
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $log = $this->_objectManager->get(Log::class)
            ->load($id);

        if (!$log->getId()) {
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $log->delete();
            $this->messageManager->addSuccess(__('The log message has been deleted.'));
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/view', ['id' => $id]);
        }
    }
}
