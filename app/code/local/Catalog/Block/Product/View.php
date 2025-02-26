<?php


class Catalog_Block_Product_View extends Core_Block_Template
{
    public function __construct() {}
    public function getProduct()
    {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery("id");
        $cat = Mage::getModel("catalog/product")->getCollection()->addFieldToFilter("catalog_product.product_id", ["=" => $id])
            // ->alias("name", "product_name")
            ->innerJoin(
                "catalog_media_gallery",
                "catalog_product.product_id = catalog_media_gallery.product_id",
                []
            );
        $data = $cat->getdata();
        $attribute_data = Mage::getModel("catalog/product_attribute")->getCollection()
            ->addFieldToFilter("catalog_product_attribute.product_id", ["=" => $id])
            ->innerJoin("catalog_attribute", "catalog_product_attribute.attribute_id=catalog_attribute.attribute_id", []);
        $attr_data = $attribute_data->getdata();
        // print_r($data1);

        // SELECT * FROM `catalog_product_attribute` INNER JOIN catalog_attribute ON catalog_product_attribute.attribute_id=catalog_attribute.attribute_id  WHERE catalog_product_attribute.product_id=57
        $final_data = [$data, $attr_data];
        return $final_data;
        //    return $data;
    }
}
