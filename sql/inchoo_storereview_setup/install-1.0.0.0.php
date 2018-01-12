<?php

/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('inchoo_store_review'))
    ->addColumn('review_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'unsigned' => true,
            'primary' => true,
            'nullable' => false
        ), 'Review ID')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false
        ), 'Customer ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false
        ), 'Store ID')
    ->addColumn('review_content', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false
        ), 'Review Content')
    ->addColumn('frontend_display', Varien_Db_Ddl_Table::TYPE_TINYINT, null,
        array(
            'default' => 0
        ), 'Frontend Display Flag')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Review date of creation')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Review date of update')
    ->setComment('Inchoo Store Review');

$installer->getConnection()->createTable($table);

$installer->endSetup();