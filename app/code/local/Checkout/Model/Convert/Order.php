<?php
class Checkout_Model_Convert_Order
{
    public function convert($cart)
    {
        $cart_data = $cart->getData();
        unset($cart_data["cart_id"]);


        $client_ip = $_SERVER['REMOTE_ADDR'];
        $cart_data["ip_address"] = $client_ip;

        $order_no = $this->generateOrderNumber($cart_data);
        $cart_data["order_no"] = $order_no;

        $order = Mage::getModel("sales/order")
            ->setData($cart_data)
            ->save();
        $order_id = $order->getOrderId();



        $cart_item = $cart->getItemCollection()->getData();

        foreach ($cart_item as $cart_item_data) {
            $item_data = $cart_item_data->getData();
            $item_data["order_id"] = $order_id;
            $sales_order_item = Mage::getModel("sales/order_item")
                ->setData($item_data)
                ->save();
        }

        // $billing_address=$cart->getBillingAddress()->getData();
        // echo '<pre>';
        // print_r($billing_address);
        // echo '</pre>';
        // unset($billing_address["created_at"]);
        // unset($billing_address["updated_at"]);
        // $billing_address["order_id"]=$order_id;
        // echo '<pre>';
        // print_r($billing_address);
        // echo '</pre>';
        // // die;
        // Mage::getModel("sales/order_address")->setData($billing_address)->save();
        // // die;
        // $shipping_address=$cart->getShippingAddress()->getData();
        // echo '<pre>';
        // print_r($shipping_address);
        // echo '</pre>';
        // unset($shipping_address["created-at"]);
        // $shipping_address["order_id"]=$order_id;
        // unset($shipping_address["updated-at"]);
        // Mage::getModel("sales/order_address")->setData($shipping_address)->save();

        $cart_address = $cart->getAddressCollection()
            ->getData();
        foreach ($cart_address as $cart_address_data) {
            $address_data = $cart_address_data
                ->getData();
            unset($address_data["created_at"]);
            unset($address_data["updated_at"]);
            $address_data["order_id"] = $order_id;
            Mage::getModel("sales/order_address")
                ->setData($address_data)
                ->save();
        }
    }
    function generateOrderNumber($data)
    {
        // Extract necessary fields
        $customerId = str_pad($data['customer_id'], 4, '0', STR_PAD_LEFT);
        $timestamp = date("YmdHis", strtotime($data['added_at']));
        $randomPart = substr(md5(uniqid($data['email'], true)), 0, 6);

        // Construct the order number
        $orderNumber = "ORD-{$customerId}{$timestamp}-{$randomPart}";
        return $orderNumber;
    }
}
