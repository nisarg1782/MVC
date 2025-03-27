<?php
class Admin_Block_Widget_Grid_Filter_Number extends Admin_Block_Widget_Grid_Filter_Abstract
{
    protected $_data;
    public function __construct()
    {
        // $this->setTemplate("admin/widget/grid/filter/number.phtml");
    }
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }
    public function getData()
    {
        return $this->_data;
    }
    public function renderTag()
    {
        return "<input type='{$this->_data['filter']}' 
       name='{$this->_data['label']}_min' 
       min='1' 
       placeholder='Enter minimum {$this->_data['label']}'>
       
       <br>
       
       <input type='{$this->_data['filter']}' 
       name='{$this->_data['label']}_max' 
       min='1' 
       placeholder='Enter maximum {$this->_data['label']}'>";
    }
}
