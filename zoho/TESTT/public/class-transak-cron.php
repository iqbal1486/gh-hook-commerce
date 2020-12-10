<?php
function transak_cron_schedules($schedules){
    if(!isset($schedules["5min"])){
        $schedules["5min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    return $schedules;
}
add_filter('cron_schedules','transak_cron_schedules');

if (!wp_next_scheduled('transak_cron_action_hook')) {
	wp_schedule_event( time(), '5min', 'transak_cron_action_hook' );
}
add_action ( 'transak_cron_action_hook', 'transak_cron_action_callback' );


if(isset($_GET['debug_transak'])){
	add_action ( 'init', 'transak_cron_action_callback' );	
}

function transak_cron_action_callback() {
	global $table_prefix, $wpdb;
    /** 
     * Snippet Name: Alter WordPress sql tables: add a new column 
     * transak_api_status will have two values "pending" and "success"
     */  
    $table_name            = 'tourmaster_order';
    $wp_tourmaster_order   = $table_prefix . "$table_name";
    $result = $wpdb->get_results(  "SELECT * FROM ".$wp_tourmaster_order." as order_table WHERE transak_api_status = 'pending' AND order_status = 'online-paid' ORDER BY id desc LIMIT 9999"  );
	
	if(isset($_GET['debug_transak'])){
		echo "<pre style='margin-left:200px'>";
		print_r($result);
		echo "</pre>";	
	}
	
	$types = array(
			'traveller' => esc_html__('Traveller', 'tourmaster'),
			'adult' 	=> esc_html__('Adult', 'tourmaster'),
			'male' 		=> esc_html__('Male', 'tourmaster'),
			'female' 	=> esc_html__('Female', 'tourmaster'),
			'children' 	=> esc_html__('Child', 'tourmaster'),
			'student' 	=> esc_html__('Student', 'tourmaster'),
			'infant' 	=> esc_html__('Infant', 'tourmaster'),
		);

	foreach ($result as $key => $singlerecord) {
			$id 					= $singlerecord->id;
			$user_id 				= $singlerecord->user_id;
			$booking_date 			= $singlerecord->booking_date;
			$tour_id 				= $singlerecord->tour_id;
			$travel_date 			= $singlerecord->travel_date;
			$package_group_slug 	= $singlerecord->package_group_slug;
			$traveller_amount 		= $singlerecord->traveller_amount;
			$male_amount 			= $singlerecord->male_amount;
			$female_amount 			= $singlerecord->female_amount;

			$contact_info 			= $singlerecord->contact_info;
			$billing_info 			= $singlerecord->billing_info;
			$traveller_info 		= $singlerecord->traveller_info;
			$coupon_code 			= $singlerecord->coupon_code;
			$order_status 			= $singlerecord->order_status;
			$payment_date 			= $singlerecord->payment_date;
			$total_price 			= $singlerecord->total_price;
			$pricing_info 			= $singlerecord->pricing_info;
			$payment_info 			= $singlerecord->payment_info;
			$booking_detail 		= $singlerecord->booking_detail;
			$transak_api_status 		= $singlerecord->transak_api_status;

			/*VARIABLE FOR XML FORMAT*/
			$OrderID  	= $id;
			$OrderDate 	= tourmaster_date_format($booking_date, 'Y-m-d');
			$TicketDate = tourmaster_date_format($travel_date, 'Y-m-d');
			$OrderTotal = $total_price;
			
			$tour 			= get_the_title($tour_id);
			
			//$PLU 			= tourmaster_get_post_meta($tour_id, 'plu_of_tour', true);

			$plu_of_tour_for_adult 		= get_post_meta($tour_id, 'plu_of_tour_for_adult', true);
			$plu_of_tour_for_child 		= get_post_meta($tour_id, 'plu_of_tour_for_child', true);
			

			$billing_detail = empty($billing_info)? array(): json_decode($billing_info, true);
			$FirstName 		= $billing_detail['first_name'];
			$LastName 		= $billing_detail['last_name'];
			$Email 			= $billing_detail['email'];
			$Phone 			= $billing_detail['phone'];
			$Country 		= $billing_detail['country'];


			$pricing_detail 	= empty($pricing_info)? array(): json_decode($pricing_info, true);
			$price_breakdown 	= $pricing_detail['price-breakdown'];
			
			if(isset($_GET['debug_transak'])){
				echo "<pre style='margin-left:200px'>";
				print_r($singlerecord);
				echo "</pre>";	
			}
					
		
			$xmlData = '<?xml version="1.0"?>';
	        $xmlData .= '<Envelope>';
	            $xmlData .= '<Header>';
	                $xmlData .= '<SourceID>'.TRANSAK_SOURCEID.'</SourceID>';
	                $xmlData .= '<MessageID>'.TRANSAK_MESSAGEID.'</MessageID>';
	                $xmlData .= '<TimeStamp>'.date('Y-m-d H:i:s').'</TimeStamp>';
	                $xmlData .= '<MessageType>'.TRANSAK_MESSAGETYPE.'</MessageType>';
	            $xmlData .= '</Header>';
	        $xmlData .= '<Body>';
	        $xmlData .= '<Orders>';
	        $xmlData .= '<Order>';
	        $xmlData .= '<OrderID>'.$OrderID.'</OrderID>';
	        $xmlData .= '<OrderCommand>ADD</OrderCommand>';
	        $xmlData .= '<CustomerID>'.TRANSAK_CUSTOMERID.'</CustomerID>';
	        $xmlData .= '<SalesProgram>'.TRANSAK_SALESPROGRAM.'</SalesProgram>';
	        $xmlData .= '<OrderDate>'.$OrderDate.'</OrderDate>';
	        $xmlData .= '<OrderStatus>'.TRANSAK_ORDERSTATUS.'</OrderStatus>';
	        $xmlData .= '<OrderNote/>';
	        $xmlData .= '<OrderTotal>'.$OrderTotal.'</OrderTotal>';
	            $xmlData .= '<OrderContact>';
	                $xmlData .= '<Contact>';
	                    $xmlData .= '<FirstName>'.$FirstName.'</FirstName>';
	                    $xmlData .= '<MiddleName/>';
	                    $xmlData .= '<LastName>'.$LastName.'</LastName>';
	                    $xmlData .= '<Company/>';
	                    $xmlData .= '<Street1></Street1>';
	                    $xmlData .= '<Street2/>';
	                    $xmlData .= '<City></City>';
	                    $xmlData .= '<State></State>';
	                    $xmlData .= '<Zip></Zip>';
	                    $xmlData .= '<Country></Country>';
	                    $xmlData .= '<Phone>'.$Phone.'</Phone>';
	                    $xmlData .= '<Email>'.$Email.'</Email>';
	                $xmlData .= '</Contact>';
	            $xmlData .= '</OrderContact>';

	            $xmlData .= '<ShipToContact>';
	                $xmlData .= '<SameAsOrderContact>YES</SameAsOrderContact>';
	            $xmlData .= '</ShipToContact>';
	            
	            $xmlData .= '<BillToContact>';
	                $xmlData .= '<SameAsOrderContact>YES</SameAsOrderContact>';
	            $xmlData .= '</BillToContact>';
	            
	            $xmlData .= '<Shipping>';
	                $xmlData .= '<DeliveryMethod>6</DeliveryMethod>';
	            $xmlData .= '</Shipping>';
	            
	            $xmlData .= '<OrderLines>';
	                
	                /*Looping for orderlines items*/
	                foreach( $types as $type => $type_title ){
						if( !empty($price_breakdown[$type . '-amount']) ){
							
							/*Setting dynamic PLU for adult and child*/
							if($type == 'adult'){
								$PLU = $plu_of_tour_for_adult; 
							}else if($type == 'children'){
								$PLU = $plu_of_tour_for_child; 
							}

							$xmlData .= '<OrderLine>';
			                    $xmlData .= '<DetailType>1</DetailType>';
			                    $xmlData .= '<PLU>'. $PLU.'</PLU>';
			                    $xmlData .= '<Description>'. $tour.' ( '.$type_title.' )</Description>';
			                    $xmlData .= '<TaxCode/>';
			                    $xmlData .= '<TicketDate>'.$TicketDate.'</TicketDate>';
			                    $xmlData .= '<Qty>'. $price_breakdown[$type . '-amount'].'</Qty>';
			                    $xmlData .= '<Amount>'.$price_breakdown[$type . '-base-price'].'</Amount>';
			                    $xmlData .= '<Total>'. $price_breakdown[$type . '-amount'] * $price_breakdown[$type . '-base-price'].'</Total>';
			                $xmlData .= '</OrderLine>';
						}
					}
	                
	                $xmlData .= '<OrderLine>';
	                    $xmlData .= '<DetailType>'.TRANSAK_DETAILTYPE.'</DetailType>';
	                    $xmlData .= '<PaymentCode>'.TRANSAK_PAYMENTCODE.'</PaymentCode>';
	                    $xmlData .= '<Amount>'.$OrderTotal.'</Amount>';
	                    $xmlData .= '<AuthCode>'.TRANSAK_AUTHCODE.'</AuthCode>';
	                $xmlData .= '</OrderLine>';

	            $xmlData .= '</OrderLines>';
	        $xmlData .= '</Order>';
	        $xmlData .= '</Orders>';
	        $xmlData .= '</Body>';
	        $xmlData .= '</Envelope>';

	        if($plu_of_tour_for_adult || $plu_of_tour_for_child){
	        	$transakAPI 	= new TRANSAK_API();
	            $response   = $transakAPI->transak_api_call($xmlData);

		        $transakAPI->transak_log_data($response);

		        $xml        = simplexml_load_string($response);
		        
		        $Body       = $xml->Body;

		        //DEBUG DATA
		        if(isset($_GET['debug_transak'])){
		        	echo "<pre style='margin-left:200px'>";
					print_r(simplexml_load_string($xmlData));
					echo "</pre>";

			        echo "<pre style='margin-left:200px'>";
					print_r($Body);
					echo "</pre>";	
		        }
		        
		        if((string) $Body->Status == 2){
		        	/*On Success*/
		        	tourmaster_update_booking_data(
			            array(
			                'transak_api_status' => 'success',
			            ),
			            array('id' => $id),
			            array('%s'),
			            array('%d')
			        );

		        }	
	        }//IF PLU CONDITION END
	}
}
?>