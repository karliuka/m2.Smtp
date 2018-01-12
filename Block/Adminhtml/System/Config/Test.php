<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Block\Adminhtml\System\Config;

use Magento\Framework\DataObject;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

/**
 * Ajax Test Button Block
 */
class Test extends Field
{
    /**
     * Test Button Label
     *
     * @var string
     */
    protected $_buttonLabel = 'Test connection';
    
    /**
     * Test Button Params
     *
     * @var string
     */
    protected $_buttonParams;    

    /**
     * Set Test Button Label
     *
     * @param string $buttonLabel
     * @return \Magento\Config\Block\System\Config\Form\Field
     */
    public function setButtonLabel($buttonLabel)
    {
        $this->_buttonLabel = $buttonLabel;        
        return $this;
    }

    /**
     * Add Param to Button
     *
     * @param string $name	 
     * @param string $element
     * @return \Magento\Config\Block\System\Config\Form\Field
     */
    public function addParam($name, $element)
    {
		$this->_buttonParams->addData($name, $element);				
        return $this;
    }
	
    /**
     * Overwrite Params to Button
     *
     * @param string|array $name	 
     * @param string $element
     * @return \Magento\Config\Block\System\Config\Form\Field
     */
    public function setParam($name, $element=null)
    {
		$this->_buttonParams->setData($name, $element);			
        return $this;
    }
	
    /**
     * Set Template to itself
     *
     * @return \Magento\Config\Block\System\Config\Form\Field
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/test.phtml');
        }              
        $this->_buttonParams = new DataObject();              
        return $this;
    }

    /**
     * Unset some non-related Element Parameters
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()
			->unsCanUseWebsiteValue()
			->unsCanUseDefaultValue();
			
        return parent::render($element);
    }

    /**
     * Retrieve Button and Scripts Contents
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $data = $element->getOriginalData();
        $label = !empty($data['button_label']) 
			? $data['button_label'] 
			: $this->_buttonLabel;
			
        $this->addData([
			'button_label'   => __($label),
			'html_id'  	     => $element->getHtmlId(),
			'ajax_url'       => $this->_urlBuilder->getUrl('faonni_smtp/connection/test'),
			'js_function'    => 'smtpConnectionTest',
			'html_result_id' => 'smtp_connection_test',
		] );       
        return $this->_toHtml();
    }
    
    /**
     * Retrieve Button Params
     *
     * @return \Magento\Framework\DataObject
     */
    public function getParams()
    {         
        return $this->_buttonParams;
    }    
}
