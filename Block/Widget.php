<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Block;

class Widget extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {
	protected function _toHtml(){
		return $this->getLayout()->createBlock(
			\SY\Slider\Block\Slider::class,
			'',
			[
				'data' => [
					'ids' => explode(",", $this->getData('ids'))
				]
			]
		)->toHtml();
	}
}