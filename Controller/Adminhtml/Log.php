<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Abstract Log Controller
 */
abstract class Log extends Action
{
    /**
     * Authorization Level of a Basic Admin Session
     */
    const ADMIN_RESOURCE = 'Faonni_Smtp::log';
} 
