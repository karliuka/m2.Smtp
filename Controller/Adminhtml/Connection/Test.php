<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml\Connection;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Backend\App\Action\Context;
use Faonni\Smtp\Controller\Adminhtml\Connection as ConnectionAbstract;
use Faonni\Smtp\Helper\Data as SmtpHelper;

/**
 * Test Connection Controller
 */
class Test extends ConnectionAbstract
{
    /**
     * Authorization Level of a Basic Admin Session
     */
    const ADMIN_RESOURCE = 'Magento_Config::config_system';
        	
    /**
     * Result Json Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultFactory;
    
    /**
     * Transport Instance Name to Create
     *
     * @var string
     */
    protected $_transportInstance;
    
    /**
     * Helper
     *
     * @var \Faonni\Smtp\Helper\Data
     */
    protected $_smtpHelper; 
    
    /**
     * Encryptor
     *
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $_encryptor;     
    
    /**
     * Initialize Controller
     * 
     * @param Context $context
     * @param JsonFactory $resultFactory
     * @param SmtpHelper $helper
     * @param EncryptorInterface $encryptor     
     * @param string $transportInstance     
     */
    public function __construct(
        Context $context,        
        JsonFactory $resultFactory,
        SmtpHelper $helper,
        EncryptorInterface $encryptor,
        $transportInstance = 'Faonni\Smtp\Model\Transport'        
    ) {      
        $this->_resultFactory = $resultFactory;
        $this->_smtpHelper = $helper;
        $this->_encryptor = $encryptor;
        $this->_transportInstance = $transportInstance; 
              
        parent::__construct(
			$context
		);
    }
   
    /**
     * Test Connection
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */     
    public function execute()
    {
		$result = ['valid' => 0, 'message' => ''];
        		
		try {
			$request = $this->getRequest();
			
			$storeId = $request->getParam('store', null);
			$password = $request->getParam('pass');
            /* if an obscured value came */
            if (preg_match('#^\*+$#', $password)) {
                $password = $this->_smtpHelper->getPassword($storeId);
            }
            /* if an encrypted value came */
            elseif (base64_encode(base64_decode($password)) === $password) {
                $decrypted = $this->_encryptor->decrypt($password);
                if (ctype_print($decrypted)) {
                    $password = $decrypted;
                }
            }
            
            $data = [
				'host' => $request->getParam('host'),
				'config' => [
					'port' => $request->getParam('port'),
					'auth' => $request->getParam('auth'),
					'ssl'  => $request->getParam('ssl'),					
					'username' => $request->getParam('user'),
					'password' => $password			
				]
            ];
            
            $transport = $this->_objectManager
				->create($this->_transportInstance, $data);
				
            if ($transport->testConnection()) {
				$result['valid'] = 1;
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