<?php

class Admin_Block_Product_New extends Core_Block_Template
{
    public  $cat_data = [];
    public function __construct()
    {
    }
    public function getProdData()
    {
        
        //$product_id = Core_Model_Request::getQuery("id");
        $request=Mage::getModel("core/request");
        $product_id=$request->getQuery("id");
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
        $element = new $classname($field,$data);
        return $element->render();
    }
}
