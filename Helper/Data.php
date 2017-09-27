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
 * Faonni Smtp Data helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_SMTP_ENABLED = 'system/smtp/enabled';
    	
    /**
     * Host config path
     */
    const XML_SMTP_HOST = 'system/smtp/host';

    /**
     * Port config path
     */
    const XML_SMTP_PORT = 'system/smtp/port';

    /**
     * Auth config path
     */
    const XML_SMTP_AUTH = 'system/smtp/auth';
 
    /**
     * Ssl config path
     */
    const XML_SMTP_SSL = 'system/smtp/ssl';

    /**
     * Username config path
     */
    const XML_SMTP_USER = 'system/smtp/user';

    /**
     * Password config path
     */
    const XML_SMTP_PASS = 'system/smtp/pass';
 	
    /**
     * Check Smtp Transport functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getConfig(self::XML_SMTP_ENABLED);
    } 
    
    /**
     * Retrieve configure smtp settings
     *
     * @param array $config
     * @return array
     */
    public function getConfig(array $config = [])
    {
		$config['host'] = $this->_getConfig(self::XML_SMTP_HOST);
		$config['config'] = [
			'port' => $this->_getConfig(self::XML_SMTP_PORT),
			'auth' => $this->_getConfig(self::XML_SMTP_AUTH),
			'ssl'  => $this->_getConfig(self::XML_SMTP_SSL),
			'username' => $this->_getConfig(self::XML_SMTP_USER),
			'password' => $this->_getConfig(self::XML_SMTP_PASS)
		];        
        return $config;
    } 
    
    /**
     * Retrieve store configuration data
     *
     * @param   string $path
     * @return  string|null
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }      
}
