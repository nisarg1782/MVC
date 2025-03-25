<?php

class Admin_Block_Product_List extends Admin_Block_Widget_Grid
{
    protected $_collection;
    protected $_columns = [];
    public function __construct()
    {
       
        $this->init();
        parent::__construct();
    }
    public function init()
    {
        $product = Mage::getModel("catalog/product");
        $this->_collection = $product->getCollection()->innerJoin(
            ["cat_table" => "catalog_category"],
            "cat_table.category_id = main_table.category_id",
            ["category_name" => "name"]
        );


        $this->addColumns("product_id", [
            "label" => "product_id", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "product_id", //db column which you want to display
            "column"=>"text"
            
        ]);
        $this->addColumns("name", [
            "label" => "name", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "name", //db column which you want to display
            "column"=>"text"
        ]);
        
        $this->addColumns("sku", [
            "label" => "sku", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "sku", //db column which you want to display
            "column"=>"text"
        ]);
        $this->addColumns("price", [
            "label" => "price", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "price", //db column which you want to display
            "column"=>"text"
        ]);
        $this->addColumns("stock_quantity", [
            "label" => "stock_quantity", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "stock_quantity", //db column which you want to display
            "column"=>"text"
        ]);
        $this->addColumns("actions", [
            "label" => "Actions", //which you want to display
            "filter" => "", //data type of html field
            "data_index" => "product_id", //db column which you want to display
            "url"=>"http:://google.com",
            "column"=>"link"
        ]);
        
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
