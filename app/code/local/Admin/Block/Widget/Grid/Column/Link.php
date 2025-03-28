<?php
class Admin_Block_Widget_Grid_Column_Link extends Admin_Block_Widget_Grid_Column_Abstract
{
    protected $_data;
    protected $_row;
    public function __construct()
    {
        
    }
    public function setData($data)
    {
        $this->_data=$data;
        
        return $this;
    }
    public function setRow($row)
    {
        $this->_row=$row;
        return $this;
    }
    public function getRow()
    {
        return $this->_row;
    }
    public function getData()
    {
        return $this->_data;
    }
    public function render()
    {
       $function=$this->getData()["callback"];
       $url=Mage::getBlockSingleton("admin/product_list")
       ->$function($this->getRow());
  
       $tag="<a href={$url}>{$this->getData()['display']}</a>";
       return $tag;
   
    }
   
   
}
?>