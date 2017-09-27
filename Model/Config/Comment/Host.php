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
class Host implements CommentInterface
{
    /**
     * Retrieve element comment by element value
     * 
     * @param string $elementValue
     * @return string
     */	
	public function getCommentText($elementValue)
    {
        return __('Either host name or IP address.');
    }
}
