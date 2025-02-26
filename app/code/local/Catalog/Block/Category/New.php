<?php
class Catalog_Block_Category_New extends Core_Block_Template
{

    public function getParentCategory()
    {
        $category = Mage::getModel("catalog/category");
        $collection = $category->getCollection();
        $data = $collection->getdata();
        // print_r($data);
        return $data;
    }
    public function getSingleCatData()
    {
        $request = Mage::getModel("core/request");
        $category_id = $request->getQuery("id");
        // print("the id is " . $category_id);

        // $catdata = Mage::getModel("catalog/category")->getCollection();
        // $catdata = $catdata->getdata();
        if ($category_id) {
            $data = Mage::getModel("catalog/category")
                ->load($category_id);

            return $data;
        } else {
            $data = Mage::getModel("catalog/category");
            return $data;
        }
    }
}
