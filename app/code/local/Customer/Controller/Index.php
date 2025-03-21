<?php
class Customer_Controller_Index extends Core_Controller_Customer_Action
{
    protected $_allowed = [
        "register",
        "login",
        "checkEmail"

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

        $customer = Mage::getModel("customer/session")
            ->getCustomer()
            ->setData($customer)
            ->Save();

        $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Customer/index/login");
        header("location:$url");
    }
    public function loginCustomerAction()
    {
        $login_data = Mage::getModel("core/request")->getParam("customer");
        $session = Mage::getSingleton("core/session");

        $model = Mage::getModel("customer/session")
            ->getCustomer()
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


        $dashboard = $layout->createBlock("customer/account_dashboard")
            ->setTemplate("customer/dashboard.phtml");

        $layout->getChild("content")->addChild("dashboard", $dashboard);
        $customer = Mage::getModel("customer/session")
            ->getCustomer();
        $dashboard->setCustomer($customer);

        $profile = $layout->createBlock("customer/account_dashboard_profile");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("profile", $profile);


        $order = $layout->createBlock("customer/account_dashboard_order");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("order", $order);


        $address = $layout->createBlock("customer/account_dashboard_address");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("address", $address);

        $layout->toHtml();
    }
    public function logoutAction()
    {
        $session = $this->getSession();
        $session->remove("login");
        $session->remove("customer_id");
        $this->redirect("customer/index/login");
    }
    public function checkEmailAction()
    {

        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');

        $request = Mage::getModel("core/request");
        $email = trim($request->getQuery("email"));

        if (!$email) {
            echo json_encode(["status" => "error", "message" => "Email is required"]);
            exit;
        }

        try {

            $customer = Mage::getModel("customer/session")
                ->getCustomer()
                ->getCollection()
                ->addFieldToFilter("email", $email)
                ->getFirstItem();

            $response = [];

            if ($customer->getCustomerId()) {
                $response = ["status" => "error", "message" => "Email already registered!"];
            } else {
                $response = ["status" => "success", "message" => "Email available!"];
            }

            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
        exit;
    }
}
