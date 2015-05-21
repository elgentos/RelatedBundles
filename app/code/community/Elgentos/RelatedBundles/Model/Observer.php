<?php

class Elgentos_RelatedBundles_Model_Observer extends Varien_Object
{
    public function catalogProductPrepareSave($observer)
    {
        $event = $observer->getEvent();

        $product = $event->getProduct();
        $request = $event->getRequest();

        $links = $request->getPost('links');
        if (isset($links['custom']) && !$product->getCustomReadonly()) {
            $product->setRelatedBundleData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['custom']));
        }

        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            $this->setRelatedBundlesForSimpleProducts($product);
        }
    }

    public function catalogModelProductDuplicate($observer)
    {
        $event = $observer->getEvent();

        $currentProduct = $event->getCurrentProduct();
        $newProduct = $event->getNewProduct();

        $data = array();
        $currentProduct->getLinkInstance()->useRelatedBundles();
        $attributes = array();
        foreach ($currentProduct->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($currentProduct->getRelatedBundleCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $newProduct->setRelatedBundleData($data);
    }

    /*
    This function is run when a product that is saved is a bundle.
    The bundled product will be set as a 'Related Bundle' for the products
    that the bundled product is comprised of.
    */
    public function setRelatedBundlesForSimpleProducts($bundleProduct)
    {
        $selectionCollection = $bundleProduct->getTypeInstance(true)->getSelectionsCollection(
            $bundleProduct->getTypeInstance(true)->getOptionsIds($bundleProduct), $bundleProduct
        );
        foreach($selectionCollection as $option) {
            try {
                $_product = Mage::getModel('catalog/product')->load($option->getEntityId());
                if($_product->getId()) {
                    $customLinkData = array();
                    foreach($_product->getRelatedBundleCollection() as $customLink) {
                        $customLinkData[$customLink->getLinkedProductId()]['position'] = $customLink->getPosition();
                    }
                    $customLinkData[$bundleProduct->getId()] = array('position' => 0);
                    $_product->setRelatedBundleData($customLinkData)->save();
                    Mage::getSingleton('adminhtml/session')->addSuccess('Added ' . $bundleProduct->getSku() . ' as a Related Bundle to product ' . $_product->getSku());
                }
            } catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError('Could not set bundled product as Related Bundle for product ' . $option->getSku() . '; ' . $e->getMessage());
            }
        }

    }

}