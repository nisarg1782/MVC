<?php
class Admin_Block_Widget_Grid_Column_Abstract
{
    protected $_row;
    protected $_data;
    public function setRow($data)
    {
        $this->_row = $data;
        return $this;
    }
    public function getRow()
    {
        return $this->_row;
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
    public function render()
    {
        $tag = "<span>{$this->getValue()}</span>";
        return $tag;
    }
    public function getFilter()
    {
        if (
            isset($this->getData()["filter"]) &&
            $this->getData()["filter"] != ""
        ) {
            $class = Mage::getBlock("Admin_Block_Widget_Grid_Filter_" . $this->getData()["filter"]);
            $obj_filter = new $class;
            $obj_filter->setData($this->getData());

            $tag = $obj_filter->renderTag();
            return $tag;
        }
    }
    public function getValue() {
       
    
      return $this->getRow()->getData()[$this->getData()["data_index"]];
    
    }
}
