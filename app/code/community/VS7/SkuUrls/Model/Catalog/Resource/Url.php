<?php

class VS7_SkuUrls_Model_Catalog_Resource_Url extends Mage_Catalog_Model_Resource_Url
{
    protected $_processedProducts = array(); // Eliminate multiple SQL queries for different categories as we have only one

    public function saveRewrite($rewriteData, $rewrite)
    {
        if (
            !empty($rewriteData['product_id'])
            && !in_array($rewriteData['product_id'], $this->_processedProducts[$rewriteData['store_id']])
        ) { // We leave only one last entry for product URL-rewrite and set category to null
                $this->clearProductRewrites($rewriteData['product_id'], $rewriteData['store_id']);
                $rewriteData['category_id'] = null;
                $this->_processedProducts[$rewriteData['store_id']][] = $rewriteData['product_id'];
                return parent::saveRewrite($rewriteData, $rewrite);
        } else if(empty($rewriteData['product_id'])) { // Save categories rewrites as usual
            return parent::saveRewrite($rewriteData, $rewrite);
        }
    }
}