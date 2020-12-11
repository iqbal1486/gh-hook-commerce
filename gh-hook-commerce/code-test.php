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



Text:

Hook Commerce for WooCommerce is a Woo Addon that help user to customize necessary functionality like add custom fields, rename label and other features from admin interface.
This plugin has following features:
	- Checkout Fields Module
	- Renaming Checkout Fields Label Modules
	- WooCommerce Admin Mods
	- WooCommerce Cart Mods
	- WooCommerce Checkout Mods

Checkout Fields Modules:
	-This module will help user to add as many fields to the checkout form. You can create field from admin interface with custom label, custom field name, custom placehoder, custom error message. 

	-Admin can set the fields as required
	-Admin can add custom classes that will help to create UI compatible with your active theme.
	-You can add three types of fields
		-- Text Field
		-- Textarea Field
		-- Checkbox Field


Renaming Checkout Fields Label Modules
	-This is very interesting for me. This mod will help admin to rename the label of every checkout fields which are available.
	-Admin can find the list of available checkout fields in a dropdown and add as many as in a repeater form to change the label. Fields are fetched using WooCommerce classes.


WooCommerce Admin Mods
	- You can change WooCommerce name on dashboard
	- You can change WooCommerce menu icon
	- Product Singular and plural name


WooCommerce Cart Mods
	- Show Distint Cart Item Count
	- Split Cart Table with A - Z as a heading
	- Change Continue Shopping Link



