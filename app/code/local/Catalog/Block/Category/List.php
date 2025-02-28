<?php
class Catalog_Block_Category_List extends Core_Block_Template
{
    public function listCatdata()
    {
        $category = Mage::getModel("catalog/category")
            ->getCollection()->AddFieldToFilter("category_id",[">"=>0]);
        //echo "<pre>";
        $data = $category->getdata();
        print_r($data);
        die();
        return $data;
    }
   
}
