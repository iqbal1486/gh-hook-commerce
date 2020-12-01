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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
        * Woo Global Mods
        */
        $fields[] = array(
            'name'   => 'gh-global-mods',
            'title'  => 'Woo Global Mods',
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(



                array(
                    'id'          => 'gh_change_plural_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change plural name of Products menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Books.',
                    'attributes'    => array(
                       'placeholder' => 'Books',
                       //'data-test'   => 'test',

                    ),
                ),

                array(
                    'id'    => 'image_1',
                    'type'  => 'image',
                    'title' => 'Image',
                ),


                array(
                    'id'      => 'switcher_1',
                    'type'    => 'switcher',
                    'title'   => 'Switcher',
                    'label'   => 'You want to do this?',
                    'default' => 'yes',
                ),


                array(
                    'id'      => 'hidden_1',
                    'type'    => 'hidden',
                    'default' => 'hidden',
                ),

              
                array(
                    'id'    => 'checkbox_2',
                    'type'  => 'checkbox',
                    'title' => 'Checkbox Fancy',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                    'after' => '<i>If you check this and the other checkbox, a text field will appier.</i>'
                ),

                array(
                    'id'     => 'text_2',
                    'type'   => 'text',
                    'title'  => 'Text Test Dependency',
                    //'dependency' => array( 'checkbox_1|checkbox_2', '==|==', 'true|true' ),
                    'dependency' => array( 'checkbox_2', '==', 'true' ),
                    'attributes'    => array(
                        'placeholder' => 'Dependency test',
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
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(


                array(
                    'id'          => 'gh_change_woocommerce_name_on_dashboard',
                    'type'        => 'text',
                    'title'       => 'Change WooCommerce name on dashboard',
                    //'before'      => 'Text Before',
                    'after'       => 'Rename WooCommerce menu name as per your wish',
                    //'class'       => 'text-class',
                    //'description' => 'Description',
                    //'default'     => 'Default Text',
                    'attributes'    => array(
                       'placeholder' => 'My Store',
                       //'data-test'   => 'test',

                    ),
                    'help'        => 'Help text',
                ),

                array(
                    'id'          => 'gh_change_woocommerce_menu_icon',
                    'type'        => 'text',
                    'title'       => 'Change WooCommerce menu icon',
                    'after'       => 'Change the dash icon of WooCommcerce menu item, you can see a full list <a href="">here</a> copy the code and paste it, for example the shopping cart would be f174.',
                    'attributes'    => array(
                       'placeholder' => 'f174',
                       //'data-test'   => 'test',

                    ),
                ),


                array(
                    'id'          => 'gh_change_singular_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change singular name of Product menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Book.',
                    'attributes'    => array(
                       'placeholder' => 'Book',
                       //'data-test'   => 'test',

                    ),
                ),


                array(
                    'id'          => 'gh_change_plural_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change plural name of Products menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Books.',
                    'attributes'    => array(
                       'placeholder' => 'Books',
                       //'data-test'   => 'test',

                    ),
                ),

                array(
                    'id'    => 'image_1',
                    'type'  => 'image',
                    'title' => 'Image',
                ),


                array(
                    'id'      => 'switcher_1',
                    'type'    => 'switcher',
                    'title'   => 'Switcher',
                    'label'   => 'You want to do this?',
                    'default' => 'yes',
                ),


                array(
                    'id'      => 'hidden_1',
                    'type'    => 'hidden',
                    'default' => 'hidden',
                ),

              
                array(
                    'id'    => 'checkbox_2',
                    'type'  => 'checkbox',
                    'title' => 'Checkbox Fancy',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                    'after' => '<i>If you check this and the other checkbox, a text field will appier.</i>'
                ),

                array(
                    'id'     => 'text_2',
                    'type'   => 'text',
                    'title'  => 'Text Test Dependency',
                    //'dependency' => array( 'checkbox_1|checkbox_2', '==|==', 'true|true' ),
                    'dependency' => array( 'checkbox_2', '==', 'true' ),
                    'attributes'    => array(
                        'placeholder' => 'Dependency test',
                    ),
                ),

                array(
                  'id'      => 'radio_2',
                  'type'    => 'radio',
                  'title'   => 'Radio Fancy',
                  'options' => array(
                    'yes'   => 'Yes, Please.',
                    'no'    => 'No, Thank you.',
                  ),
                  'default' => 'no',
                  'style'    => 'fancy',
                ),

            )
        );



        /*
        * Woo Cart Mods
        */
        $fields[] = array(
            'name'   => 'gh-cart-mods',
            'title'  => 'Woo Cart Mods',
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(



                array(
                    'id'          => 'gh_change_plural_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change plural name of Products menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Books.',
                    'attributes'    => array(
                       'placeholder' => 'Books',
                       //'data-test'   => 'test',

                    ),
                ),

                array(
                    'id'    => 'image_1',
                    'type'  => 'image',
                    'title' => 'Image',
                ),


                array(
                    'id'      => 'switcher_1',
                    'type'    => 'switcher',
                    'title'   => 'Switcher',
                    'label'   => 'You want to do this?',
                    'default' => 'yes',
                ),


                array(
                    'id'      => 'hidden_1',
                    'type'    => 'hidden',
                    'default' => 'hidden',
                ),

              
                array(
                    'id'    => 'checkbox_2',
                    'type'  => 'checkbox',
                    'title' => 'Checkbox Fancy',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                    'after' => '<i>If you check this and the other checkbox, a text field will appier.</i>'
                ),

                array(
                    'id'     => 'text_2',
                    'type'   => 'text',
                    'title'  => 'Text Test Dependency',
                    //'dependency' => array( 'checkbox_1|checkbox_2', '==|==', 'true|true' ),
                    'dependency' => array( 'checkbox_2', '==', 'true' ),
                    'attributes'    => array(
                        'placeholder' => 'Dependency test',
                    ),
                ),

                array(
                  'id'      => 'radio_2',
                  'type'    => 'radio',
                  'title'   => 'Radio Fancy',
                  'options' => array(
                    'yes'   => 'Yes, Please.',
                    'no'    => 'No, Thank you.',
                  ),
                  'default' => 'no',
                  'style'    => 'fancy',
                ),

            )
        );



        /*
        * Woo Checkout Mods
        */
        $fields[] = array(
            'name'   => 'gh-checkout-mods',
            'title'  => 'Woo Checkout Mods',
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(



                array(
                    'id'          => 'gh_change_plural_name_of_product_menu',
                    'type'        => 'text',
                    'title'       => 'Change plural name of Products menu',
                    'after'       => 'Change the name of the Product menu in dashboard. For example, Books.',
                    'attributes'    => array(
                       'placeholder' => 'Books',
                       //'data-test'   => 'test',

                    ),
                ),

                array(
                    'id'    => 'image_1',
                    'type'  => 'image',
                    'title' => 'Image',
                ),


                array(
                    'id'      => 'switcher_1',
                    'type'    => 'switcher',
                    'title'   => 'Switcher',
                    'label'   => 'You want to do this?',
                    'default' => 'yes',
                ),


                array(
                    'id'      => 'hidden_1',
                    'type'    => 'hidden',
                    'default' => 'hidden',
                ),

              
                array(
                    'id'    => 'checkbox_2',
                    'type'  => 'checkbox',
                    'title' => 'Checkbox Fancy',
                    'label' => 'Do you want to do this?',
                    'style'    => 'fancy',
                    'after' => '<i>If you check this and the other checkbox, a text field will appier.</i>'
                ),

                array(
                    'id'     => 'text_2',
                    'type'   => 'text',
                    'title'  => 'Text Test Dependency',
                    //'dependency' => array( 'checkbox_1|checkbox_2', '==|==', 'true|true' ),
                    'dependency' => array( 'checkbox_2', '==', 'true' ),
                    'attributes'    => array(
                        'placeholder' => 'Dependency test',
                    ),
                ),

            )
        );

        $options_panel = new Exopite_Options_Framework( $hook_commerce_submenu, $fields );

    }

}
