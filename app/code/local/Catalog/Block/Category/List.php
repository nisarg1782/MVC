<?php
class Catalog_Block_Category_List extends Core_Block_Template
{
    public function listCatdata()
    {
        $category = Mage::getModel("catalog/category")
            ->getCollection();
        //echo "<pre>";
        $data = $category->getdata();
        return $data;
    }
}
