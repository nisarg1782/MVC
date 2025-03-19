<?php
class Customer_Model_Customer extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Customer_Model_Resource_Customer";
        $this->_collectionClassName="Customer_Model_Resource_Customer_Collection";
    }
    protected function _afterSave()
    {
        $address=Mage::getModel("customer/address")->getCollection()->addFieldToFilter("customer_id",["="=>$this->getCustomerId()])->getData();
        if(isset($address[0]))
        {
            
        }
        else{
            $address=Mage::getModel("customer/address")
            ->setCustomerId($this->getCustomerId())
            ->setCity($this->getCity())
            ->setState($this->getState())
            ->setStreet($this->getStreet())
            ->setAddressType($this->getAddressType())
            ->setTelephone($this->getTelephone())
            ->setZipCode($this->getZipcode())
            ->save();
        }
    }
}
?>