<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Controller\Adminhtml\Items;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Save extends Action {
	protected $_resultPageFactory;
	protected $_resultPage;
	public function __construct(
			Context $context, 
			PageFactory $resultPageFactory
		){
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}
	public function execute(){
		$object_manager = $this->_objectManager;
		$directory = $object_manager->get('\Magento\Framework\Filesystem\DirectoryList');
		$data = $this->getRequest()->getPostValue();
		$resultRedirect = $this->resultRedirectFactory->create();
		$id = $this->getRequest()->getParam('id');
		$model = $this->_objectManager->create('SY\Slider\Model\Item');
		$image = false;
		if($id) {
			$model->load($id);
			if($model->getData('image')){
				$image = $model->getData('image');
			}
		}
		$model->setData($data);
		try {
			$model->save();
			try {
				$uploader = new \Magento\MediaStorage\Model\File\Uploader(
					'image',
					$object_manager->create('Magento\MediaStorage\Helper\File\Storage\Database'),
					$object_manager->create('Magento\MediaStorage\Helper\File\Storage'),
					$object_manager->create('Magento\MediaStorage\Model\File\Validator\NotProtectedExtension')
				);
				$uploader->setAllowCreateFolders(true);
				$uploader->setAllowedExtensions(['jpeg','jpg','png']);
				if ($uploader->save($directory->getPath('pub').'/media/slider/'.$model->getId().'/')) {
					$filename = $uploader->getUploadedFileName();
					$model->setData('image', '/media/slider/'.$model->getId().'/'.$filename);
					try {
						$model->save();
						if($image){
							@unlink($directory->getPath('pub').$image);
						}
					} catch (\Exception $e) {
						$this->messageManager->addException($e, $e->getMessage());
					}
				}
			} catch (\Exception $e) {
				if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
					$this->messageManager->addException($e, $e->getMessage());
				}
			}
			$this->messageManager->addSuccess(__('Saved.'));
			if ($this->getRequest()->getParam('back')) {
				return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
			}
			$this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
			return $resultRedirect->setPath('*/*/');
		} catch (\Exception $e) {
			$this->messageManager->addException($e, __('Something went wrong.'));
		}
		$this->_getSession()->setFormData($data);
		return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
	}
	protected function _isAllowed(){
		return $this->_authorization->isAllowed('SY_Slider::items');
	}
}
