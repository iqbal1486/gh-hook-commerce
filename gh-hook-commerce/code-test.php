<?php
		WC()->session = new WC_Session_Handler();
        WC()->session->init();
        $WC_Checkout = new WC_Checkout();
        $get_checkout_fields = $WC_Checkout->get_checkout_fields();
        echo "<pre>";
        print_r($get_checkout_fields);
        echo "</pre>";
?>        



https://stackoverflow.com/questions/47598528/exclude-product-from-all-coupons-in-woocommerce
https://www.businessbloomer.com/woocommerce-how-to-alter-cart-items-count/
https://www.businessbloomer.com/woocommerce-set-override-product-price-programmatically/


Completed:

Rename Checkout - Done
Admin Mode - Done
Checkout Field - Done
Checkout Mode  - Done
Car Mode - Done