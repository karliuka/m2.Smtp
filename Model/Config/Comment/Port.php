<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Comment;

use Magento\Config\Model\Config\CommentInterface;

/**
 * Port Field Comment
 */
class Port implements CommentInterface
{
    /**
     * Retrieve Element Comment by Element Value
     * 
     * @param string $elementValue
     * @return string
     */	
	public function getCommentText($elementValue)
    {
        return __('Usually is 25, 587 or 465. Please consult with your service provider.');
    }
}
