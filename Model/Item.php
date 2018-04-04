<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel {
	protected function _construct() {
		$this->_init('SY\Slider\Model\ResourceModel\Item');
	}
	public function afterDelete(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
		$io = $objectManager->get('Magento\Framework\Filesystem\Io\File');
		try {
			$io->rmdir($directory->getPath('pub').'/media/slider/'.$this->getData('id').'/', true);
		} catch (\Exception $e) {}
		parent::afterDelete();
	}
}
