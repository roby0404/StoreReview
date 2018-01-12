<?php

class Inchoo_StoreReview_Block_Adminhtml_Edit_Edit extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('inchoo_storereview/edit.phtml');
        $this->setId('review_edit');
    }

    protected function _prepareLayout()
    {
        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('inchoo_storereview')->__('Back'),
                'onclick' => "setLocation('{$this->getUrl('*/*/')}')",
                'class' => 'back'
            ))
        );

        $this->setChild('delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('inchoo_storereview')->__('Delete'),
                'onclick' => 'confirmSetLocation(\''. Mage::helper('inchoo_storereview')->__('Are you sure?') .'\',
                                                 \''. $this->getUrl('*/*/delete', ['review_id' => Mage::app()->getRequest()->getParam('review_id')]) .'\')',
                'class' => 'delete'
            ))
        );

        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('inchoo_storereview')->__('Save'),
                'onclick' => 'reviewForm.submit()',
                'class' => 'save'
            ))
        );

        return parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $review = Mage::getModel('inchoo_storereview/review')->load(Mage::app()->getFrontController()->getRequest()->getParam('review_id'));

        $form = new Varien_Data_Form(
            array(
                'id' => 'review_edit_form',
                'action' => $this->getUrl('*/*/save'),
                'method' => 'post'
            )
        );

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('inchoo_storereview')->__('Review'), 'class' => 'fieldset-wide'));

        $fieldset->addField('review_id', 'hidden', array(
            'name' => 'review_id'
        ));

        $fieldset->addField('customer_id', 'hidden', array(
            'name' => 'customer_id'
        ));

        $fieldset->addField('frontend_display', 'checkbox', array(
            'name' => 'frontend_display',
            'label' => Mage::helper('inchoo_storereview')->__('Frontend Display'),
            'title' => Mage::helper('inchoo_storereview')->__('Frontend Display'),
            'checked' => ($review->getFrontendDisplay() == 1) ? 'checked' : ''
        ));

        $fieldset->addField('review_content', 'textarea', array(
            'name' => 'review_content',
            'label' => Mage::helper('inchoo_storereview')->__('Review'),
            'title' => Mage::helper('inchoo_storereview')->__('Review'),
            'required' => true
        ));

        $form->setValues($review->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getSaveButton()
    {
        return $this->getChildHtml('save_button');
    }

    public function getBackButton()
    {
        return $this->getChildHtml('back_button');
    }

    public function getDeleteButton()
    {
        return $this->getChildHtml('delete_button');
    }
}