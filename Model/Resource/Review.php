<?php

class Inchoo_StoreReview_Model_Resource_Review extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('inchoo_storereview/review', 'review_id');
    }

}