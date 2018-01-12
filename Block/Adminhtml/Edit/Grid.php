<?php

class Inchoo_StoreReview_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    const FRONTEND_DISPLAY_FLAG = array('Disabled', 'Enabled');

    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_storereview');
        $this->setDefaultSort('created_at');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inchoo_storereview/review')->getCollection();

        $reviews = $collection->getItems();

        foreach($collection->getItems() as $key => $val) {
            $collection->removeItemByKey($key);
        }

        foreach($reviews as $review) {
            $review->setData('customer_name', Mage::getModel('customer/customer')->load('137')->getName());
            $review->setData('frontend_display_flag', self::FRONTEND_DISPLAY_FLAG[$review->getFrontendDisplay()]);
           $collection->addItem($review);
        }

        $collection->setOrder('created_at', 'desc')->setOrder('frontend_display', 'desc');

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('customer_name', array(
            'header' => Mage::helper('inchoo_storereview')->__('Customer'),
            'index' => 'customer_name',
            'type' => 'text'
        ));

        $this->addColumn('review_content', array(
            'header' => Mage::helper('inchoo_storereview')->__('Review'),
            'index' => 'review_content',
            'type' => 'text'
        ));

        $this->addColumn('frontend_display_flag', array(
            'header' => Mage::helper('inchoo_storereview')->__('Frontend Display'),
            'index' => 'frontend_display_flag',
            'type' => 'text'
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('inchoo_storereview')->__('Creation time'),
            'index' => 'created_at',
            'type' => 'text',
            'sortable' => true
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('inchoo_storereview')->__('Action'),
            'type' => 'action',
            'getter' => 'getReviewId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('inchoo_storereview')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'review_id'
                )
            )
        ));

        return parent::_prepareColumns();
    }
}