<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Attachment;

use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\UrlInterface;
use \Magento\Store\Model\StoreRepository;

/**
 * Image Attachment
 */
class Image
{
    /**
     * Filesystem Directory List
     *
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;
    
    /**
     * IO File
     *
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $_ioFile;    
    
    /**
     * Store Repository
     *
     * @var \Magento\Store\Model\StoreRepository
     */
    protected $_storeRepository;    
    
    /**
     * Image Tag Pattern
     *
     * @var string
     */
    protected $_pattern = "#<img[^<>]+?src=['\"]([a-zA-Z0-9\.\/_:]+?)['\"][^<>]*?\>#si";
    
    /**
     * Store urls
     *
     * @var array
     */
    protected $_storeUrls;    
    
    /**
	 * Initialize Image Attachment
	 *	
     * @param DirectoryList $directoryList
     * @param File $ioFile     
     * @param StoreRepository $storeRepository
     */
    public function __construct(
        DirectoryList $directoryList,
        File $ioFile,
        StoreRepository $storeRepository
    ) {
        $this->_directoryList = $directoryList;
        $this->_ioFile = $ioFile;
        $this->_storeRepository = $storeRepository;
    }
	
    /**
     * Prepare Body Html
     *
     * @param MessageInterface $message 
     * @param string $body
     * @return string
     */
    public function prepareBodyHtml(MessageInterface $message, $body)
    {
        if (false === preg_match_all($this->_pattern, $body, $matches, PREG_SET_ORDER)) {
            return $body;
        }
        
        $message->setType(\Zend_Mime::MULTIPART_RELATED);        
        $images = array();
        foreach ($matches as $match) {
            list($matchString, $src) = $match;
            $filename = $this->_convertSrc($src);
            // Io File object does not contain some methods
            if (is_readable($filename)) {
                $cid = 'cid_' . md5_file($filename);
                if (isset($images[$cid])) {
                    continue;
                }            
                $this->_createImageAttachment($message, $filename, $cid);
                $body = str_replace($src,  'cid:' . $cid,  $body);
                $images[$cid] = $src;            
            }              
        }         
        return $body;
    }
    
    /**
     * Convert Image Src to Path
	 *
     * @param  string $src
     * @return string
     */
    protected function _convertSrc($src)
    {
        /* feature static content deploy */
        $this->_ioFile->read($src);
        $src = preg_replace("#pub\/static(.+?)\/frontend#", 'pub/static/frontend', $src);
        // @todo need to find a correct solution
        return $this->_directoryList->getRoot() . 
                DIRECTORY_SEPARATOR . 
                str_replace($this->_getStoreUrls(), '', $src);        
    }
    
    /**
     * Creates a Zend_Mime_Part image attachment
     *
     * @param MessageInterface $message     
     * @param string $filename
     * @param string $cid
     * @return void
     */
    protected function _createImageAttachment(MessageInterface $message, $filename, $cid)
    {
        $ttachment = $message->createAttachment(
            $this->_ioFile->read($filename)
        );  
        $ttachment->type = $this->_getMimeType($filename);  
        $ttachment->disposition = \Zend_Mime::DISPOSITION_INLINE;  
        $ttachment->encoding = \Zend_Mime::ENCODING_BASE64;        
        $ttachment->id = $cid;
    }
    
    /**
     * Retrieve Mime-Type for Image-Type
	 *
     * @param  string $filename
     * @return string
     */
    protected function _getMimeType($filename)
    {
        list($width, $height, $imageType, ) = getimagesize($filename);
        return image_type_to_mime_type($imageType);
    }
    
    /**
     * Retrieve store urls
     *
     * @return array
     */
    protected function _getStoreUrls()
    {
        if (null === $this->_storeUrls) {
            $this->_storeUrls = [];
            foreach ($this->_storeRepository->getList() as $store) {
                foreach ([true, false] as $secure) {
                    $url = $store->getBaseUrl(UrlInterface::URL_TYPE_LINK, $secure);
                    if (!in_array($url, $this->_storeUrls)) {
                        $this->_storeUrls[] = $url;
                    }                 
                }           
            }            
        }        
        return $this->_storeUrls;
    }    
}
