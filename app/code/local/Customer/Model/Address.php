<?php
class Customer_Model_Address extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Customer_Model_Resource_Address";
        $this->_collectionClassName="Customer_Model_Resource_Address_Collection";
    }
    protected function _afterSave()
    {
        if($this->getDefaultAddress()==1)
        {
           $address=Mage::getModel("customer/address")
                    ->getCollection()
                    ->addFieldToFilter("address_id",["!="=>$this->getAddressId()])
                    ->getData();
                    foreach($address as $_address)
                    {
                        $_address->setDefaultAddress(0)->save();
                    }
            
        }
        else{
            // print("in else");
        }
        
    }
}
?>