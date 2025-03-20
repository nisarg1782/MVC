<?php
class Admin_Block_Sales_Order_product extends  Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/sales/order/view/product.phtml");
    }
   
    public function getOrderBlock()
    {
        return $this->getParent();
    }
    public function getProducts()
    {
        $product = $this->getOrderBlock()
            ->getOrder()
            ->getItemCollection();
        return $product->getData();
    }
   
}
