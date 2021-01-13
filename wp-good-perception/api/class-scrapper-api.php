<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WPGP_Scrapper_Init {

    public function scrapper_init() {

    	$wpgp_company_slug = get_option('wpgp_company_slug');

    	if(	!empty(	$wpgp_company_slug )	){
    		
    		$continue_loop = true;

    		for ($i=0; $i < 100; $i++) {

    			if( ! $continue_loop )
    				break;

    			$starter = "/?starter=".$i*10;
    			$html 		= file_get_html( WPGP_API_URL.$wpgp_company_slug.$starter );
	    			
    			if($i == 0){

    				if( $html->find('section.detailed-rating__recommend-percentage') ){

    					$recommend_percentage 	= $html->find('section.detailed-rating__recommend-percentage', 0)->plaintext;	
	    				
	    				$wpgp_review_percentage = get_option('wpgp_review_percentage');
	    				if(empty($wpgp_review_percentage)){
	    					$wpgp_review_percentage = array();
	    				}

	    				$wpgp_review_percentage[$wpgp_company_slug] = trim($recommend_percentage);
		    			update_option('wpgp_review_percentage', $wpgp_review_percentage);
    				}
    				
    			}

    			if( $html->find('article.review') ){

    				foreach($html->find('article.review') as $article) {

					    $id     		= $article->getAttribute('data-uid');
					    $name     		= $article->find('h3.review__header__name', 0)->plaintext;
					    $rating_display = $article->find('div.review__stars-number', 0)->plaintext;
					    $rating 		= explode('/', $rating_display);
					    $rating 		= trim($rating[0]);
 					    $description 	= $article->find('h3.header--long', 0)->plaintext;
					    $city 			= $article->find('p.paragraph', 0)->plaintext;
					    $date 			= $article->find('time.label', 0)->plaintext;

					    $item['id']     		= $id;
					    $item['name']     		= $name;
					    $item['rating']   	 	= $rating;
					    $item['rating_display'] = $rating_display;
					    $item['description'] 	= $description;
					    $item['city'] 			= $city;
					    $item['date'] 			= $date;
					    $item['company'] 		= $wpgp_company_slug;
					   
					    $check_post = $this->get_page_by_slug( $id, OBJECT );

					    if( !$check_post ){

					    	$my_review = array(
								'post_title'    	=> wp_strip_all_tags( $name ),
								'post_content'  	=> $description,
								'post_name'  		=> $id,
								'post_type' 		=> 'wpgp_review',
								'post_status'   	=> 'publish'
							);
							 
							// Insert the post into the database

							$post_id = wp_insert_post( $my_review );

							if( !is_wp_error( $post_id ) ){
								
								update_post_meta( $post_id, 'wpgp_rating', $rating );
								
								update_post_meta( $post_id, 'wpgp_rating_display', $rating_display );

							  	update_post_meta( $post_id, 'wpgp_city', $city );
							  	
							  	update_post_meta( $post_id, 'wpgp_date', $date );
							  	
							  	update_post_meta( $post_id, 'wpgp_company', $wpgp_company_slug );

							  	$item['scrapping_status'] 		= "Inserted . Inserted ID :  ". $post_id;

							}else{

								$item['scrapping_status'] 		= "Error while inserting";
							}

					    }else{

					    	$item['scrapping_status'] 		= "Duplicate review exists on WP";
					    }
					    
						$articles[] 			= $item;
					}

    			}else{

    				$continue_loop = false;

    			}
    		}
    	}
    	return $articles;
    }


    public function get_page_by_slug( $page_slug, $output = OBJECT, $post_type = 'wpgp_review' ) {
		global $wpdb;

		if ( is_array( $post_type ) ) {
			
			$post_type = esc_sql( $post_type );
			
			$post_type_in_string = "'" . implode( "','", $post_type ) . "'";
			
			$sql = $wpdb->prepare( "
				SELECT ID
				FROM $wpdb->posts
				WHERE post_name = %s
				AND post_type IN ($post_type_in_string)
			", $page_slug );

		} else {
			
			$sql = $wpdb->prepare( "
				SELECT ID
				FROM $wpdb->posts
				WHERE post_name = %s
				AND post_type = %s
			", $page_slug, $post_type );

		}

		$page = $wpdb->get_var( $sql );

		if ( $page )
			return get_post( $page, $output );

		return null;
	}

} // End of WPGP_Scrapper_Init class


// $data = (new WPGP_Scrapper_Init)->scrapper_init();

// echo "<pre>";
// print_r($data);
// echo "</pre>";
