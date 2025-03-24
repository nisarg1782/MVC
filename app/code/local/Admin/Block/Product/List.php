<?php

class Admin_Block_Product_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {

        $this->init();
    }
    public function init()
    {
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

            $this->addChild("toolbar", $toolbar_block);
            
            
        $product = Mage::getModel("catalog/product");
        $this->_collection = $product->getCollection()->innerJoin(
            ["cat_table" => "catalog_category"],
            "cat_table.category_id = main_table.category_id",
            ["category_name" => "name"]
        );
        $toolbar_block->prepareToolbar();
    }
    public function listdata()
    {
        return $this->getCollection()->getData();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
}
