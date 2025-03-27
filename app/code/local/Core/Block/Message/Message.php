<?php
class Core_Block_Message_Message extends Core_Block_Layout
{
    public function __construct()
    {
        $this->setTemplate("page/message.phtml");
    }
    public function getMessageModel()
    {
        return Mage::getSingleton("core/message");
    }
    public function getErrorMessage()
    {
        $message = $this->getMessageModel()
            ->getMessage("error");
        return $message;
    }
    public function getSuccessMessage()
    {
        $message = $this->getMessageModel()
            ->getMessage("success");
        return $message;
    }
    public function getWarningMessage()
    {
        $message = $this->getMessageModel()
            ->getMessage("warning");
        return $message;
    }
    public function addMessage($type, $message)
    {
        $this->getMessageModel()
            ->addMessage($type, $message);
            return $this;
    }
}
