<?php
class Catalog_Controller_Category
{
    
    public function listAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list')
                       ->setTemplate('catalog/category/list.phtml');
                    //    print_r($view);
        $layout->getChild('content')->addChild('list',$list);
        //print_r($layout);
        $layout->toHtml();
    }
    
}
?>