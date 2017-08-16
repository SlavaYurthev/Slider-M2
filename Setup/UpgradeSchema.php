<?php
/**
 * Slider
 * 
 * @author Slava Yurthev
 */
namespace SY\Slider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface {
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();
		if(version_compare($context->getVersion(), '0.0.2') < 0) {
			$setup->getConnection()->addColumn(
				$setup->getTable('sy_slider'),
				'url',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'length' => 255,
					'nullable' => true,
					'comment' => 'Url'
				]
			);
		}
		$setup->endSetup();
	}
}