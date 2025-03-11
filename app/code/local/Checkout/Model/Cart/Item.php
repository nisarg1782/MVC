<?php
class Checkout_Model_Cart_Item extends Core_Model_Abstract
{
    protected $_data12 = null;
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart_Item";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Item_Collection";
    }
    public function getProduct()
    {
        $this->_data12 = Mage::getModel("catalog/product")->load($this->getProductId());
        return $this->_data12;
    }
    public function _beforeSave()
    {

        $cart_item = $this->getCollection()->addFieldToFilter(
            "cart_id",
            ["=" => $this->getCartId()]
        )->addFieldToFilter("product_id", ["=" => $this->getProductId()])->getData();
        // echo "<pre>";
        // $price = $this->proddata()[0]->getPrice();
        // print($price);
        $data=$this->getProduct();
        // var_dump($data);
        $price=$data->getPrice();
        print_r($price);
        
        // echo '<pre>';
        // print_r($cart_item);
        // echo '</pre>';
       
        //   var_dump($price);
        // $price = intval($price);


        if (!empty($cart_item)) {
            $this->setItemId($cart_item[0]->getItemId());
            $this->setPrice($price);
            $this->setQuantity($cart_item[0]->getQuantity() + $this->getQuantity());
            $this->setSubTotal($this->getQuantity() * $cart_item[0]->getPrice());
        } else {
            $this->setPrice(intval($price));
            $this->setSubTotal(intval($this->getQuantity()) * intval($price));
        }
    }
}
