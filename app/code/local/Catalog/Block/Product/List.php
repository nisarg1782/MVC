<?php
class Catalog_Block_Product_List extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/product/list.phtml');
        $filter = $this->getLayout()->createBlock("catalog/product_list_filter");
        $product = $this->getLayout()->createBlock("catalog/product_list_products");
        $this->addChild("filter",$filter);
        $this->addChild("products",$product);
        // $this->createBlock("catalog/product_list_filter");
        // $this->createBlock("catalog/product_list_products");
    }
    public function productData()
    {
        // {
        $cat = Mage::getSingleton("catalog/filter")->getProductCollection()->joinLeft(
            ["cmg_img" => "catalog_media_gallery"],
            "main_table.product_id=cmg_img.product_id and cmg_img.default_file_path=1",
            ["image" => "file_path"]
        );

        $data = $cat->getdata();

        return $data;
    }
    public function getCategoryData()
    {
        $category_collection = Mage::getModel("catalog/category")->getCollection()
            ->addFieldToFilter("category_id", [">" => 0])
            ->addFieldToFilter("parent_id", ["IN" => ["null", 0]]);
        $category_data = $category_collection->getData();
        return $category_data;
    }
}
