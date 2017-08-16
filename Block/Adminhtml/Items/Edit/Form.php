<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block\Adminhtml\Items\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic {
	protected $_systemStore;
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\Data\FormFactory $formFactory,
		\Magento\Store\Model\System\Store $systemStore,
		array $data = []
	) {
		$this->_systemStore = $systemStore;
		parent::__construct($context, $registry, $formFactory, $data);
	}
	protected function _construct(){
		parent::_construct();
		$this->setId('item_form');
		$this->setTitle(__('Slider'));
	}
	protected function _prepareForm(){
		$form = $this->_formFactory->create(
			[
				'data' => [
					'id'     => 'edit_form',
					'action' => $this->getData('action'),
					'method' => 'post',
					'enctype'=> 'multipart/form-data'
				]
			]
		);
		$form->setUseContainer(true);
		$this->setForm($form);
 
		return parent::_prepareForm();
	}
}