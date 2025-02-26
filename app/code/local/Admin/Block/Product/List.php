<?php

class Admin_Block_Product_List extends Core_Block_Template
{
    public function listdata()
    {
        $product = Mage::getModel("catalog/product");
        $collection = $product->getCollection()->innerJoin("catalog_category", "catalog_category.category_id=catalog_product.category_id", []);
        $data = $collection->getdata();
        return $data;
    }
}
