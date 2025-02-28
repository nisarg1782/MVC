<?php


class Catalog_Block_Product_View extends Core_Block_Template
{
    public function __construct() {}
    public function getProduct()
    {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery("id");
        
        $cat = Mage::getModel("catalog/product")->getCollection()->addFieldToFilter("main_table.product_id", ["=" => $id])
            // ->alias("name", "product_name")
            ->innerJoin(
                ["cmg" => "catalog_media_gallery"],
                "main_table.product_id = cmg.product_id",
                ["file_path" => "file_path"]
            );
        $data = $cat->getdata();
        
        $attribute_data = Mage::getModel("catalog/product_attribute")->getCollection()
            ->addFieldToFilter("main_table.product_id", ["=" => $id])
            ->innerJoin(
                ["ca" => "catalog_attribute"],
                "main_table.attribute_id=ca.attribute_id",
                ["name" => "name"]
            );
        $attr_data = $attribute_data->getdata();
        // print_r($data1);

        // SELECT * FROM `catalog_product_attribute` INNER JOIN catalog_attribute ON catalog_product_attribute.attribute_id=catalog_attribute.attribute_id  WHERE catalog_product_attribute.product_id=57
        if(!empty($data) and !empty($attr_data))
        {
            $final_data = [$data, $attr_data];
            return $final_data;
        }
        else{
           $url=Mage::getBaseUrl();
           $list_url="catalog/product/list";
           $url.=$list_url;
           header("Location: ".$url);
exit;

        }
       
        //    return $data;
    }
}
