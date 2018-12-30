<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Log;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Faonni\Smtp\Model\ResourceModel\Log\Collection;
use Faonni\Smtp\Controller\Adminhtml\Log as Action;

/**
 * Mass delete controller
 */
class MassDelete extends Action
{
    /**
     * Mass action filter
     *
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_filter;

    /**
     * Log collection
     *
     * @var \Faonni\Smtp\Model\ResourceModel\Log\Collection
     */
    protected $_collection;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param Filter $filter
     * @param Collection $collection
     */
    public function __construct(
        Context $context,
        Filter $filter,
        Collection $collection
    ) {
        $this->_filter = $filter;
        $this->_collection = $collection;

        parent::__construct(
            $context
        );
    }

    /**
     * Mass delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection(
            $this->_collection
        );

        $size = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $size)
        );
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
