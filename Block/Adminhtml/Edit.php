<?php

class Inchoo_StoreReview_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'inchoo_storereview';
        $this->_controller = 'adminhtml_edit';
        $this->_headerText = Mage::helper('inchoo_storereview')->__('Store Reviews');

        parent::__construct();
    }
}