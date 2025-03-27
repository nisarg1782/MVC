<?php
class Admin_Block_Widget_Grid_Column_Text extends Admin_Block_Widget_Grid_Column_Abstract
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
    public function getData()
    {
        return $this->_data;
    }
   
    

    
}
?>