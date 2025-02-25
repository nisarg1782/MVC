<?php
class Cms_Controller_Index
{
    // public function __construct()
    // {
    //     $layout=Mage::getBlock("core/Layout");
    //     $layout->toHtml();
        
    // }
    public function indexAction()
    {
        $layout=Mage::getBlock("core/layout");
        $index_cms=$layout->createBlock("Cms/Index");
        $index_cms->setTemplate("cms/index.phtml");
        $layout->getChild("content")->addChild("index_cms",$index_cms);
        $layout->toHtml();
        
    }
   
}
?>