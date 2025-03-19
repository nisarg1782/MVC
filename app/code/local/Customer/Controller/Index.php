<?php
class Customer_Controller_Index
{
    public function registerAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_register")->setTemplate("customer/register.phtml");
        $layout->getChild("content")->addChild("registration", $registration);
        $layout->toHtml();
    }
    public function loginAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_login")->setTemplate("customer/login.phtml");
        $layout->getChild("content")->addChild("login", $registration);
        $layout->toHtml();
    }
    public function registerCustomerAction()
    {
        $customer = Mage::getModel("core/request")->getParam("customer");
        $exist_customer = Mage::getModel("customer/customer")->load($customer["email"], "email");
        if (!empty($exist_customer->getData())) {
            print("in if");
        } else {
            // echo '<pre>';
            // print_r($customer);
            // echo '</pre>';
            Mage::getModel("customer/customer")
                ->setData($customer)
                ->Save();
        }
        $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Customer/index/login");
        header("location:$url");
    }
    public function loginCustomerAction()
    {
        $login_data = Mage::getModel("core/request")->getParam("customer");
        $session = Mage::getSingleton("core/session");
        // print_r($param);
        $model = Mage::getModel("customer/customer")->getCollection()->addFieldToFilter("email", ["=" => $login_data["email"]]);
        $data = $model->getData();
        if (!empty($data)) {
        $password = $data[0]->getPassword();
        $customer_id = $data[0]->getCustomerId();
        if ($password == $login_data["password"]) {
                print("yes you are Customer");
                $password = $data[0]->getPassword();
                $customer_id = $data[0]->getCustomerId();
                $session->set("login", $customer_id);
                $session->set("customer_id", $customer_id);
                
    }
    else{
        print("password is in valid");
    }
   
}
else{
    print("in valid credentials");
}
    
}
}