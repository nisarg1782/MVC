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
                echo '<pre>';
                print_r($item_data);
                echo '</pre>';
               
            $product=Mage::getModel("catalog/product")
                ->load($item_data["product_id"])
                ;
            echo '<pre>';
            print_r($product);
            echo '</pre>';
            $quantity=$product->getStockQuantity()-$item_data["quantity"];
             $product->setStockQuantity($quantity);
            $product->save();
            
        //    
        //    echo '<pre>';
        //    print_r($product);
        //    echo '</pre>';
        //    die;
            // print($quantity);
            // $product->setStockQuantity($quantity);
            // $product->save();
        }

        

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
