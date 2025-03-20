<?php

class Customer_Controller_Profile_Index
{
    public function editAction()
    {
        $layout=Mage::getBlock("core/layout");
        $profile=$layout->createBlock("customer/account_profile_profile")
                        ->setTemplate("customer/profile/edit.phtml");
        $layout->getChild("content")->addChild("profile",$profile);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout=Mage::getBlock("core/layout");
        $customer_data=Mage::getModel("core/request")->getParam("customer");
        $exist_customer = Mage::getModel("customer/customer")
        ->load($customer_data["email"], "email");
        
        if (!empty($exist_customer->getData())) {
            $url = $layout->getUrl("Customer/profile_index/edit");
            $url.="/?customer_id=".$customer_data["customer_id"];
            header("location:$url");
        } else {
            // echo '<pre>';
            // print_r($customer);
            // echo '</pre>';
            Mage::getModel("customer/customer")
                ->setData($customer_data)
                ->Save();
            $url=$layout->getUrl("customer/index/dashboard");
            header("location:$url");
        }
    }
}



?>