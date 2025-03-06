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
        //$product_id = Core_Model_Request::getQuery("id");
        $request = Mage::getModel("core/request");
        $product_id = $request->getQuery("id");
        //print("the id is ".$product_id);
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
        $product_id = $request->getQuery("id");
        $data = Mage::getModel("catalog/product")
            ->load($product_id);//->joinLeft(
                // ["cmg"=>"catalog_media_gallery"],
                // "main_table.product_id=cmg.product_id AND cmg_product_id={$product_id}",
                // ["image"=>"file_path"]
            //);
            // print_r($data);
            // echo "<pre>";
        $data1=Mage::getModel("catalog/gallrey")->getCollection()->addFieldToFilter("product_id",["="=>$product_id]);
       $image_data=$data1->getData();
       
        // $attribute_data=Mage::getModel("catalog/product_attribute")->getCollection()->addFieldToFilter("product_id",["="=>$product_id]);
        // $att_data=$attribute_data->getData();
        // echo "<pre>";
        // print_r($att_data);
           
        // $tmp_data = $data->getData();
        
        // $attributes = Mage::getModel("catalog/product_attribute")->getCollection()->addFieldToFilter("product_id", ["=" => $product_id]);
        // $attr_data=$attributes->getData();
        // if (!is_null($tmp_data)) {
        //     // $reflection = new ReflectionClass($proddata);
        //     // $property = $reflection->getProperty('_data');
        //     // $property->setAccessible(true); // Allows access to protected property

        //     // $data1 = $property->getValue($proddata); // Get the actual array
        //     $keys = array_keys($tmp_data);

        //     // print_r($keys);
        // }

        if (!empty($data)) {
            return [$data,$image_data];
        }
    }
}
