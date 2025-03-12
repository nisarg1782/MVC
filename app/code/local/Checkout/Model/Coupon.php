<?php
class Checkout_Model_Coupon
{
    public $coupons = [
        "WELCOME10"   => "10%",    // 10% off for new users
        "FESTIVE20"   => "20%",    // 20% off during festival season
        "SUMMER15"    => "15%",    // 15% off on summer collection
        "BLACKFRIDAY" => "30%",    // 30% off on Black Friday sale
        "SAVE50"      => "₹50 Off" // Flat ₹50 off on any order
    ];

    public function getCoupons()
    {
        return $this->coupons;
    }

    public function calculateDiscount($totalAmount, $coupon)
    {
        if (!array_key_exists($coupon, $this->coupons)) {
            return "Invalid coupon code!";
        }

        $discountValue = $this->coupons[$coupon];

     
        if (strpos($discountValue, '%') !== false) {
            $discountPercent = (int) str_replace('%', '', $discountValue);
            $discountAmount = ($totalAmount * $discountPercent) / 100;
        }
      
        elseif (strpos($discountValue, '₹') !== false) {
            $discountAmount = (int) filter_var($discountValue, FILTER_SANITIZE_NUMBER_INT);
        } else {
            return "Invalid discount format!";
        }
        $finalAmount = max(0, $totalAmount - $discountAmount); // Ensure total is not negative
        // return [
        //     "original_price" => "₹" . number_format($totalAmount, 2),
        //     "discount_applied" => $discountValue,
        //     "discount_amount" => "₹" . number_format($discountAmount, 2),
        //     "final_price" => "₹" . number_format($finalAmount, 2)
        // ];
        $cart = Mage::getModel("checkout/session")->getCart();
        $cart->setCouponCode($coupon)
            ->setDiscountPrice($discountAmount)
            // ->setTotalAmount($finalAmount)
            ->save();
    }
}

// Example Usage:
// $couponModel = new Checkout_Model_Coupon();
// $totalAmount = 500; // Example cart total
// $couponCode = "WELCOME10"; // Example coupon

// $result = $couponModel->calculateDiscount($totalAmount, $couponCode);
// print_r($result);
