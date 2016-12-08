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
namespace Faonni\Smtp\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Smtp response observer
 */
class ResponseObserver implements ObserverInterface
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
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        $instanceName = 'Faonni\Smtp\Model\Transport'
    ) {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
       	
    /**
     * Handler for smtp response event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		$request = $observer->getEvent()->getRequest();
		$response = $observer->getEvent()->getResponse();		
		try {
            $data = [
				'host' => $request->getParam('host'),
				'config' => [
					'port' => $request->getParam('port'),
					'auth' => $request->getParam('auth'),
					'ssl'  => $request->getParam('ssl'),					
					'username' => $request->getParam('user'),
					'password' => $request->getParam('pass')			
				]
            ];
            $transport = $this->_objectManager->create($this->_instanceName, $data);
            if ($transport->testConnection()) {
				$response->setValid(true);
				$response->setMessage(__('Connection Successful'));
			} else {
				$response->setMessage(__('Connection Failed'));		
			}
        } 
        catch (\Exception $e) {
            $response->setMessage($e->getMessage());
        } 
        return $this;
    }
}  
