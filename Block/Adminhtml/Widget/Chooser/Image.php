<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block\Adminhtml\Widget\Chooser;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {
	protected $_storeManager;
	public function __construct(
		\Magento\Backend\Block\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		array $data = []
	) {
		parent::__construct($context, $data);
		$this->_storeManager = $storeManager;
	}
	public function render(\Magento\Framework\DataObject $row){
		return '<img src="'.$this->_getValue($row).'" height="50"/>';
	}
}