<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block;

class Slider extends \Magento\Framework\View\Element\Template {
	private $_collection;
	private $_helper;
	private $_directory;
	private $_options;
	public $_template = 'SY_Slider::slider.phtml';
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\Filesystem\DirectoryList $directoryList,
			\SY\Slider\Helper\Data $helper,
			\SY\Slider\Model\ResourceModel\Item\CollectionFactory $collectionFactory,
			array $data = []
		){
		$this->_collection = $collectionFactory->create();
		$this->_helper = $helper;
		$this->_directory = $directoryList;
		$this->_options = [
			'auto'=>false,
			'controls'=>false,
			'pager'=>false,
			'adaptiveHeight'=>false
		];
		parent::__construct($context, $data);
	}
	public function getCollection(){
		$collection = $this->_getCollection();
		if($collection->count()>0){
			foreach ($collection as $key => $item) {
				// unset items without images
				if(!$this->hasImage($item)){
					$collection->removeItemByKey($key);
				}
			}
		}
		return $collection;
	}
	public function _getCollection(){
		$collection = $this->_collection;
		if($this->getIds()){
			$collection->addFieldToFilter('id', ['in' => $this->getIds()]);
		}
		$collection->addFieldToFilter('image', ['notnull' => true]);
		$collection->addFieldToFilter('active', true);
		$collection->setOrder('sort', 'asc');
		return $collection;
	}
	private function getIds(){
		if($this->getData('ids')){
			if(is_array($this->getData('ids'))){
				return $this->getData('ids');
			}
			elseif(is_string($this->getData('ids'))){
				$ids = preg_replace('/\s+/', '', $this->getData('ids'));
				return explode(",", $ids);
			}
		}
	}
	public function hasImage(\SY\Slider\Model\Item $item){
		if($item->getData('image') && is_file($this->_directory->getRoot().$item->getData('image'))){
			return true;
		}
	}
	public function getOption($key){
		return $this->_helper->getConfigValue('options/'.$key, $this->_storeManager->getStore()->getId());
	}
	public function getOptionFlag($key){
		return (bool)$this->getOption($key);
	}
	public function getOptions(){
		if(count($this->_options)>0){
			foreach ($this->_options as $key => $value) {
				$this->_options[$key] = $this->getOptionFlag($key);
			}
		}
		$this->_options['captions'] = true;
		return $this->_options;
	}
	public function getOptionsJson(){
		return json_encode($this->getOptions());
	}
}