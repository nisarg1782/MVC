<?php
class Core_Block_Admin_Layout extends Core_Block_Layout
{
    public function __construct()
    {
        $this->prepareChild();
       
        $this->prepareJs();
        $this->_template = "page/root.phtml";
    }
    public function prepareChild()
    {
        $header = $this->createBlock("page/header")
                        ->setTemplate("page/admin/header.phtml");
        $this->addChild("header", $header);

        $head = $this->createBlock("page/head")
                    ->setTemplate("page/admin/head.phtml");
        $this->addChild("head", $head);

        $footer = $this->createBlock("page/footer")
                        ->setTemplate("page/admin/footer.phtml");
        $this->addChild("footer", $footer);

        $content = $this->createBlock("page/content")
                        ->setTemplate("page/admin/content.phtml");
        $this->addChild("content", $content);
    }
    public function createBlock($block)
    {
        return Mage::getBlock($block);
    }
    public function prepareJs()
    {

        $head = $this->getChild('head')
                    ->addJs("js/page/comman.js")
                    ->addCss("css/page/comman.css");
    }
    public function prepareCss()
    {
        $this->getChild('head')->addCss("page/comman.css");

    }
    
}
?>