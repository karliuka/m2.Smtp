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

/**
 * Smtp params observer
 */
class ParamsObserver implements ObserverInterface
{
    /**
     * Handler for smtp params event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		$button = $observer->getEvent()->getButton();
		$params = [
			'host' => 'system_smtp_host',
			'port' => 'system_smtp_port',
			'ssl'  => 'system_smtp_ssl',
			'auth' => 'system_smtp_auth',
			'user' => 'system_smtp_user',
			'pass' => 'system_smtp_pass'			
		];		
		$button->setParam($params);		
		return $this;
    }
} 
