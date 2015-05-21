<?php

class Elgentos_RelatedBundles_Block_Catalog_Product_List_Custom extends Mage_Catalog_Block_Product_Abstract
{
    protected $_mapRenderer = 'msrp_noform';

    protected $_itemCollection;

    protected function _prepareData()
    {
        $product = Mage::registry('product');

        $this->_itemCollection = $product->getCustomProductCollection()
            ->addAttributeToSelect('required_options')
            ->setPositionOrder()
            ->addStoreFilter()
        ;

        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection,
                Mage::getSingleton('checkout/session')->getQuoteId()
            );
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
        
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    public function getItems()
    {
        return $this->_itemCollection;
    }
}
