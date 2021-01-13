<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );


class WPGP_CPT_Init {

    public function __construct() {
       
        add_action( 'init', array( $this, 'wpgp_reviews' ), 0 );
    }

    public function wpgp_reviews() {

        $labels = array(
            'name'                  => _x( 'WPGP Reviews', 'Post Type General Name', 'wpgp' ),
            'singular_name'         => _x( 'WPGP Review', 'Post Type Singular Name', 'wpgp' ),
            'menu_name'             => __( 'WPGP Reviews', 'wpgp' ),
            'name_admin_bar'        => __( 'WPGP Review', 'wpgp' ),
            'archives'              => __( 'Item Archives', 'wpgp' ),
            'attributes'            => __( 'Item Attributes', 'wpgp' ),
            'parent_item_colon'     => __( 'Parent Item:', 'wpgp' ),
            'all_items'             => __( 'All Items', 'wpgp' ),
            'add_new_item'          => __( 'Add New Item', 'wpgp' ),
            'add_new'               => __( 'Add New', 'wpgp' ),
            'new_item'              => __( 'New Item', 'wpgp' ),
            'edit_item'             => __( 'Edit Item', 'wpgp' ),
            'update_item'           => __( 'Update Item', 'wpgp' ),
            'view_item'             => __( 'View Item', 'wpgp' ),
            'view_items'            => __( 'View Items', 'wpgp' ),
            'search_items'          => __( 'Search Item', 'wpgp' ),
            'not_found'             => __( 'Not found', 'wpgp' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wpgp' ),
            'featured_image'        => __( 'Featured Image', 'wpgp' ),
            'set_featured_image'    => __( 'Set featured image', 'wpgp' ),
            'remove_featured_image' => __( 'Remove featured image', 'wpgp' ),
            'use_featured_image'    => __( 'Use as featured image', 'wpgp' ),
            'insert_into_item'      => __( 'Insert into item', 'wpgp' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpgp' ),
            'items_list'            => __( 'Items list', 'wpgp' ),
            'items_list_navigation' => __( 'Items list navigation', 'wpgp' ),
            'filter_items_list'     => __( 'Filter items list', 'wpgp' ),
        );
        $args = array(
            'label'                 => __( 'WPGP Review', 'wpgp' ),
            'description'           => __( 'Reviews from Feeback Company', 'wpgp' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'custom-fields' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'wpgp_review', $args );

    }
   
} // End of WPGP_Admin_Init class

// Init the class
$wpgp_cpt_init = new WPGP_CPT_Init;