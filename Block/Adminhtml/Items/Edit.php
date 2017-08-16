<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block\Adminhtml\Items;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {
	protected $_coreRegistry = null;
	public function __construct(
		\Magento\Backend\Block\Widget\Context $context,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {
		$this->_coreRegistry = $registry;
		parent::__construct($context, $data);
	}
	protected function _construct(){
		$this->_objectId = 'item_id';
		$this->_blockGroup = 'SY_Slider';
		$this->_controller = 'adminhtml_items';
		parent::_construct();
		if ($this->_isAllowedAction('SY_Slider::items')) {
			$this->buttonList->remove('reset');
			$this->buttonList->update('save', 'label', __('Save Item'));
			$this->buttonList->add(
				'saveandcontinue',
				[
					'label' => __('Save and Continue Edit'),
					'class' => 'save',
					'data_attribute' => [
						'mage-init' => [
							'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
						],
					]
				],
				-100
			);
		} else {
			$this->buttonList->remove('save');
		}
		if ($this->_isAllowedAction('SY_Slider::items')) {
			$this->buttonList->update('delete', 'label', __('Delete Item'));
		} else {
			$this->buttonList->remove('delete');
		}
	}
	public function getHeaderText(){
		if ($this->_coreRegistry->registry('slider_item')->getId()) {
			return __("Edit Item '%1'", $this->escapeHtml($this->_coreRegistry->registry('slider_item')->getId()));
		} else {
			return __('New Item');
		}
	}
	protected function _isAllowedAction($resourceId){
		return $this->_authorization->isAllowed($resourceId);
	}
	protected function _getSaveAndContinueUrl(){
		return $this->getUrl('sy_slider/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
	}
	protected function _prepareLayout(){
		$this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('general_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'general_content');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'general_content');
				}
			};
		";
		return parent::_prepareLayout();
	}
}