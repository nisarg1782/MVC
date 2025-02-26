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
            // ->alias("name", "product_name")
            ->innerJoin(
                "catalog_media_gallery",
                "catalog_product.product_id = catalog_media_gallery.product_id",
                []
            )->GroupBy(["catalog_product.product_id"]);
        $data = $cat->getdata();
    

        return $data;
    }
}
