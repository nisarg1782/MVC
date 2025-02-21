<?php

class Admin_Block_Product_List extends Core_Block_Template
{
    public function listdata()
    {
        $product = Mage::getModel("catalog/product");
        $collection=$product ->getCollection();
        $data = $collection->getdata();
        return $data;
        
    }
   
    
}
