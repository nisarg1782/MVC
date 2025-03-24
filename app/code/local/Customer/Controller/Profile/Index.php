<?php

class Customer_Controller_Profile_Index extends Core_Controller_Customer_Action
{
    public function editAction()
    {
        $layout = Mage::getBlock("core/layout");
        $profile = $layout->createBlock("customer/account_profile_profile")
            ->setTemplate("customer/profile/edit.phtml");
        $layout->getChild("content")->addChild("profile", $profile);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout = Mage::getBlock("core/layout");
        $customer_data = Mage::getModel("core/request")->getParam("customer");
        // echo '<pre>';
        // print_r($customer_data);
        // echo '</pre>';
        // die;
        

            Mage::getSingleton("customer/session")
                ->getCustomer()
                ->setData($customer_data)
                ->Save();
            $url = $layout->getUrl("customer/index/dashboard");
            header("location:$url");
        
    }
    public function changePassAction()
    {
        $layout = Mage::getBlock("core/layout");
        $change_pass = $layout->createBlock("customer/account_profile_changepass")
            ->setTemplate("customer/profile/changepass.phtml");
        $layout->getChild("content")->addChild("profile", $change_pass);
        $layout->toHtml();
    }
    public function changePasswordAction()
    {
        $request=Mage::getModel("core/request");
        $password_data=$request->getParam("password");
        // echo '<pre>';
        // print_r($password_data);
        // echo '</pre>';
        $customer=Mage::getModel("customer/session")
                        ->getCustomer();
        if($password_data["new"]!=$password_data["confirm"])
        {
            print("new and confirm password not matched");
        }
        else if($password_data["current"]==$customer->getPassword() &&
            $password_data["new"]==$password_data["confirm"])
        {
            $customer->setCustomerId($customer->getCustomerId())
                    ->setPassword($password_data["confirm"])
                    ->save();
            $layout=Mage::getBlock("core/layout");
                    $url = $layout->getUrl("customer/index/login");
            header("location:$url");
            
        }
        else{
            print("current password is in valid ");
        }

    }
}
