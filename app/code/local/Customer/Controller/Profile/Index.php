<?php

class Customer_Controller_Profile_Index extends Core_Controller_Customer_Action
{
    public function editAction()
    {
        $layout=$this->getLayout();
        $profile = $layout->createBlock("customer/account_profile_profile")
            ->setTemplate("customer/profile/edit.phtml");
        $layout->getChild("content")->addChild("profile", $profile);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout=$this->getLayout();
        $customer_data =$this->getRequest()->getParam("customer");
            Mage::getSingleton("customer/session")
                ->getCustomer()
                ->setData($customer_data)
                ->Save();
            $this->redirect("customer/index/dashboard");
        
    }
    public function changePassAction()
    {
        $layout=$this->getLayout();
        $change_pass = $layout->createBlock("customer/account_profile_changepass")
            ->setTemplate("customer/profile/changepass.phtml");
        $layout->getChild("content")->addChild("profile", $change_pass);
        $layout->toHtml();
    }
    public function changePasswordAction()
    {
        $request=$this->getRequest();
        $password_data=$request->getParam("password");
        
        $customer=Mage::getModel("customer/session")
                        ->getCustomer();
        if($password_data["new"]!=$password_data["confirm"])
        {
            // print("new and confirm password not matched");
        }
        else if($password_data["current"]==$customer->getPassword() &&
            $password_data["new"]==$password_data["confirm"])
        {
            $customer->setCustomerId($customer->getCustomerId())
                    ->setPassword($password_data["confirm"])
                    ->save();
      
                    $this->redirect("customer/index/login");
     
        }
        else{
            print("current password is in valid ");
        }

    }
}
