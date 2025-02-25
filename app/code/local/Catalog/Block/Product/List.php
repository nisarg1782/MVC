<?php
class Catalog_Block_Product_List extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/product/list.phtml');
    }
    public function productData()
    {
        $cat = Mage::getModel("catalog/product")->getCollection()
            ->alias("name", "product_name")
            ->innerJoin(
                "catlog_category",
                "catlog_category.category_id = catlog_product.category_id",
                ["category_name" => "name"]
            );
        $data = $cat->getdata();

        return $data;
    }
}
