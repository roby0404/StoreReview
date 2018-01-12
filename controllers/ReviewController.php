<?php

class Inchoo_StoreReview_ReviewController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        if(!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    public function indexAction()
    {
        $this->loadLayout();

        $this->renderLayout();
    }

    public function saveAction()
    {
        $review = Mage::app()->getFrontController()->getRequest()->getPost('review');

        $reviewCollection = Mage::getModel('inchoo_storereview/review')->getCollection()
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getId())
            ->addFieldToFilter('store_id', Mage::app()->getStore()->getId())->count();

        if($reviewCollection >= 1) {
            return $this->_redirectUrl('/review/review');
        }

        $reviewModel = Mage::getModel('inchoo_storereview/review');

        $reviewModel->setData([
            'customer_id' => Mage::getSingleton('customer/session')->getId(),
            'store_id' => Mage::app()->getStore()->getId(),
            'review_content' => $review,
            'created_at' => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s')
            ]);

        try {
            $reviewModel->save();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_storereview')->__('Store Review saved!'));
        } catch (\Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not saved!'));
        }

       return $this->_redirectUrl('/review/review');
    }

    public function deleteAction()
    {
        $reviewModel = Mage::getModel('inchoo_storereview/review')->load(Mage::getSingleton('customer/session')->getId(), 'customer_id');

        try {
            $reviewModel->delete();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_storereview')->__('Store Review deleted!'));
        } catch (\Exception $e) {
           Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not deleted'));
        }

        return $this->_redirectUrl('/review/review');
    }

    public function formAction()
    {
        $this->loadLayout();

        $this->renderLayout();
    }

    public function editAction()
    {
        $review = Mage::app()->getFrontController()->getRequest()->getPost('review');

        $reviewModel = Mage::getModel('inchoo_storereview/review')->load(Mage::getSingleton('customer/session')->getId(), 'customer_id');

        $reviewModel->setData('review_content', $review);

        if($reviewModel->getFrontendDisplay() == 1) {
            $reviewModel->setData('frontend_display', 0);
        }

        try {
            $reviewModel->save();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_storereview')->__('Review edited'));
        } catch (\Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not edited'));
        }

        return $this->_redirectUrl('/review/review');
    }
}