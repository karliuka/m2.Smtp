<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Block\Adminhtml\Log;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Faonni\Smtp\Model\Config\Source\Status as StatusOption;

/**
 * Log View Block
 * @api
 */
class View extends Container
{
    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry; 

    /**
     * Status Option
     *
     * @var \Faonni\Smtp\Model\Config\Source\Status
     */
    protected $_statusOption;

    /**
     * Initialize Block
     *
     * @param Context $context
     * @param Registry $registry 
     * @param StatusOption $statusOption
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StatusOption $statusOption,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->_statusOption = $statusOption;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Preparing global layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->addButton('back', [
            'label'   => __('Back'),
            'onclick' => "location.href='" . $this->getUrl('*/*/') . "'",
            'class'   => 'back'
        ]);

        $this->addButton('delete', [
            'label' => __('Delete'),
            'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
                . ','
                . json_encode($this->getUrl('*/*/delete', ['id' => $this->getLog()->getId()]))
                . ')',
            'class' => 'scalable delete'
        ]);

        return parent::_prepareLayout();
    }

    /**
     * Retrieve Log Instance
     *
     * @return \Faonni\Smtp\Model\Log
     */
    public function getLog()
    {
        return $this->_registry->registry('faonni_smtp_log');
    }

    /**
     * Retrieve Message Body Url
     *
     * @return string
     */
    public function getMessageBodyUrl()
    {
        return $this->getUrl('*/*/iframe', ['id' => $this->getLog()->getId()]);
    } 

    /**
     * Retrieve From
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->getLog()->getFrom();
    }

    /**
     * Retrieve Recipient Email
     *
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->getLog()->getRecipientEmail();
    }

    /**
     * Retrieve Subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->getLog()->getSubject();
    } 

    /**
     * Retrieve Creation Time
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->formatDate(
            $this->getLog()->getCreatedAt(),
            \IntlDateFormatter::FULL
        );
    }

    /**
     * Retrieve Status
     *
     * @return string
     */
    public function getStatus()
    {
        $options = $this->_statusOption->toOptionArray();
        foreach ($options as $option) {
            if ($option['value'] == $this->getLog()->getStatus()) {
                return $option['label'];
            }
        }
        return __('Unknown');
    }

    /**
     * Retrieve Error Message
     *
     * @return string
     */
    public function getError()
    {
        return $this->getLog()->getError() ?: __('None');
    }
}
