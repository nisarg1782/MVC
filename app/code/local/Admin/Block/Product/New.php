<?php

class Admin_Block_Product_New extends Core_Block_Template
{
    public  $cat_data = [];
    public function __construct() {}
    public function getCategoryData()
    {
        $catdata = Mage::getModel("catalog/category")->getCollection();
        $this->cat_data = $catdata->getdata();
        return $this->cat_data;
    }
    public function getProdData()
    {
        
        $request = Mage::getModel("core/request");
        $product_id = $request->getQuery("product_id");
        print("the id is ".$product_id);
        $catdata = Mage::getModel("catalog/category")->getCollection();
        $this->cat_data = $catdata->getdata();
        if ($product_id) {
            $data = Mage::getModel("catalog/product")
                ->load($product_id);

            return $data;
        } else {
            $data = Mage::getModel("catalog/product");
            return $data;
        }
    }
    public function getHtmlField($field, $data)
    {
        $field = ucfirst(strtolower($field));
        $classname = "Admin_Block_Html_Elements_Text";
        $element = new $classname($field, $data);
        return $element->render();
    }
    public function getAttributes()
    {
        $model = Mage::getModel("catalog/attribute");
        $data = $model->getCollection()->getdata();
        return $data;
    }
    public function getProductData()
    {
        $request = Mage::getSingleton("core/request");
        $product_id = $request->getQuery("product_id");
        $data = Mage::getModel("catalog/product")
            ->load($product_id);
        if (!empty($data)) {
            return $data;
        }
    }
}
