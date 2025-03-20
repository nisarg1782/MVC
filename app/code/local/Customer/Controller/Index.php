<?php
class Customer_Controller_Index extends Core_Controller_Customer_Action
{
    protected $_allowed = [
        "register",
        "login"

    ];
    public function registerAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_register")
            ->setTemplate("customer/register.phtml");
        $layout->getChild("content")
            ->addChild("registration", $registration);
        $layout->toHtml();
    }
    public function loginAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_login")
            ->setTemplate("customer/login.phtml");
        $layout->getChild("content")
            ->addChild("login", $registration);
        $layout->toHtml();
    }
    public function registerCustomerAction()
    {
        $layout = Mage::getBlock("core/layout");
        $customer = Mage::getModel("core/request")->getParam("customer");
        $exist_customer = Mage::getModel("customer/customer")
            ->load($customer["email"], "email");
        if (!empty($exist_customer->getData())) {
            $url = $layout->getUrl("Customer/index/register");
            header("location:$url");
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
        $model = Mage::getModel("customer/customer")
            ->getCollection()
            ->addFieldToFilter("email", ["=" => $login_data["email"]]);
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
                $layout = Mage::getBlock("core/layout");
                $url = $layout->getUrl("*/*/dashboard");
                header("location:$url");
            } else {
                $session->remove("login");
                $session->remove("customer_id");
            }
        } else {
            print("in valid credentials");
        }
    }
    public function dashboardAction()
    {
        $layout = Mage::getBlock("core/layout");
        $session = Mage::getSingleton("core/session");
        $dashboard = $layout->createBlock("customer/account_dashboard")
            ->setTemplate("customer/dashboard.phtml");
        $layout->getChild("content")->addChild("dashboard", $dashboard);
        $customer=Mage::getModel("customer/customer")->load($session->get("customer_id"));
        $dashboard->setCustomer($customer);
        
        $profile=$layout->createBlock("customer/account_dashboard_profile");
        $layout->getChild("content")
                ->getChild("dashboard")
                ->addChild("profile",$profile);
        // $profile->setDashboardBlock($dashboard);

        $order=$layout->createBlock("customer/account_dashboard_order");
        $layout->getChild("content")
                ->getChild("dashboard")
                ->addChild("order",$order);
        // $order->setDashboardBlock($dashboard);

        $address=$layout->createBlock("customer/account_dashboard_address");
        $layout->getChild("content")
                ->getChild("dashboard")
                ->addChild("address",$address);
        // $address->setDashboardBlock($dashboard);
        $layout->toHtml();
    }
    public function logoutAction()
    {
        $session = $this->getSession();
        $session->remove("login");
        $session->remove("customer_id");
        $this->redirect("customer/index/login");
    }
}
