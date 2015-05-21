<?php

class Elgentos_RelatedBundles_Model_Catalog_Product_Link extends Mage_Catalog_Model_Product_Link
{
    const LINK_TYPE_CUSTOM   = 6;

    /**
     * @return Mage_Catalog_Model_Product_Link
     */
    public function useRelatedBundles()
    {
        $this->setLinkTypeId(self::LINK_TYPE_CUSTOM);
        return $this;
    }

    /**
     * Save data for product relations
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  Mage_Catalog_Model_Product_Link
     */
    public function saveProductRelations($product)
    {
        parent::saveProductRelations($product);

        $data = $product->getRelatedBundleData();
        if (!is_null($data)) {
            $this->_getResource()->saveProductLinks($product, $data, self::LINK_TYPE_CUSTOM);
        }

    }
}