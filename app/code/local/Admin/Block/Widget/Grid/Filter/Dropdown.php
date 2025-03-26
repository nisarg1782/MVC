<?php
class Admin_Block_Widget_Grid_Filter_Dropdown extends Core_Block_Template
{
    protected $_data;
    public function __construct()
    {
        $this->setTemplate("admin/widget/grid/filter/dropdown.phtml");
        
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