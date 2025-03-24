<?php
class Catalog_Block_Product_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {

        $this->setTemplate('catalog/product/list.phtml');

        $filter = $this->getLayout()->createBlock("catalog/product_list_filter");
        $this->addChild("filter", $filter);



        $product = $this->getLayout()->createBlock("catalog/product_list_products");

        $this->addChild("products", $product);
        // $toolbar = $this->getLayout()->createBlock("catalog/grid_toolbar")
        // ->setTemplate("catalog/grid/toolbar.phtml");
        // $this->addChild("toolbar",$toolbar);
        // $this->init();   
    }

    public function getCategoryData()
    {
        $category_collection = Mage::getModel("catalog/category")->getCollection()

            ->addFieldToFilter("parent_id", ["IN" => ["NULL"]]);
        $category_data = $category_collection->getData();
        return $category_data;
    }
    public function getAttData()
    {
        $product = Mage::getModel("catalog/product_attribute")
            ->getCollection()
            ->addFieldToFilter(
                "attribute_id",
                1
            )->getData();
        // echo "<pre>";
        $color = [];
        // print_r($product);
        foreach ($product as $data) {
            array_push($color, $data->getValue());
        }
        $color = array_unique($color);
        return $color;
    }
}
