<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Comment;

use Magento\Config\Model\Config\CommentInterface;

/**
 * System configuration comment model
 */
class Port implements CommentInterface
{
    /**
     * Retrieve element comment by element value
     * 
     * @param string $elementValue
     * @return string
     */	
	public function getCommentText($elementValue)
    {
        return __('Usually is 25, 587 or 465. Please consult with your service provider.');
    }
}
