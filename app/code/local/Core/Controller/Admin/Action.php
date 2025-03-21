<?php
class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowed = [];
    public function __construct()
    {
        $this->_init();
    }
    protected function _init()
    {
        $isLogin = $this->getSession()->get('login');
        $admin_id = $this->getSession()->get('admin_id');
        
        if (!in_array($this->getRequest()->getActionName(), $this->_allowed)) {
            if (is_null($isLogin)) {
                $this->redirect("admin/account/login");
            }
            
            else if ($isLogin === $admin_id) {
                
            } else {
                $this->redirect("admin/account/login");
            }
        }
    }
    public function getLayout()
    {
        return Mage::getBlockSingleton("core/admin_layout");
    }
}
