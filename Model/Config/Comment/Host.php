<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Comment;

use Magento\Config\Model\Config\CommentInterface;

/**
 * Host Field Comment
 */
class Host implements CommentInterface
{
    /**
     * Retrieve Element Comment by Element Value
     *
     * @param string $elementValue
     * @return string
     */
    public function getCommentText($elementValue)
    {
        return __('Either Hostname or IP address.');
    }
}
