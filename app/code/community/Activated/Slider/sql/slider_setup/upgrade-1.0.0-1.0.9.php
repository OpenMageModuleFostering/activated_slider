<?php
$installer = $this;
$installer->startSetup();
/**
 * Create slider table
 */

if (Mage::getSingleton('core/resource')->getConnection('core_write')->isTableExists('permission_block')) {
	$installer->run("
		INSERT INTO permission_block (block_name, is_allowed) VALUES ('slider/slider', 1) ON DUPLICATE KEY UPDATE block_name=VALUES(block_name);
	");
}

$installer->endSetup();