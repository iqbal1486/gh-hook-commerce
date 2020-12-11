<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/admin
 * @author     Geekerhub <iahmed964@gmail.com>
 */
class Gh_Hook_Commerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $options_en ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->options_en = $options_en;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gh_Hook_Commerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Hook_Commerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gh-hook-commerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gh_Hook_Commerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Hook_Commerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gh-hook-commerce-admin.js', array( 'jquery' ), $this->version, false );

	}


    public function gh_custom_checkout_fields_display_after_shipping_address_callback( $order ){

        $custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

        if( $custom_checkout_field_mapping ){
            foreach ($custom_checkout_field_mapping as $key => $value) {
                $gh_add_to              =   $value['gh_checkout_field_add_to'];
                $gh_unique_id           =   $value['gh_checkout_field_unique_id'];
                $gh_label               =   $value['gh_checkout_field_label'];

                if ($gh_add_to == "shipping"){
                    $gh_field_data = get_post_meta( $order->get_order_number(), $gh_unique_id, true );
                    if ($gh_field_data != "") {
                        echo '<strong>' . $gh_label . ':</strong> ' . $gh_field_data . '<br>';
                    }  
                }
            }   
        }   
    }

    public function gh_custom_checkout_fields_display_after_billing_address_callback($order){

        $custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

        if( $custom_checkout_field_mapping ){
            foreach ($custom_checkout_field_mapping as $key => $value) {
                $gh_add_to              =   $value['gh_checkout_field_add_to'];
                $gh_unique_id           =   $value['gh_checkout_field_unique_id'];
                $gh_label               =   $value['gh_checkout_field_label'];

                if ($gh_add_to == "billing"){
                    $gh_field_data = get_post_meta( $order->get_order_number(), $gh_unique_id, true );
                    if ($gh_field_data != "") {
                        echo '<strong>' . $gh_label . ':</strong> ' . $gh_field_data . '<br>';
                    }  
                }
            }   
        }   
    }


    public function cpt_label_woo_callback( $args ){

        $singular_name_of_product   = $this->options_en['gh_change_singular_name_of_product_menu'];
        $plural_name_of_product     = $this->options_en['gh_change_plural_name_of_product_menu'];

        $labels = array(
          'name'               => __( $singular_name_of_product, 'gh-hook-commerce' ),
          'singular_name'      => __( $plural_name_of_product, 'gh-hook-commerce' ),
          'menu_name'          => _x( $singular_name_of_product, 'Admin menu name', 'gh-hook-commerce' ),
          'add_new'            => __( 'Add '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'add_new_item'       => __( 'Add New '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'edit'               => __( 'Edit  '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'edit_item'          => __( 'Edit  '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'new_item'           => __( 'New  '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'view'               => __( 'View  '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'view_item'          => __( 'View  '.$plural_name_of_product.'', 'gh-hook-commerce' ),
          'search_items'       => __( 'Search '.$singular_name_of_product.'', 'gh-hook-commerce' ),
          'not_found'          => __( 'No  '.$singular_name_of_product.' found', 'gh-hook-commerce' ),
          'not_found_in_trash' => __( 'No '.$singular_name_of_product.' found in trash', 'gh-hook-commerce' ),
          'parent'             => __( 'Parent  '.$plural_name_of_product.'', 'gh-hook-commerce' )
        );

        $args['labels'] = $labels;
        return $args;
    }


    public function rename_woocoomerce_admin_menu_callback(){
        
        $change_woocommerce_name_on_dashboard = $this->options_en['gh_change_woocommerce_name_on_dashboard'];

        if ($change_woocommerce_name_on_dashboard != ""){
            global $menu;
            $woo = $this->recursive_array_search_php( 'WooCommerce', $menu );
            if( !$woo )
                return;
            
            $menu[$woo][0] = $change_woocommerce_name_on_dashboard;
        }
    }


    public function replace_woocommerce_dashicons_callback(){
        
        $gh_change_woocommerce_menu_icon = $this->options_en['gh_change_woocommerce_menu_icon'];

        if ($gh_change_woocommerce_menu_icon != ""){
        $content =  sprintf('<style type="text/css">#adminmenu #toplevel_page_woocommerce .menu-icon-generic div.wp-menu-image::before {content:"\%s" !important;font-family: dashicons !important;}</style>',$gh_change_woocommerce_menu_icon );

        echo $content;
        }
    }


    public function get_checkout_field_types(){
        $send_checkout_field_types_array = array(
                                               'billing'    => "Billing",
                                               'shipping'   => "Shipping", 
                                               'after_order_notes'   => "After Order Notes", 
                                            );
        return $send_checkout_field_types_array;
    }

    public function get_checkout_field_input_types(){
        $send_checkout_field_input_types_array = array(
                                                       'text'       => "Text",
                                                       'textarea'   => "Textarea", 
                                                       'checkbox'   => "Checkbox", 
                                                    );
        return $send_checkout_field_input_types_array;
    }

    public function get_all_pages(){
        $send_all_pages_array = array();
        $pages = get_pages(); 

        foreach ( $pages as $page ) {
            $send_all_pages_array[get_page_link( $page->ID )] = $page->post_title;
        }

        return $send_all_pages_array;
    }


    public function get_checkout_fields(){
        
        WC()->session = new WC_Session_Handler();
        WC()->session->init();

        $WC_Checkout            = new WC_Checkout();
        $get_checkout_fields    = $WC_Checkout->get_checkout_fields();
        
        $send_checkout_fields_array = array();
        foreach ($get_checkout_fields as $main_key => $internal_fields) {
            foreach ($internal_fields as $key => $value) {
                $send_checkout_fields_array[$key] = $value['label']. " ( ".ucfirst($main_key)." ) ";
            }
        }

        return $send_checkout_fields_array;
    }


	public function create_menu() {

        $hook_commerce_submenu = array(
            'type'              => 'menu',
            'id'                => $this->plugin_name,              
            //'parent'            => 'plugins.php',
            'submenu'           => true,
            'title'             => 'Hook Commerce',
            'capability'        => 'manage_options',
            'plugin_basename'   =>  plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
        );

   
        /*
        * Woo Checkout Fields Mods
        */
        $fields[] = array(
            'name'   => 'gh-checkout-fields-mods',
            'title'  => 'Woo Checkout Fields',
            'icon'   => 'dashicons-editor-textcolor',
            'fields' => array(


                array(
                    'id'    => 'gh_add_custom_checkout_field',
                    'type'  => 'checkbox',
                    'title' => 'Would you like to add custom checkout field?',
                    'label' => 'Add custom checkout fields',
                    'style'    => 'fancy',
                    'after' => '<i>If you check this, you will see repeater fields visible to create custom fields.</i>'
                ),

                /*
                *URL
                */
                array(
                    'id'      => 'gh_add_custom_checkout_field_mapping',
                    'type'    => 'group',
                    'dependency' => array( 'gh_add_custom_checkout_field', '==', 'true' ),
                    'title'   => esc_html__( 'Checkout field mapping', 'gh-hook-commerce' ),
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add new', 'gh-hook-commerce' ),
                        'group_title'       => esc_html__( 'Checkout Field', 'gh-hook-commerce' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'          => 'gh_checkout_field_type',
                            'type'           => 'select',
                            'title'       => 'Field Type',
                            'query'          => array(
                                'type'          => 'callback',
                                'function'      => array( $this, 'get_checkout_field_input_types' ),
                                'args'          => array() 
                            ),
                            'class'       => 'repeater-50 chosen width-150',
                        ),


                        array(
                            'id'          => 'gh_checkout_field_add_to',
                            'type'           => 'select',
                            'title'       => 'Location',
                            'query'          => array(
                                'type'          => 'callback',
                                'function'      => array( $this, 'get_checkout_field_types' ),
                                'args'          => array()
                            ),
                            'class'       => 'repeater-50 chosen width-150',
                        ),

                        


                        array(
                            'id'          => 'gh_checkout_field_unique_id',
                            'type'        => 'text',
                            'title'       => 'Checkout field Unique Id',
                            'class'       => 'repeater-50',
                            'description' => 'This will be treated as "name" attribute of the field.',
                        ),

                        array(
                            'id'          => 'gh_checkout_field_error_message',
                            'type'        => 'text',
                            'title'       => 'Checkout field Error message for validation',
                            'class'       => 'repeater-50',
                        ),

                        array(
                            'id'          => 'gh_checkout_field_label',
                            'type'        => 'text',
                            'title'       => 'Label',
                            'class'       => 'repeater-50',
                        ),

                        array(
                            'id'          => 'gh_checkout_field_placeholder',
                            'type'        => 'text',
                            'title'       => 'Placeholder',
                            'class'       => 'repeater-50',
                        ),

                        array(
                            'id'          => 'gh_checkout_field_class',
                            'type'        => 'text',
                            'title'       => 'Classes for checkout field',
                            'class'       => 'repeater-50',
                            'description' => 'Put here default classes of the woocommerce, comma separated classes',
                        ),

                        array(
                            'id'          => 'gh_checkout_field_required',
                            'type'        => 'checkbox',
                            'title'       => 'Is checkout field is required?',
                            'class'       => 'repeater-50',
                        ),
                    ),

                ),

            )
        );


        /*
        * Woo Checkout Rename Label Mods
        */
        $fields[] = array(
            'name'   => 'gh-checkout-rename-label-mods',
            'title'  => 'Woo Checkout Labels',
            'icon'   => 'dashicons-editor-textcolor',
            'fields' => array(


                array(
                    'id'    => 'gh_rename_checkout_page_label',
                    'type'  => 'checkbox',
                    'title' => 'Rename Checkout Fields Labels',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                ),

                array(
                    'id'      => 'gh_rename_checkout_page_label_mapping',
                    'type'    => 'group',
                    'dependency' => array( 'gh_rename_checkout_page_label', '==', 'true' ),
                    'title'   => esc_html__( 'Checkout label mapping', 'gh-hook-commerce' ),
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add new', 'gh-hook-commerce' ),
                        'group_title'       => esc_html__( 'Checkout Label', 'gh-hook-commerce' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'          => 'gh_existing_field',
                            'type'           => 'select',
                            'title'       => 'Existing Field Name',
                            'query'          => array(
                                'type'          => 'callback',
                                'function'      => array( $this, 'get_checkout_fields' ),
                                'args'          => array()
                            ),
                            'class'       => 'repeater-50 chosen width-150',
                            'description' => 'This will be the name of the input field of existing checkout fields',
                        ),

                        array(
                            'id'          => 'gh_label_tobe_replaced',
                            'type'        => 'text',
                            'title'       => 'Label to be replaced',
                            'class'       => 'repeater-50',
                            'description' => 'This will be the label of the input field to be replaced',
                        ),

                    ),

                ),

            )
        );

        


        /*
        * Woo Admin Mods
        */
        $fields[] = array(
            'name'   => 'gh-admin-dashboard-mods',
            'title'  => 'Woo Admin Mods',
            'icon'   => 'dashicons-superhero',
            'fields' => array(


                array(
                    'id'          => 'gh_change_woocommerce_name_on_dashboard',
                    'type'        => 'text',
                    'title'       => 'Change WooCommerce name on dashboard',
                    //'before'      => 'Text Before',
                    'after'       => 'Rename WooCommerce menu name as per your wish',
                    'attributes'    => array(
                       'placeholder' => 'My Store',
                    ),
                    'help'        => 'Help text',
                ),

                array(
                    'id'          => 'gh_change_woocommerce_menu_icon',
                    'type'        => 'text',
                    'title'       => 'Change WooCommerce menu icon',
                    'after'       => 'Change the dash icon of WooCommcerce menu item, you can see a full list <a href="https://developer.wordpress.org/resource/dashicons/#cart">here</a> copy the code and paste it, for example the shopping cart would be f174.',
                    'attributes'    => array(
                       'placeholder' => 'f174',
                    ),
                ),

                array(
                    'id'    => 'gh_change_name_of_product_menu',
                    'type'  => 'checkbox',
                    'title' => 'Would you like to change the name of product`s singular and plural name?',
                    'label' => 'Do you want to do this?',
                    'style' => 'fancy',
                    'after' => '<i>If you check this and the other checkbox, a text field will appier.</i>'
                ),

                array(
                    'id'          => 'gh_change_singular_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change singular name of Product menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Book.',
                    'attributes'    => array(
                       'placeholder' => 'Book',
                    ),
                ),


                array(
                    'id'          => 'gh_change_plural_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change plural name of Products menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Books.',
                    'attributes'    => array(
                       'placeholder' => 'Books',
                    ),
                ),

            )
        );



        /*
        * Woo Cart Mods
        */
        $fields[] = array(
            'name'   => 'gh-cart-mods',
            'title'  => 'Woo Cart Mods',
            'icon'   => 'dashicons-cart',
            'fields' => array(

                array(
                    'id'    => 'gh_show_distinct_cart_item_count',
                    'type'  => 'checkbox',
                    'title' => 'Show Distint Cart Item Count',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                    'after' => '<i>some business models require to count the number of distinct items in the Cart, no matter their respective cart quantities. So, if there are 2x “Item 1” and 4x “Item 2”, this altered counter would show 1+1=2 and not 2+4=6. Enable to add this logic</i>'
                ),


                array(
                    'id'     => 'gh_split_cart_table',
                    'type'  => 'checkbox',
                    'title' => 'Split Cart Table',
                    'label' => 'Split Cart Table with A-Z headings',
                    'style'    => 'fancy',
                    'after' => '<i>
                                    <h2>A</h2>
                                    <div>Item 1 Title: “AAA”</div>
                                    <div>Item 2 Title: “ACC”</div>
                                    <h2>B</h2>
                                    <div>Item 3 Title: “BDD”</div>
                                    <div>Item 4 Title: “BEE”</div>
                                </i>'
                ),

               
                array(
                    'id'      => 'gh_edit_continue_shopping_link',
                    'type'    => 'select',
                    'title'   => 'Change Continue Shopping Link',
                    'query'   => array(
                        'type'          => 'callback',
                        'function'      => array( $this, 'get_all_pages' ),
                        'args'          => array()
                    ),
                    'default_option' => 'Select page to set as "Continue Shopping"',
                    'class'       => 'repeater-50 chosen width-150',
                ),

            )
        );

        /*
        * Woo Checkout Mods
        */
        $fields[] = array(
            'name'   => 'gh-checkout-mods',
            'title'  => 'Woo Checkout Mods',
            'icon'   => 'dashicons-yes-alt',
            'fields' => array(

                array(
                    'id'          => 'gh_rename_checkout_place_order_button',
                    'type'        => 'text',
                    'title'       => 'Rename "Place Order" Button',
                ),

                array(
                    'id'    => 'gh_add_content_under_place_order_button',
                    'type'  => 'checkbox',
                    'title' => 'Add Content Under Place Order Button',
                    'label' => 'Check this to add Content',
                    'style' => 'fancy',
                ),

                array(
                    'id'      => 'gh_add_content_under_place_order_button_text',
                    'type'    => 'ace_editor',
                    'title'   => 'Content below place order button',
                    'dependency' => array( 'gh_add_content_under_place_order_button', '==', 'true' ),
                    'options' => array(
                        'theme'                     => 'ace/theme/chrome',
                        'mode'                      => 'ace/mode/javascript',
                        'showGutter'                => false,
                        'showPrintMargin'           => false,
                        'enableBasicAutocompletion' => false,
                        'enableSnippets'            => false,
                        'enableLiveAutocompletion'  => false,
                    ),
                    'attributes'    => array(
                        'style'        => 'height: 300px; max-width: 700px;',
                    ),
                ),
            )
        );


        

        $options_panel = new Exopite_Options_Framework( $hook_commerce_submenu, $fields );

    }

    public function recursive_array_search_php( $needle, $haystack ){
        foreach( $haystack as $key => $value ) {
            $current_key = $key;
            if(
                $needle === $value
                OR (
                        is_array( $value )
                        && recursive_array_search_php( $needle, $value ) !== false
                    )
            ){
                return $current_key;
            }
        }
        return false;
    }

}
