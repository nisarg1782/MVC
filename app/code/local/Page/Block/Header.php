<?php
class Page_Block_Header extends Core_Block_Template
{
    public function __construct()
    {
        $this->settemplate("page/header.phtml");
    }
    public function getCategories()
    {
        $model=Mage::getModel("catalog/category");
        $data=$model->getCollection()->addFieldToFilter("parent_id",["="=>'0']);
        return $data->getdata();
        
        // return $data;
    }
}
?>