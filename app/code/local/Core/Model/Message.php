<?php
class Core_Model_Message extends Core_Model_Session
{
    public function addMessage($type, $message)
    {
        $type = "add" . ucfirst($type);
        $this->$type($message);
    }
    public function addError($message)
    {
        $message_array = $this->get("message");
        if (isset($message_array)) {
            $message_array["error"] = $message;
            // print_r($message_array);
            $this->set("message", $message_array);
            // echo '<pre>';
            // print_r($this->get("message"));
            // echo '</pre>';
        } else {
            $this->set("message", ["error" => $message]);
        }
    }
    public function addSuccess($message)
    {
        $message_array = $this->get("message");
        if (isset($message_array)) {
            $message_array["success"] = $message;

            $this->set("message", $message_array);
        } else {
            $this->set("message", ["success" => $message]);
        }
    }
    public function addWarning($message)
    {
        $message_array = $this->get("message");
        if (isset($message_array)) {
            $message_array["warning"] = $message;

            $this->set("message", $message_array);
        } else {
            $this->set("message", ["warning" => $message]);
        }
    }
    public function getMessage($type)
    {
        $type = "get" . ucfirst($type);
        $message = $this->$type();
        return $message;
    }
    public function getError()
    {
       if(isset($this->get("message")["error"]))
       {
        $message=$this->get("message")["error"];
        // $this->remove("message");
        $this->removeMessage("error");
        return $message;
       }
      
    }
    public function getSuccess()
    {
        if(isset($this->get("message")["success"]))
        {
         $message=$this->get("message")["success"];
        //  $this->remove("message");
        $this->removeMessage("success");
        return $message;
        }
       
        
    }
    public function getWarning()
    {
        if(isset($this->get("message")["warning"]))
       {
        $message=$this->get("message")["warning"];
        // $message_array=$this->get("message");
       $this->removeMessage("warning");
       
       return $message;
       }
       
       
    }
}
