<?php
class Admin_Controller_Account extends Core_Controller_Admin_Action
{
    protected $_allowed = [
        "login",
        "loginPost"

    ];
    public function loginAction()
    {
        $layout = Mage::getBlock("core/layout");
        $login = $layout->createBlock("admin/account_login")
            ->setTemplate("admin/account/login.phtml");
        $layout->getChild("content")->addChild("loginpage", $login);
        $layout->toHtml();
    }
    public function loginPostAction()
    {
        $param = $this->getRequest()->getParam("user");
        $session = Mage::getSingleton("core/session");
        // print_r($param);
        $model = Mage::getModel("Admin/user")->getCollection()->addFieldToFilter("username", ["=" => $param["username"]]);
        $data = $model->getData();
        // print_r($data[0]->getAdminId());
        // die();
        if (!empty($data)) {
            // echo "<pre>";
            $password = $data[0]->getpasswordHash();
            $admin_id = $data[0]->getAdminId();
            if ($password == $param["password"]) {
                print("yes you are admin");
                $password = $data[0]->getpasswordHash();
                $admin_id = $data[0]->getAdminId();
                // var_dump($password);
                // var_dump($admin_id);

                $session->set("login", $admin_id);
                $session->set("admin_id", $admin_id);
                $this->redirect("admin/product_index/list");
                // $this->_init();
            } else {

                $session->remove("login");
                $session->remove("admin_id");
                $this->redirect("admin/account/login");
            }
            // print_r($admin_id);
            // print_r($admin_id);
        } else {
            $this->redirect("admin/account/login");
        }
        // $param = [
        //     "username" => "admin",
        //     "password" => "989898"
        // ];
    }
}
