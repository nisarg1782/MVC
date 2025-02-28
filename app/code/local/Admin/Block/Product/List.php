<?php

class Admin_Block_Product_List extends Core_Block_Template
{
    public function listdata()
    {
        $product = Mage::getModel("catalog/product");

        $collection = $product->getCollection()->innerJoin(
            ["cat_table" => "catalog_category"],
            "cat_table.category_id = main_table.category_id",
            ["category_name" => "name"]
        );
        $data = $collection->getdata();
        return $data;
    }
}
