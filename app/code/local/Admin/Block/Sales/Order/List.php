<?php
class Admin_Block_Sales_Order_List extends Core_Block_Template
{
    protected $_collection;
    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        
        $layout=$this->getLayout();
        $toolbar=$layout->createBlock("admin/grid_toolbar")
                        ->setTemplate("admin/grid/toolbar.phtml");
        $this->addChild("toolbar",$toolbar);
        $this->_collection=Mage::getModel("sales/order")
                                ->getCollection();
        $toolbar->prepareToolbar();

    }
    public function getOrderData()
    {
       return $this->_collection->getData();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
}
?>