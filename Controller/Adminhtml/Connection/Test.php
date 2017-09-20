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
namespace Faonni\Smtp\Controller\Adminhtml\Connection;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Connection as ConnectionAbstract;

/**
 * Smtp test connection controller
 */
class Test extends ConnectionAbstract
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Magento_Config::config_system';
        	
    /**
     * Result json factory instance 
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultFactory;
    
    /**
     * Transport instance name to create
     *
     * @var string
     */
    protected $_transportInstance;
    
    /**
     * Initialize Controller
     * 
     * @param Context $context
     * @param JsonFactory $resultFactory
     * @param string $transportInstance
     */
    public function __construct(
        Context $context,        
        JsonFactory $resultFactory,
        $transportInstance = 'Faonni\Smtp\Model\Transport'        
    ) {      
        $this->_resultFactory = $resultFactory;
        $this->_transportInstance = $transportInstance; 
              
        parent::__construct(
			$context
		);
    }
   
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */     
    public function execute()
    {
		$result = ['valid' => 0, 'message' => __('Connection Failed')];
        		
		try {
			$request = $this->getRequest();
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
            
            $transport = $this->_objectManager
				->create($this->_transportInstance, $data);
				
            if ($transport->testConnection()) {
				$result['valid'] = 1;
				$result['message'] = __('Connection Successful');
			} 
        } 
        catch (\Exception $e) {
            $result['message'] = $e->getMessage();
        }  
        
        $resultJson = $this->_resultFactory
			->create();
			
        return $resultJson->setData($result);
    }
}