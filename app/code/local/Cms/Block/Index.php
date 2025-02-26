<?php
class Cms_Block_Index extends Core_Block_Template
{
    public function __construct()
    {
        
    }
    public function getProducts()
    {
        $request = Mage::getModel("core/request");
        // $id = $request->getQuery("id");
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
?>