<?php

class VS7_SkuUrls_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    public function match(Zend_Controller_Request_Http $request)
    {
        $requestString = $request->getRequestString();
        $pattern = '/^\/p\-(\d{6})\.html$/';
        if (preg_match($pattern, $requestString, $matches)) {
            $sku = $matches[1];
            $productId = Mage::getModel("catalog/product")->getIdBySku($sku);
            if (empty($productId)) {
                return false;
            }
            $resource = Mage::getSingleton('core/resource');
            $tableName = $resource->getTableName('catalog_category_product');
            $adapter = $resource->getConnection('core_read');
            $select = $adapter->select()->from($tableName, 'category_id')->where('product_id = ?', $productId);
            $res = $adapter->fetchCol($select);
            $categoryId = $res[0];
        } else {
            return false;
        }
        if (empty($productId) || empty($categoryId)) {
            return false;
        }

        $front = $this->getFront();
        $module = 'catalog';
        $request->setRouteName('catalog');
        $controller = 'product';
        $action = 'view';
        $realModule = 'Mage_Catalog';
        $controllerClassName = $this->_validateControllerClassName($realModule, $controller);
        $controllerInstance = Mage::getControllerInstance($controllerClassName, $request, $front->getResponse());

        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setControllerModule($realModule);
        $request->setParam('id', $productId);
        $request->setParam('category', $categoryId);

        $request->setDispatched(true);
        $controllerInstance->dispatch($action);
        Mage::getModel('catalog/url')->refreshProductRewrite($productId);
        return true;
    }
}