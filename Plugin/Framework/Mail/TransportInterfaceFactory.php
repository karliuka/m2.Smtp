<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Plugin\Framework\Mail; 

use Magento\Framework\ObjectManagerInterface;
use Faonni\Smtp\Helper\Data as SmtpHelper;

/**
 * TransportInterface Plugin
 */
class TransportInterfaceFactory
{
    /**
     * Object Manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Transport Instance Name to Create
     *
     * @var string
     */
    protected $_instanceName;
    
    /**
     * Helper
     *
     * @var \Faonni\Smtp\Helper\Data
     */
    protected $_helper;
    
    /**
	 * Initialize Factory
	 *	
     * @param SmtpHelper $helper 
     * @param ObjectManagerInterface $objectManager
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
     * Create Class instance with Specified Parameters
     *
     * @param $subject TransportInterfaceFactory
     * @param $proceed \Callable	
     * @param array $data
     * @return \Magento\Framework\Mail\TransportInterface
     */	
    public function aroundCreate($subject, $proceed, array $data = []) 
    {
        if ($this->_helper->isEnabled()) {
            return $this->_objectManager
				->create($this->_instanceName, $this->_helper->getConfig($data));
        }
		return $proceed($data);
    }	
}
