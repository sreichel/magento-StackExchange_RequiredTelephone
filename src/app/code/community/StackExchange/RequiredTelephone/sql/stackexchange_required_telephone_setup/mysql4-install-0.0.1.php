<?php
/* @var Mage_Customer_Model_Entity_Setup $installer */
$installer = Mage::getModel('customer/entity_setup', 'core_setup');

$installer->startSetup();
$installer->updateAttribute('customer_address', 'telephone', 'is_required', 0);
$installer->endSetup();
