<?php

class Elgentos_RelatedBundles_Block_Adminhtml_Catalog_Product_Edit_Tab
extends Mage_Adminhtml_Block_Widget
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function canShowTab() 
    {
        /* Do not show the Related Bundles tab for bundled products itself */
        $product = Mage::registry('current_product');
        if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            return false;
        }
        return (($this->getRequest()->getActionName() === 'new') && (!$this->getRequest()->getParam('set')))
            ? false
            : true;
    }

    public function getTabLabel() 
    {
        return $this->__('Related Bundles');
    }

    public function getTabTitle()        
    {
        return $this->__('Related Bundles');
    }

    public function isHidden()
    {
        return false;
    }
    
    public function getTabUrl() 
    {
        return $this->getUrl('*/*/custom', array('_current' => true));
    }
    
    public function getTabClass()
    {
        return 'ajax';
    }

}
