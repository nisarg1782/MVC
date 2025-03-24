<?php
class Customer_Controller_Address_Index extends Core_Controller_Customer_Action
{
    public function newAction()
    {
        $layout=$this->getLayout();
        $new_address=$layout->createBlock("customer/account_address_new")
                        ->setTemplate("customer/address/new.phtml");
        $layout->getChild("content")->addChild("new_address",$new_address);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout=$this->getLayout();
        $address_data=Mage::getModel("core/request")
                        ->getParam("customer_address");
       $address_data["customer_id"]=$this->getCustomerId();
       Mage::getModel("customer/address")
            ->setData($address_data)
            ->save();
            $this->redirect("customer/index/dashboard");
            // header("location:$url");
    }
    public function deleteAction()
    {
        $address_id=$this->getRequest()
            ->getQuery("id");
        $address_data=Mage::getModel("customer/address")
            ->getResource()
            ->load($address_id);
        Mage::getModel("customer/address")
            ->setData($address_data)
            ->delete();
            $this->redirect("customer/index/dashboard");

    }
}
?>