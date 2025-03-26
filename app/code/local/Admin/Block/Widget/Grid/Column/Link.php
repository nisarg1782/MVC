<?php
class Admin_Block_Widget_Grid_Column_Link extends Core_Block_Template
{
    protected $_data;
    protected $_cols;
   
    public function __construct()
    {
        $this->setTemplate("admin/widget/grid/column/link.phtml");
    }
    public function setData($cols,$data)
    {
        $this->_data=$data;
        $this->_cols=$cols;
        return $this;
    }
    public function getData()
    {
        return $this->_data;
    }
    public function getCols()
    {
        return $this->_cols;
    }
   
}
?>