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
namespace Faonni\Smtp\Model\Plugin; 

use Magento\Framework\ObjectManagerInterface;
use Faonni\Smtp\Helper\Data as SmtpHelper;

/**
 * Plugin for \Magento\Framework\Mail\TransportInterface
 */
class TransportInterfaceFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName;
    
    /**
     * Helper instance
     *
     * @var Faonni\Smtp\Helper\Data
     */
    protected $_helper;
    
    /**
     * Factory constructor
     *
     * @param \Faonni\Smtp\Helper\Data $helper 
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        SmtpHelper $helper,
        ObjectManagerInterface $objectManager,
        $instanceName = 'Faonni\Smtp\Model\Transport'
    ) {
        $this->_helper = $helper;
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
    	
    /**
     * Create class instance with specified parameters
     *
     * @param $subject Magento\Framework\Mail\TransportInterfaceFactory
     * @param $proceed \Callable	
     * @param array $data
     * @return \Magento\Framework\Mail\TransportInterface
     */	
    public function aroundCreate($subject, $proceed, array $data = []) 
    {
        if ($this->_helper->isEnabled()) {
            return $this->_objectManager->create($this->_instanceName, $this->_helper->getConfig($data));
        }
		return $proceed($data);
    }	
}
