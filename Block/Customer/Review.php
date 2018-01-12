<?php

class Inchoo_StoreReview_Block_Customer_Review extends Mage_Core_Block_Template
{
    public function getSaveUrl()
    {
        return '/review/review/save';
    }

    public function checkReview()
    {
        $review = $this->getReviews();

        return ($review == 0 || $review > 1) ? false : true;
    }

    protected function getReviews()
    {
        return Mage::getModel('inchoo_storereview/review')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getId())
            ->addFieldToFilter('store_id', Mage::app()->getStore()->getId())->count();
    }

    public function getReview()
    {
        return Mage::getModel('inchoo_storereview/review')->load(Mage::getSingleton('customer/session')->getId(), 'customer_id');
    }

    public function getDeleteUrl()
    {
        return '/review/review/delete';
    }

    public function getEditFormUrl()
    {
        return '/review/review/form';
    }

    public function getEditUrl()
    {
        return '/review/review/edit';
    }
}