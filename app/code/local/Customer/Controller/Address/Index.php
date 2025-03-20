<?php
class Customer_Controller_Address_Index extends Core_Controller_Customer_Action
{
    public function newAction()
    {
        $layout=Mage::getBlock("core/layout");
        $new_address=$layout->createBlock("customer/account_address_new")
                        ->setTemplate("customer/address/new.phtml");
        $layout->getChild("content")->addChild("new_address",$new_address);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout=Mage::getBlock("core/layout");
        $address_data=Mage::getModel("core/request")
                        ->getParam("customer_address");
       $address_data["customer_id"]=$this->getCustomerId();
       Mage::getModel("customer/address")
            ->setData($address_data)
            ->save();
            $url = $layout->getUrl("*/index/dashboard");
            header("location:$url");
    }
    public function deleteAction()
    {
        $address_id=Mage::getModel("core/request")
                    ->getQuery("id");
        $address_data=Mage::getModel("customer/address")->getResource()
                        ->load($address_id);
        Mage::getModel("customer/address")
            ->setData($address_data)
            ->delete();
        $layout=Mage::getBlock("core/layout");
        $url = $layout->getUrl("*/index/dashboard");
            header("location:$url");

    }
}
?>