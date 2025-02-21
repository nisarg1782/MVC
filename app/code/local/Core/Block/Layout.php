<?php

class Core_Block_Layout extends Core_Block_Template{
    
    public function __construct()
    {
        $this->prepareChild();
        //$this->prepareCss();
        $this->prepareJs();
        $this->_template="page/root.phtml";
      
       
    }
    public function prepareChild()
    {

        $header=$this->createBlock("page/header");
        $this->addChild("header",$header);
        $head=$this->createBlock("page/head");
        $this->addChild("head",$head);
        $footer=$this->createBlock("page/footer");
        $this->addChild("footer",$footer);
        $content=$this->createBlock("page/content");
        $this->addChild("content",$content);
    }
   
    
    public function createBlock($block)
    {
       return Mage::getBlock($block);

    }
    public function prepareJs()
    {

        $head=$this->getChild('head')->addJs("js/page/comman.js")->addCss("css/page/comman.css");
        
    }
    public function prepareCss()
    {
        //$this->getChild('head')->addCss("page/comman.css");

    }

}
?>