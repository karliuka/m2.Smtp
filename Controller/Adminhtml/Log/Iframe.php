<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Log as Action;
use Faonni\Smtp\Model\Log;

/**
 * Iframe controller
 */
class Iframe extends Action
{
    /**
     * Result forward factory
     *
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * Result raw factory
     *
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $_resultFactory;

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

        $resultRaw = $this->_resultFactory
            ->create();

        return $resultRaw->setContents($log->getMessageBody());
    }
}
