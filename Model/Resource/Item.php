<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb {
	protected function _construct() {
		$this->_init('sy_slider', 'id');
	}
}