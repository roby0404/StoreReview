<?php

class Inchoo_StoreReview_Model_Review extends Mage_Core_Model_Abstract
{

    protected $_eventPrefix = 'inchoo_storereview/review';
    protected $_eventObject = 'review';

    protected function _construct()
    {
        $this->_init('inchoo_storereview/review');
    }

}