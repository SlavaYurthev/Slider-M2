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
		return $this->resultPageFactory->create();
	}
}