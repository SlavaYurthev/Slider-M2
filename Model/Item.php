<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel {
	protected $storeManager;
	protected $directoryList;
	protected $io;
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Filesystem\DirectoryList $directoryList,
		\Magento\Framework\Filesystem\Io\File $io
	){
		$this->storeManager = $storeManager;
		$this->directoryList = $directoryList;
		$this->io = $io;
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\Slider\Model\ResourceModel\Item');
	}
	public function afterDelete(){
		try {
			$this->io->rmdir($this->directoryList->getRoot().'/media/slider/'.$this->getData('id').'/', true);
		} catch (\Exception $e) {}
		parent::afterDelete();
	}
	public function getStoreBaseUrl(){
		return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
	}
	public function getImageUrl(){
		return rtrim($this->getStoreBaseUrl(), '/').'/'.ltrim($this->getData('image'), '/');
	}
	protected function getImagePath(){
		return $this->directoryList->getRoot().'/'.ltrim($this->getData('image'), '/');
	}
	public function existsImage(){
		return is_file($this->getImagePath());
	}
	public function hasImage(){
		return ((bool)$this->getData('image') !== false && $this->existsImage());
	}
}