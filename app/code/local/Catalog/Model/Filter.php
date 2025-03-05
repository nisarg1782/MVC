<?php
class Catalog_Model_Filter extends Core_Model_Abstract
{
    public function getProductCollection()
    {
        $collection = Mage::getModel("catalog/product")->getCollection();
        $this->applyFilter($collection);
        return $collection;
    }
    public function applyFilter($collection)
    {
        $request = Mage::getSingleton("core/request");
        // echo "<pre>";
        $parametr = $request->getQuery();
        if (isset($parametr["cid"])) {
        //    var_dump($parametr["cid"]);
        //    die;
       if($parametr["cid"]=="")
       {
        unset($parametr["cid"]);
       }else{
            $collection->addCategoryFilter($parametr["cid"]);
            // return $this;
            unset($parametr["cid"]);
        }
    }
        
        // print_r(array_keys($parametr));
        // die;
        $attribute_collection = Mage::getModel("catalog/attribute")->getCollection()
            ->addFieldToFilter("name", ["IN" => array_keys($parametr)]);
            // print_r($attribute_collection->getData());
            // die;
            // print_r($attribute_collection->prepareQuery());
            // die;
            //   echo "<pre>";
            // print_r($attribute_collection->getData());
            // die;
        foreach ($attribute_collection->getData() as $attributedata) {
            // print_r($attributedata);
            $collection->addAttributeToFilter($attributedata->getName(),["="=>$parametr[$attributedata->getName()]]);
        }
    }
}
