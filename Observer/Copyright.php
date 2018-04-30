<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Observer;
class Copyright implements \Magento\Framework\Event\ObserverInterface {
	public function execute(\Magento\Framework\Event\Observer $observer){
		$observer->getLayout()->addBlock(
			'Magento\Framework\View\Element\Text', 
			'sy.copyright.slider', 
			'sy.copyright'
		)->setData(
			'text',
			'<a href="https://slavayurthev.github.io/magento-2/extensions/slider/">Magento 2 Slider Extension</a>'
		);
		return $this;
	}
}