<?php
class Admin_Block_Order_product extends  Core_Block_Template
{

    protected $_orderBlock;

    public function __construct()
    {
        $this->setTemplate("admin/order/product.phtml");
    }
    public function setOrderBlock($order)
    {
        $this->_orderBlock = $order;
    }
    public function getOrderBlock()
    {
        return $this->_orderBlock;
    }
    public function getProducts()
    {
        $product = $this->getOrderBlock()
            ->getOrder()
            ->getItemCollection();
        return $product->getData();
    }
   
}
