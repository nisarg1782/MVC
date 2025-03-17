<?php

class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart";
        $this->_collectionClassName = "Checkout_Model_Resource_Cart_Collection";
    }
    public function addProduct($productid, $quantity)
    {

        Mage::getModel("checkout/cart_item")->setProductId($productid)->setQuantity($quantity)->setCartId($this->getCartId())
            ->save();
        return $this;
    }
    public function getItemCollection()
    {

        $cart_item = Mage::getModel("checkout/cart_item")
            ->getCollection()
            ->addFieldToFilter(
                "cart_id",
                ["=" => $this->getCartId()]
            );

        return $cart_item;
    }
    public function getAddressCollection()
    {
        $cart_address = Mage::getModel("checkout/cart_address")
            ->getCollection()
            ->addFieldToFilter(
                "cart_id",
                ["=" => $this->getCartId()]
            );

        return $cart_address;
    }
    public function getBillingAddress()
    {
        $billing_address = Mage::getModel("checkout/cart_address")
            ->getCollection()
            ->addFieldToFilter(
                "cart_id",
                ["=" => $this->getCartId()]
            )
            ->addFieldToFilter(
                "address_type",
                ["=" => "Billing"]
            );

        return $billing_address;
    }
    public function getShippingAddress()
    {
        $Shipping_address = Mage::getModel("checkout/cart_address")
            ->getCollection()
            ->addFieldToFilter(
                "cart_id",
                ["=" => $this->getCartId()]
            )
            ->addFieldToFilter(
                "address_type",
                ["=" => "Shipping"]
            );

        return $Shipping_address;
    }
    public function _beforeSave()
    {
        $total = 0;
        $data = $this->getItemCollection()->getData();
        foreach ($data as $_data) {
            // print($_data->getSubtotal());
            // echo '<br>';
            $total = $total + $_data->getSubTotal();
            // $total=$total-intval($_data->getDiscountPrice());
        }
        // $total=$total-intval($this->getDiscountPrice());
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
        // print_r($total);
        $charge = intval($this->getCharge());
        $discount = intval($this->getDiscountPrice());
        $total = $total - $discount;
        $total = $total + $charge;
        $this->setTotalAmount($total);

        // $cart = Mage::getSingleton("checkout/session")->getCart();

        // if (!empty($cart)) {
        //     $this->setTotalAmount($total);
        //     $this->setCartId($cart->getCartId());
        // }
    }
    public function removeItem($id)
    {
        foreach ($this->getItemCollection()->getData() as $_cart) {
            if ($id == $_cart->getItemId()) {

                $_cart->delete();
                // $_cart->save();
            }
        }
        return $this;
    }
    public function updateItem($id, $quantity)
    {
        foreach ($this->getItemCollection()->getData() as $_cart) {
            if ($id == $_cart->getItemId()) {
                //  print_r($_cart->getQuantity());
                // echo '<pre>';
                // print_r($_cart);
                // echo '</pre>';
                // die;
                $_cart->setItemId($id);
                // $_cart->setProductId($this->getProductId());
                // $this->setCartId($_cart->getCartId());
                // $_cart->setQuantity(-$_cart->getQuantity());
                $_cart->setQuantity($quantity);
                $_cart->save();
            }
        }
        return $this;
    }
}
