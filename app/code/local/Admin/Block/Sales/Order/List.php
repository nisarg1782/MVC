<?php
class Admin_Block_Sales_Order_List extends Admin_Block_Widget_Grid
{
    protected $_collection;
    public function __construct()
    {
        $this->init();
        parent::__construct();
    }
    public function init()
    {

        $this->_collection = Mage::getModel("sales/order")
            ->getCollection();
        $this->addColumns("order_id", [
            "label" => "order_id", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "order_id", //db column which you want to display
            "column" => "text"

        ]);
        $this->addColumns("order_no", [
            "label" => "order_no", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "order_no", //db column which you want to display
            "column" => "text"
        ]);

        $this->addColumns("customer_id", [
            "label" => "customer_id", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "customer_id", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("total_amount", [
            "label" => "total_amount", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "total_amount", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("coupon_code", [
            "label" => "coupon_code", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "coupon_code", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("discount_price", [
            "label" => "discount_price", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "discount_price", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("email", [
            "label" => "email", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "email", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("provider_name", [
            "label" => "provider_name", //which you want to display
            "filter" => "dropdown", //data type of html field
            "data_index" => "provider_name", //db column which you want to display
            "column" => "text",
            "options"=>$this->getProvider()
        ]);
        $this->addColumns("charge", [
            "label" => "charge", //which you want to display
            "filter" => "number", //data type of html field
            "data_index" => "charge", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("payment_method", [
            "label" => "payment_method", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "payment_method", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("coupon_code", [
            "label" => "coupon_code", //which you want to display
            "filter" => "text", //data type of html field
            "data_index" => "coupon_code", //db column which you want to display
            "column" => "text"
        ]);
        $this->addColumns("Actions", [
            "label" => "Actions", //which you want to display
            "filter" => "", //data type of html field
            "data_index" => "order_id", //db column which you want to display
            "url" => $this->getUrl("*/*/view"),
            "column" => "link",
            "display"=>"View"
        ]);
        // $this->addColumns("Status", [
        //     "label" => "Status", //which you want to display
        //     "filter" => "dropdown", //data type of html field
        //     "data_index" => "", //db column which you want to display
        //     "url" => $this->getUrl("*/*/view"),
        //     "column" => "dropdown",
        //     "display"=>"View",
        //     "options"=>$this->getProvider()
        // ]);
    }
    public function getOrderData()
    {
        return $this->_collection->getData();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getProvider()
    {
        $provider=[];
        // echo '<pre>';
        // print_r($this->getOrderData());
        // echo '</pre>';
        $data=$this->getOrderData();
        foreach($data as $_data)
        {
          $provider[]=$_data->getProviderName();
        }
        return array_unique($provider);
        // return $data;
    }
}
