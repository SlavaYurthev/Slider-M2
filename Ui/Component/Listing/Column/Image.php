<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
	protected $itemFactory;
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		\SY\Slider\Model\ItemFactory $itemFactory,
		array $components = [],
		array $data = []
	) {
		$this->itemFactory = $itemFactory;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}
	public function prepareDataSource(array $dataSource) {
		if(isset($dataSource['data']['items'])) {
			foreach($dataSource['data']['items'] as & $item) {
				if($item) {
					if(isset($item['id'])){
						$_item = $this->itemFactory->create()->load($item['id']);
						if($_item->hasImage()){
							$item['image_src'] = $_item->getImageUrl();
						}
					}
				}
			}
		}
		return $dataSource;
	}
}