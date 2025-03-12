<?php
class Checkout_Model_Shipping
{
    public $shipping_providers =  [
        ["name" => "FedEx", "charge" => 15, "delivery_time" => "2-3 Days"],
        ["name" => "UPS", "charge" => 12.5, "delivery_time" => "3-5 Days"],
        ["name" => "DHL", "charge" => 18, "delivery_time" => "1-2 Days"],
        ["name" => "USPS", "charge" => 10, "delivery_time" => "5-7 Days"],
        ["name" => "Blue Dart", "charge" => 14, "delivery_time" => "3-4 Days"],
    ];

    public function calculateCharges($name)
    {
        foreach ($this->shipping_providers as $provider) {
            if ($provider['name'] === $name) {
                return $provider;
            }
        }
        return null; // Return null if provider not found
    }

    public function getAllShippingProvider()
    {
        return $this->shipping_providers;
    }
}
?>
