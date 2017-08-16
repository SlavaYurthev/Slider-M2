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
	private $options;
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\Data\Collection $_collection,
			\Magento\Framework\Filesystem\DirectoryList $directoryList,
			\SY\Slider\Helper\Data $_helper,
			\SY\Slider\Model\Item $item,
			array $data = []
		){
		$collection = $item->getCollection()->addFieldToFilter('image', ['notnull'=>true])->setOrder('sort', 'asc');
		if($collection->count()>0){
			foreach ($collection as $item) {
				if(is_file($directoryList->getRoot().$item->getData('image'))){
					$_collection->addItem($item);
				}
			}
		}
		$this->_collection = $_collection;
		$this->_helper = $_helper;
		$this->options = [
			'auto'=>false,
			'controls'=>false,
			'pager'=>false
		];
		parent::__construct($context, $data);
	}
	public function getCollection(){
		return $this->_collection;
	}
	public function getOption($key){
		return $this->_helper->getConfigValue('options/'.$key);
	}
	public function getOptionFlag($key){
		return (bool)$this->getOption($key);
	}
	public function getOptions(){
		if(count($this->options)>0){
			foreach ($this->options as $key => $value) {
				$this->options[$key] = $this->getOptionFlag($key);
			}
		}
		$this->options['captions'] = true;
		return $this->options;
	}
	public function getOptionsJson(){
		return json_encode($this->getOptions());
	}
}