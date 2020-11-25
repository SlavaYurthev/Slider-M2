<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Model;

use \SY\Slider\Helper\Data as SliderHelper;

class Item extends \Magento\Framework\Model\AbstractModel {
	protected $sliderHelper;
	protected $io;
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\Filesystem\Io\File $io,
		SliderHelper $sliderHelper
	){
		$this->sliderHelper = $sliderHelper;
		$this->io = $io;
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\Slider\Model\ResourceModel\Item');
	}
	public function afterDelete(){
		try {
			$this->io->rmdir($this->sliderHelper->getUploadDir($this->getData('id')), true);
		} catch (\Exception $e) {}
		parent::afterDelete();
	}
	public function getImageUrl(){
		return $this->sliderHelper->getImageUrl($this->getData('image'));
	}
	public function hasImage(){
		return ((bool)$this->getData('image') !== false && is_file(
			$this->sliderHelper->getUploadDir($this->getData('image'))
		));
	}
}