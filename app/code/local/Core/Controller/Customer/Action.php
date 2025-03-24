<?php
class Core_Controller_Customer_Action extends Core_Controller_Front_Action


{
    protected $_allowed = [];
    public function __construct()
    {
        $this->_init();
    }
    protected function _init()
    {
        $isLogin = $this->getSession()->get('customer_id');
        // $admin_id = $this->getSession()->get('customer_id');
        // print("login is " . $isLogin);
        // print("<br>");
        // print("the admin is id " . $admin_id);
        // var_dump($admin_id);
        if (!in_array($this->getRequest()->getActionName(), $this->_allowed)) {
            if (is_null($isLogin)) {
                $this->redirect("customer/index/login");
            }
            else if ($isLogin) {
              
            } else {
                $this->redirect("customer/index/login");
            }
        }
        // echo "<pre>";
        // print_r("123");
        // echo "</pre>";
        // die();

    }
    public function getCustomerId()
    {
        return $this->getSession()->get("customer_id");
    }
}
