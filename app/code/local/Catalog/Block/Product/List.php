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
                ["cmg" => "catalog_media_gallery"],
                "main_table.product_id = cmg.product_id",
                ["image" => "file_path"]
            )->GroupBy(["product_id"]);

        
            $data = $cat->getdata(); // Fetch product data

           
          
            
            echo "<pre>";
            
        
          
            

        return $data;
    }
}
