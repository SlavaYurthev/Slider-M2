<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
	const UPLOAD_DIR = 'slider';
	protected $urlBuilder;
	protected $scopeConfig;
	protected $fileSystem;
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Filesystem $fileSystem
	){
		$this->fileSystem = $fileSystem;
		$this->urlBuilder = $context->getUrlBuilder();
		$this->scopeConfig = $context->getScopeConfig();
		parent::__construct($context);
	}
	public function getConfigValue($field, $storeId = null){
		return $this->scopeConfig->getValue('sy_slider/'.$field, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
	}
	public function getUploadDir($path = null){
		if(!is_null($path)){
			return rtrim($this->getUploadDir(), '/').'/'.ltrim($path);
		}
		return $this->getMediaPath(self::UPLOAD_DIR);
	}
	public function getMediaPath($path = null){
		if(!is_null($path)){
			return rtrim($this->getMediaPath(), '/').'/'.ltrim($path);
		}
		return $this->fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
	}
	public function getImageUrl($image){
		return $this->urlBuilder->getDirectUrl(
			self::UPLOAD_DIR.'/'.ltrim($image, '/'), 
			['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]
		);
	}
}