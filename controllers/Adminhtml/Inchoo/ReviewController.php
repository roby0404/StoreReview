<?php

class Inchoo_StoreReview_Adminhtml_Inchoo_ReviewController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('report/review/inchoo_storereview');
        $this->_addContent($this->getLayout()->createBlock('inchoo_storereview/adminhtml_edit'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('inchoo_storereview/adminhtml_edit_grid')->toHtml()
        );
    }

    public function editAction()
    {
        $this->loadLayout();

        $this->_addContent($this->getLayout()->createBlock('inchoo_storereview/adminhtml_edit_edit'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = Mage::app()->getRequest()->getPost();

        $review = Mage::getModel('inchoo_storereview/review')->load($data['review_id']);

        if($data['customer_id'] !== $review->getCustomerId()) {
            Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not valid'));
            return $this->_redirect('*/*/edit', ['review_id' => $data['review_id']]);
        }

        $frontendDisplay = isset($data['frontend_display']) ? 1 : 0;

        $review->setData('frontend_display', $frontendDisplay);
        $review->setData('review_content', $data['review_content']);

        try {
            $review->save();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_storereview')->__('Review updated!'));
        } catch (\Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not updated'));
        }

        return $this->_redirect('*/*/edit', ['review_id' => $data['review_id']]);
    }

    public function deleteAction()
    {
        $id = Mage::app()->getRequest()->getParam('review_id');

        $review = Mage::getModel('inchoo_storereview/review')->load($id);

        try {
            $review->delete();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('inchoo_storereview')->__('Review deleted!'));
        } catch (\Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('inchoo_storereview')->__('Review not deleted'));
        }

        return $this->_redirect('*/*/');
    }
}