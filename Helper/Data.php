<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Faonni Smtp Data Helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled Config Path
     */
    const XML_CONFIG_ENABLED = 'system/smtp/enabled';
    	
    /**
     * Host Config Path
     */
    const XML_CONFIG_HOST = 'system/smtp/host';

    /**
     * Port Config Path
     */
    const XML_CONFIG_PORT = 'system/smtp/port';

    /**
     * Auth Config Path
     */
    const XML_CONFIG_AUTH = 'system/smtp/auth';
 
    /**
     * Ssl Config Path
     */
    const XML_CONFIG_SSL = 'system/smtp/ssl';

    /**
     * Username Config Path
     */
    const XML_CONFIG_USER = 'system/smtp/user';

    /**
     * Password Config Path
     */
    const XML_CONFIG_PASS = 'system/smtp/pass';
    
    /**
     * Image Attachment Config Path
     */
    const XML_CONFIG_IMAGE_ATTACHMENT = 'system/smtp/image_attachment';    
 	
    /**
     * Check Smtp Transport Functionality Should be Enabled
     *
     * @param string $store 	 
     * @return bool
     */
    public function isEnabled($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_ENABLED, $store);
    } 
    
    /**
     * Check Image Attachment Functionality Should be Enabled
     *
     * @param string $store      
     * @return bool
     */    	
    public function isImageAttachment($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_IMAGE_ATTACHMENT, $store);
    }
    
    /**
     * Retrieve Password
     *
     * @param string $store 
     * @return string
     */
    public function getPassword($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_PASS, $store);
    } 
    
    /**
     * Retrieve Configure Smtp Settings
     *
     * @param array $config
     * @return array
     */
    public function getConfig(array $config = [])
    {
		$config['host'] = $this->_getConfig(self::XML_CONFIG_HOST);
		$config['config'] = [
			'port' => $this->_getConfig(self::XML_CONFIG_PORT),
			'auth' => $this->_getConfig(self::XML_CONFIG_AUTH),
			'ssl'  => $this->_getConfig(self::XML_CONFIG_SSL),
			'username' => $this->_getConfig(self::XML_CONFIG_USER),
			'password' => $this->_getConfig(self::XML_CONFIG_PASS)
		];        
        return $config;
    } 
    
    /**
     * Retrieve Store Configuration Data
     *
     * @param string $path
     * @param int|Store $store	 
     * @return string|null
     */
    protected function _getConfig($path, $store = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store);
    }      
}
