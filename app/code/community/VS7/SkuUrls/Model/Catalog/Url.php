<?php

class VS7_SkuUrls_Model_Catalog_Url extends Mage_Catalog_Model_Url {

    protected $_rootCategories = array();

    public function getProductRequestPath($product, $category)
    {
        $storeId = $category->getStoreId();

//        if (isset($this->_rootCategories[$storeId])) {
//            $rootCategory = $this->_rootCategories[$storeId];
//        } else {
//            $rootCategoryId = Mage::app()->getStore($storeId)->getRootCategoryId();
//            if (isset($this->_categories[$rootCategoryId])) {
//                $rootCategory = $this->_categories[$rootCategoryId];
//            } else {
//                $rootCategory = $this->getResource()->getCategory($rootCategoryId, $storeId);
//            }
//            $this->_rootCategories[$storeId] = $rootCategory;
//        }
//        return parent::getProductRequestPath($product, $rootCategory);

        if ($product->getUrlKey() == '') {
            $urlKey = $this->getProductModel()->formatUrlKey($product->getName());
        } else {
            $urlKey = $this->getProductModel()->formatUrlKey($product->getUrlKey());
        }
        $suffix = $this->getProductUrlSuffix($storeId);
        return $urlKey . $suffix;
    }

    public function getCategoryRequestPath($category, $parentPath)
    {
        $original = parent::getCategoryRequestPath($category, '/');
        return $original;
    }
}