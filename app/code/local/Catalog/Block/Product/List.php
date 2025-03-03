<?php
class Catalog_Block_Product_List extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('catalog/product/list.phtml');
    }
    public function productData()
    {
        $cat = Mage::getSingleton("catalog/filter")->getProductCollection();
        $data = $cat->getdata();
        return $data;
    }
}
