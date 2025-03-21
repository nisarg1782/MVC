<?php
class Core_Block_Template
{
    protected $_parent = null;
    protected $_child = [];
    protected $_template;
    public function toHtml()
    {
        include_once(Mage::getBaseDir() . "app/design/frontend/template/" . $this->_template);
    }
    public function addChild($key, $block)
    {
        $this->_child[$key] = $block;
        $this->getChild($key)->setParent($this);
        return $this;
    }
    public function getChild($key)
    {
        return isset($this->_child[$key]) ? $this->_child[$key] : "";
    }
    public function removeChild($key)
    {
        unset($this->_child[$key]);
        return $this;
    }
    public function setTemplate($temp)
    {
        $this->_template = $temp;
        return $this;
    }
    public function getChildHtml($key)
    {
        if ($key == '' && count($this->_child)) {
            $html = "";
            foreach ($this->_child as $child) {
                $html .= $child->toHtml();
            }
            return $html;
        }
        return isset($this->_child[$key]) ? $this->_child[$key]->toHtml() : "";
        //return $this;

    }
    public function getUrl($url)
    {
        $request = Mage::getModel("core/request");
        $_url = [];
        $url = explode("/", $url);
        $_url[] = $url[0] == "*" ? $request->getModuleName() : $url[0];
        $_url[] = $url[1] == "*" ? $request->getControllerName() : $url[1];
        $_url[] = $url[2] == "*" ? $request->getActionName() : $url[2];

        return Mage::getBaseUrl() . implode("/", $_url);
    }
    public function ProductStatusText()
    {
        return 1;
    }
    public function getLayout()
    {
        return Mage::getBlock("core/layout");
    }
    public function setParent($block)
    {
        $this->_parent = $block;
        return $this;
    }
    public function getParent()
    {
        return $this->_parent;
    }
    public function getRequest()
    {
        return Mage::getModel("core/request");
    }
    
}
