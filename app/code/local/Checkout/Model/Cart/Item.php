<?php
class Checkout_Model_Cart_Item extends Core_Model_Abstract
{
    protected $_product = null;
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart_Item";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Item_Collection";
    }
    public function getProduct()
    {
        $this->_product = Mage::getModel("catalog/product")->load($this->getProductId());
        return $this->_product;
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
        // $data = $this->getProduct();
        // // var_dump($data);
        // $price = $data->getPrice();
        // print_r($price);

        // echo '<pre>';
        // print_r($cart_item);
        // echo '</pre>';

        //   var_dump($price);
        // $price = intval($price);


        if (!empty($cart_item)) {
            $this->setItemId($cart_item[0]->getItemId());
            $this->setPrice($this->getProduct()->getPrice());
            $this->setQuantity($cart_item[0]->getQuantity() + $this->getQuantity());
            $this->setSubTotal($this->getQuantity() * $cart_item[0]->getPrice());
        } else {
            $this->setPrice(intval($this->getProduct()->getPrice()));
            $this->setSubTotal(intval($this->getQuantity()) * intval($this->getProduct()->getPrice()));
        }
    }
}
