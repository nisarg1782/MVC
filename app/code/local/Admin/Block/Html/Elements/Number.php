<?php

class Admin_Block_Html_Elements_Number
{
    protected $_data=[];
    public function __construct($data)
    {
        $this->_data=$data;
    }
    public function render()
    {
        $html = '<input type="number"';
        if (isset($this->_data["id"])) {
            $html .= ' id="' . $this->_data["id"] . '"';
        }
        if (isset($this->_data["class"])) {
            $html .= ' class="' . $this->_data["class"] . '"';
        }
        if (isset($this->_data["min"])) {
            $html .= ' min="' . $this->_data["min"] . '"';
        }
        if (isset($this->_data["max"])) {
            $html .= ' max="' . $this->_data["max"] . '"';
        }
        if (isset($this->_data["value"])) {
            $html .= ' value="' . $this->_data["value"] . '"';
        }
        $html .= ' />';
        return $html;
    }
    
}
?>