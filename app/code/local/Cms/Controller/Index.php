<?php
class Cms_Controller_Index extends Core_Controller_Front_Action
{
    public function __construct()
    {
        $layout=Mage::getBlock("core/Layout");
        $layout->toHtml();
        
    }
    public function indexAction()
    {
        
        
    }
   
}
?>