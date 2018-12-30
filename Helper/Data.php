<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Smtp helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_CONFIG_ENABLED = 'system/smtp/enabled';

    /**
     * Host config path
     */
    const XML_CONFIG_HOST = 'system/smtp/host';

    /**
     * Port config path
     */
    const XML_CONFIG_PORT = 'system/smtp/port';

    /**
     * Auth config path
     */
    const XML_CONFIG_AUTH = 'system/smtp/auth';
 
    /**
     * Ssl config path
     */
    const XML_CONFIG_SSL = 'system/smtp/ssl';

    /**
     * Username config path
     */
    const XML_CONFIG_USER = 'system/smtp/user';

    /**
     * Password config path
     */
    const XML_CONFIG_PASS = 'system/smtp/pass';

    /**
     * Log enabled config path
     */
    const XML_CONFIG_LOG = 'system/smtp/log';

    /**
     * Enabled log cleaning config path
     */
    const XML_CONFIG_CLEAN = 'system/smtp/clean';

    /**
     * Days config path
     */
    const XML_CONFIG_DAYS = 'system/smtp/days';

    /**
     * Check smtp transport functionality should be enabled
     *
     * @param string $store
     * @return bool
     */
    public function isEnabled($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_ENABLED, $store);
    }

    /**
     * Check log functionality should be enabled
     *
     * @param string $store
     * @return bool
     */
    public function isLogEnabled($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_LOG, $store);
    }

    /**
     * Check clean functionality should be enabled
     *
     * @param string $store
     * @return bool
     */
    public function isCleanEnabled($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_CLEAN, $store);
    }

    /**
     * Retrieve password
     *
     * @param string $store
     * @return string
     */
    public function getPassword($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_PASS, $store);
    }

    /**
     * Retrieve days
     *
     * @param string $store
     * @return string
     */
    public function getDays($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_DAYS, $store);
    }

    /**
     * Retrieve configure smtp settings
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
     * Retrieve store configuration data
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
