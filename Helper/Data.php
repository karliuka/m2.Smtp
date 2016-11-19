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
 * @copyright   Copyright (c) 2016 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
     * host config path
     */
    const XML_SMTP_ENABLED = 'system/smtp/enabled';
    	
    /**
     * host config path
     */
    const XML_SMTP_HOST = 'system/smtp/host';

    /**
     * port config path
     */
    const XML_SMTP_PORT = 'system/smtp/port';

    /**
     * auth config path
     */
    const XML_SMTP_AUTH = 'system/smtp/auth';
 
    /**
     * ssl config path
     */
    const XML_SMTP_SSL = 'system/smtp/ssl';

    /**
     * username config path
     */
    const XML_SMTP_USER = 'system/smtp/user';

    /**
     * password config path
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
