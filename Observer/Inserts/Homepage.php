<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Observer\Inserts;

use Magento\Framework\Event\ObserverInterface;

class Homepage implements ObserverInterface {
	private $helper;
	private $cmsPage;
	public function __construct(
			\SY\Slider\Helper\Data $helper,
			\Magento\Cms\Model\Page $cmsPage
		){
		$this->helper = $helper;
		$this->cmsPage = $cmsPage;
	}
	public function execute(\Magento\Framework\Event\Observer $observer){
		if($this->helper->getConfigValue('inserts/homepage') == "1") {
			if($observer->getFullActionName() == 'cms_index_index'){
				if($this->cmsPage->getIdentifier() == 'home'){
					$observer->getLayout()->getUpdate()->addHandle('sy_slider_insert');
				}
			}
		}
	}
}