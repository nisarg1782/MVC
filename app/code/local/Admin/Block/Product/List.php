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
        // echo '<pre>';
        // print_r($this->_collection->prepareQuery());
        // echo '</pre>';
        // die;

        $this->addColumns("product_id", [
            "label" => "product_id", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "product_id", //db column which you want to display
            "column" => "text"

        ]);
        $this->addColumns("name", [
            "label" => "name", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "name", //db column which you want to display
            "column" => "text"
        ]);

        $this->addColumns("sku", [
            "label" => "sku", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "sku", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("price", [
            "label" => "price", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "price", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("stock_quantity", [
            "label" => "stock_quantity", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "stock_quantity", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("category_name", [
            "label" => "category_name", //which you want to display
            "filter" => "dropdown", //data type of html field
            "data_index" => "category_name", //db column which you want to display
            "column" => "text",
            "options" => $this->getCategory()
        ]);

        $this->addColumns("Edit", [
            "label" => "Edit", //which you want to display
            "filter" => "", //data type of html field
            "data_index" => "product_id", //db column which you want to display
            "url" => $this->getUrl("*/*/new"),
            "column" => "link",
            "display" => "Edit",
            "callback"=>"isEditUrl"
        ]);
        $this->addColumns("Delete", [
            "label" => "Delete", //which you want to display
            "filter" => "", //data type of html field
            "data_index" => "product_id", //db column which you want to display
            "url" => $this->getUrl("*/*/delete"),
            "column" => "link",
            "display" => "Delete",
            "callback"=>"isDeleteUrl"
        ]);
    }
    public function listdata()
    {

        return $this->getCollection()->getData();
    }
    public function getCategory()
    {
        $category_data = [];
        $category = Mage::getModel("catalog/category")
            ->getCollection()
            ->addFieldToFilter("category_id", [">" => 0])
            ->getData();
        foreach ($category as $_category) {
            $category_data[$_category->getCategoryId()] = $_category->getName();
        }
        return $category_data;
    }
    public function isEditUrl($row)
    {
      return $this->getUrl("*/*/new")."/?product_id=".$row->getProductId();
    }
    public function isDeleteUrl($row)
    {
      return $this->getUrl("*/*/delete")."/?product_id=".$row->getProductId();
    }

  
}
