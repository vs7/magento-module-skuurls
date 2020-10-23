<?php

class VS7_SkuUrls_Model_Observer
{
    public function setProductUrlKey($observer)
    {
        $eventName = $observer->getEvent()->getName();
        if ($eventName == 'onec_product_array_edit_before_save') {
            $product = $observer->getValideProduct();
        } else { //catalog_product_save_before
            $product = $observer->getProduct();
        }
        $sku = $product->getSku();
        $product->setUrlKey('p-' . $sku);
    }

    public function setCategoryUrlKey($observer)
    {
        $category = $observer->getCategory();
        $category->setUrlKey('c-' . $category->getId());
    }
}