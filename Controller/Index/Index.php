<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action {
	protected $resultPageFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	){
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}
	public function execute() {
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->set(__('Slava Yurthev Copyright'));
		$layout = $resultPage->getLayout();
		$layout->addBlock(
			'SY\Slider\Block\Copyright', 
			'sy.copyright', 
			'content'
		);
		$this->_eventManager->dispatch('sy.copyright', ['layout' => $layout]);
		return $resultPage;
	}
}