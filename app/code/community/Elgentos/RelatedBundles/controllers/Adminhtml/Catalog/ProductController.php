<?php

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');

class Elgentos_RelatedBundles_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    /**
     * Get customd products grid and serializer block
     */
    public function customAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('catalog.product.edit.tab.custom')
            ->setProductsCustom($this->getRequest()->getPost('products_custom', null));
        $this->renderLayout();
    }

    /**
     * Get custom products grid
     */
    public function customGridAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('catalog.product.edit.tab.custom')
            ->setProductsCustom($this->getRequest()->getPost('products_custom', null));
        $this->renderLayout();
    }

}
