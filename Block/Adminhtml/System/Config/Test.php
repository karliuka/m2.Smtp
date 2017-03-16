<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_Smtp
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\Smtp\Block\Adminhtml\System\Config;

use Magento\Framework\DataObject;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

/**
 * Faonni config ajax test button block
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
     * Add param to button
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
     * Overwrite params to button
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
     * Set template to itself
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
     * Unset some non-related element parameters
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
     * Get the button and scripts contents
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
			
        $this->addData(
            [
                'button_label'   => __($label),
                'html_id'  	     => $element->getHtmlId(),
                'ajax_url'       => $this->_urlBuilder->getUrl('smtp/connection/test'),
                'js_function'    => 'smtpConnectionTest',
                'html_result_id' => 'smtp_connection_test',
            ]
        );
        
        return $this->_toHtml();
    }
    
    /**
     * Get the button params
     *
     * @return \Magento\Framework\DataObject
     */
    public function getParams()
    {         
        return $this->_buttonParams;
    }    
}
 
