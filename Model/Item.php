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
}