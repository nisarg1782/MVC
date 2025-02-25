<?php
class Catalog_Block_Category_New extends Core_Block_Template
{
   
    public function getParentCategory()
    {
        $category = Mage::getModel("catalog/category");
        $collection=$category ->getCollection();
        $data = $collection->getdata();
        // print_r($data);
        return $data;
    }
}
?>