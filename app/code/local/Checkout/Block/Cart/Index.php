<?php
class Checkout_Block_Cart_Index extends Core_Block_Template
{
    public function getCartData()
    {
        $session = Mage::getModel("core/session");
        $cartData = $session->get("cart");

        if (empty($cartData)) {
            echo "Cart is empty.";
            return;
        }

        $products = [];

        foreach ($cartData as $_data) {
            $product = Mage::getModel("catalog/product")->getCollection()->addFieldToFilter(
                "main_table.product_id",
                ["=" => $_data["product_id"]]
            )->joinLeft(
                ["cmg" => "catalog_media_gallery"],
                "cmg.product_id={$_data['product_id']} AND cmg.default_file_path=1",
                ["file_path" => "file_path"]
            )->getData();
            foreach ($product as $_product) {
                if ($_product->getProductId()) {
                    $products[] = [
                        'product_id' => $_product->getProductId(),
                        'name' => $_product->getName(),
                        'price' => $_product->getPrice(),
                        'quantity' => $_data["quantity"],
                        'image' => $_product->getFilePath(),
                    ];
                }
            }
        }
        return $products;
    }
}
