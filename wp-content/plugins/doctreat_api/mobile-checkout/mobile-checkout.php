<?php
/**
 * Template Name: Mobile Checkout Page
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
 if( isset($_GET['order_id']) ){ 
	global $wpdb,$woocommerce,$theme_settings; 
	$order_id 		= $_GET['order_id'];
	$platform		= !empty( $_GET['platform'] ) ? $_GET['platform'] : '';
	$get_data   	= "SELECT * FROM `".MOBILE_APP_TEMP_CHECKOUT."`  WHERE `id`=".$order_id;
	$temp_date   	= $wpdb->get_results($get_data);
	$temp_date   	= $temp_date[0]->temp_data;
	$order_data 	= maybe_unserialize($temp_date);
	$order_data 	= json_decode($order_data);
	$checkout_url   = wc_get_checkout_url();
	
	//separate arrays
	if ( $order_data ){
		foreach($order_data as $key => $value){
			$$key = $value;
		}	
	}
	 
	 
	$user_id 		= $customer_id; 
	$user 			= get_userdata($user_id);
	
	$order_type		= !empty( $order_type ) ?  $order_type : 'booking'; 
	 
	
    if ($user) {
        if (!is_user_logged_in()) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            $url = $_SERVER['REQUEST_URI'];
			wp_redirect( $url );
        }
    } else{
		esc_html_e('You must be login to view checkout page.','doctreat_api'); 
		return false;
	}

	//Selected Payment Method
	if(isset($payment_method) && $payment_method != ""){
		$current_method   = $payment_method;
	}
	
	if(!empty($order_type) && $order_type === 'package'){
		
		$product_id		= !empty( $product_id ) ?  $product_id : ''; 
		if( !empty( $product_id )) {
			if ( class_exists('WooCommerce') ) {
				
				$woocommerce->cart->empty_cart(); 
								
				$cart_meta					= array();
				$user_type					= doctreat_get_user_type( $user_id );
				$pakeges_features			= doctreat_get_pakages_features();
				if ( !empty ( $pakeges_features )) {
					
					foreach( $pakeges_features as $key => $vals ) {
						
						if( $vals['user_type'] === $user_type || $vals['user_type'] === 'common' ) {
							$item			= get_post_meta($product_id,$key,true);
							$text			=  !empty( $vals['text'] ) ? ' '.sanitize_text_field($vals['text']) : '';
							
							if( $key === 'dc_duration' ) {
								$feature 	= doctreat_get_duration_types($item,'title');
							} else if( $key === 'dc_duration_days' ) {
								$pkg_duration	= get_post_meta($product_id,'dc_duration',true);
								$duration 		= doctreat_get_duration_types($pkg_duration,'title');
								if( $duration === 'others') {
									$feature 	= doctreat_get_duration_types($item,'value');
								} else {
									$feature	= '';	
									$key		= '';
								}
							} else {
								$feature 	= $item;
							}
							
							if( !empty( $key )){
								$cart_meta[$key]	= $feature.$text;
							}
						}
					}
				}
				
				$cart_data = array(
					'product_id' 		=> $product_id,
					'cart_data'     	=> $cart_meta,
					'payment_type'     	=> 'subscription',
				);
				
				$woocommerce->cart->empty_cart();
				$cart_item_data = $cart_data;
				WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
			} else {
				$json = array();
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Please install WooCommerce plugin to process this order', 'doctreat_api');
			}
			
		}
	} else if( $order_type === 'booking' ){
		$product_id	= doctreat_get_booking_product_id();
		if( !empty( $product_id )) {
			if ( class_exists('WooCommerce') ) {
				$woocommerce->session->set('refresh_totals', true);
				$woocommerce->cart->empty_cart();
				$booking_steps_details	= get_user_meta( $user_id, 'booking_steps_details',true);
				
				$services				= !empty( $booking_steps_details['booking']['_booking_service'] ) ? $booking_steps_details['booking']['_booking_service'] : array();
				$doctor_id				= !empty( $booking_steps_details['booking']['_doctor_id'] ) ? ( $booking_steps_details['booking']['_doctor_id'] ) : '';
				
				$doct_hospital			= !empty( $booking_steps_details['booking']['_booking_hospitals'] ) ? $booking_steps_details['booking']['_booking_hospitals'] : '';
				$am_consultant_fee		= get_post_meta( $doct_hospital ,'_consultant_fee',true);
				$price					= !empty( $am_consultant_fee ) ? $am_consultant_fee : 0;
				
				$am_specialities 		= doctreat_get_post_meta( $doctor_id,'am_specialities');
				$am_specialities		= !empty( $am_specialities ) ? $am_specialities : array();
				
				foreach( $services as $key => $vals ) {
					foreach( $vals as $k => $v ) {
						$single_price	= !empty($am_specialities[$key][$v]['price']) ? $am_specialities[$key][$v]['price'] : 0 ;
						$price			= $price  + $single_price;
					}
				}

				$payment_type	= !empty( $theme_settings['payment_type'] ) ? $theme_settings['payment_type'] : '';
				if( !empty( $payment_type ) ){
					$woocommerce->cart->empty_cart(); 
					$cart_meta					= array();
					$admin_shares 				= 0.0;

					if( !empty( $price ) && !empty($payment_type) && $payment_type === 'online'  ){
						if( isset( $theme_settings['admin_commision'] ) && ($theme_settings['admin_commision'] > 0) ){
							$admin_shares 		= $price/100*$theme_settings['admin_commision'];
							$doctors_shares 	= $price - $admin_shares;
							$admin_shares 		= number_format($admin_shares,2,'.', '');
							$doctors_shares 	= number_format($doctors_shares,2,'.', '');
						} else{
							$admin_shares 		= 0.0;
							$doctors_shares 	= $price;
							$admin_shares 		= number_format($admin_shares,2,'.', '');
							$doctors_shares 	= number_format($doctors_shares,2,'.', '');
						}
					}
					
					$price_symbol					= doctreat_get_current_currency();
					$cart_meta['service']			= $services;
					$cart_meta['consultant_fee']	= $am_consultant_fee;
					$cart_meta['price']				= $price;
					$cart_meta['slots']				= !empty( $booking_steps_details['booking']['_booking_slot'] ) ?  $booking_steps_details['booking']['_booking_slot'] : '';
					$cart_meta['appointment_date']	= !empty( $booking_steps_details['booking']['_appointment_date'] ) ?  $booking_steps_details['booking']['_appointment_date'] : '';
					$cart_meta['hospital']	        = $doct_hospital;
					$cart_meta['doctor_id']	        = $doctor_id;
					$cart_meta['content']	        = !empty( $booking_steps_details['booking']['post_content'] ) ?  $booking_steps_details['booking']['post_content'] : '';
					$cart_meta['myself']	        = !empty( $booking_steps_details['booking']['_myself'] ) ?  $booking_steps_details['booking']['_myself'] : '';

                    $cart_meta['user_type']		    = !empty( $booking_steps_details['booking']['user_type'] ) ?  $booking_steps_details['booking']['user_type'] : '';
                    $cart_meta['other_name']		= !empty( $booking_steps_details['booking']['other_name'] ) ?  $booking_steps_details['booking']['other_name'] : '';
                    $cart_meta['bk_phone']	        = !empty( $booking_steps_details['booking']['bk_phone'] ) ?  $booking_steps_details['booking']['bk_phone'] : '';
                    $cart_meta['bk_email']			= !empty( $booking_steps_details['booking']['bk_email'] ) ?  $booking_steps_details['booking']['bk_email'] : '';

					
					if( !empty( $cart_meta['myself'] ) && $cart_meta['myself'] === 'someelse' ) {
						$cart_meta['other_name']	= !empty( $booking_steps_details['booking']['other_name'] ) ?  $booking_steps_details['booking']['other_name'] : '';
						$cart_meta['relation']		= !empty( $booking_steps_details['booking']['_relation'] ) ?  $booking_steps_details['booking']['_relation'] : '';
					}
					
					$cart_data = array(
						'product_id' 		=> $product_id,
						'cart_data'     	=> $cart_meta,
						'price'				=> doctreat_price_format($price,'return'),
						'payment_type'     	=> 'bookings'
					);

					if( !empty($payment_type) && $payment_type === 'online' && !empty($cart_data) ){
						$cart_data['admin_shares']		= $admin_shares;
						$cart_data['doctors_shares']	= $doctors_shares;
					}
					
					$woocommerce->cart->empty_cart();
					$cart_item_data = $cart_data;
					WC()->cart->add_to_cart($product_id, 1, null, null, $cart_item_data);
				} else {
					esc_html_e('Some error occur, please try again later.','doctreat_api');
					return false;
				}
			} else{
				esc_html_e('Some error occur, please try again later.','doctreat_api');
				return false;
			}
		}
	} 
	
	if( !empty( $current_method ) ){
		$woocommerce->session->set( 'chosen_payment_method', $current_method );
	}

?>
<!doctype html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<title><?php esc_html_e('Mobile Checkout Template','doctreat_api');?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<div  style="display:none;">
	  <form name="checkout" id="mobile_checkout" method="post" class="woocommerce-checkout" action="<?php echo esc_url( $checkout_url )."?platform=".$platform; ?>" enctype="multipart/form-data">
		  <input type="text" class="mobile-checkout-field" name="billing_first_name" id="billing_first_name" value="<?php echo esc_attr( $billing_info->first_name ); ?>"/>
		  <input type="text" class="mobile-checkout-field" name="billing_last_name" id="billing_last_name" value="<?php echo esc_attr( $billing_info->last_name ); ?>"/>
		  <input type="text" class="mobile-checkout-field" name="billing_country" id="billing_country" value="<?php echo esc_attr( $billing_info->country ); ?>"/>
		  <input type="text" class="mobile-checkout-field" name="billing_company" id="billing_company" value="<?php echo esc_attr( $billing_info->company ); ?>" />
		  <input type="text" class="mobile-checkout-field" name="billing_address_1" id="billing_address_1" placeholder="<?php esc_html_e('House number and street name','doctreat_api');?>" value="<?php  echo esc_attr( $billing_info->address_1 ); ?>" />
		  <input type="text" class="mobile-checkout-field" name="billing_address_2" id="billing_address_2" placeholder="<?php esc_html_e('Apartment, suite, unit etc. (optional)','doctreat_api');?>" value="<?php  echo esc_attr( $billing_info->address_2 ); ?>" />
		  <input type="text" class="mobile-checkout-field" name="billing_city" id="billing_city" value="<?php  echo esc_attr( $billing_info->city ); ?>" />
		  <input type="text" class="mobile-checkout-field" value="<?php  echo esc_attr( $billing_info->state ); ?>" name="billing_state" id="billing_state" />
		  <input type="text" class="mobile-checkout-field" name="billing_postcode" id="billing_postcode" value="<?php  echo ( $billing_info->postcode ); ?>" />
		  <input type="tel" class="mobile-checkout-field" name="billing_phone" id="billing_phone" value="<?php  echo esc_attr( $billing_info->phone ); ?>" />
		  <input type="email" class="mobile-checkout-field" name="billing_email" id="billing_email" value="<?php  echo esc_attr( $billing_info->email ); ?>" />
		  <input id="ship-to-different-address-checkbox" class="woocommerce-form__input input-checkbox"  type="checkbox" name="ship_to_different_address" value="1" <?php if(isset($sameAddress) && $sameAddress !=""){?> checked="checked" <?php } ?>>
		  <input type="text" class="mobile-checkout-field" name="shipping_first_name" id="shipping_first_name" value="<?php  echo esc_attr( $shipping_info->first_name ); ?>" />  <input type="text" class="mobile-checkout-field" name="shipping_last_name" id="shipping_last_name" value="<?php  echo esc_attr( $shipping_info->last_name ); ?>" />  
		  <input type="text" class="mobile-checkout-field" name="shipping_company" id="shipping_company" value="<?php  echo esc_attr( $shipping_info->company ); ?>" />  
		  <input type="text" class="mobile-checkout-field" name="shipping_country" id="shipping_country" value="<?php  echo esc_attr( $shipping_info->country ); ?>"/>
		  <input type="text" class="mobile-checkout-field" name="shipping_address_1" id="shipping_address_1" placeholder="<?php esc_html_e('House number and street name','doctreat_api');?>" value="<?php  echo esc_attr( $shipping_info->address_1 ); ?>" />  
		  <input type="text" class="mobile-checkout-field" name="shipping_address_2" id="shipping_address_2" placeholder="<?php esc_html_e('Apartment, suite, unit etc (optional)','doctreat_api');?>" value="<?php  echo esc_attr( $shipping_info->address_2 ); ?>" /> 
		  <input type="text" class="mobile-checkout-field" name="shipping_city" id="shipping_city" value="<?php  echo esc_attr( $shipping_info->city ); ?>" />
		  <input type="text" class="mobile-checkout-field" value="<?php  echo esc_attr( $shipping_info->state ); ?>" name="shipping_state" id="shipping_state" />
		  <input type="text" class="mobile-checkout-field" name="shipping_postcode" id="shipping_postcode" value="<?php  echo esc_attr( $shipping_info->postcode ); ?>" />  <textarea name="order_comments" class="mobile-checkout-field" id="order_comments" placeholder="<?php esc_html_e('Write notes about your order','doctreat_api');?>" rows="2" cols="5"><?php $customer_note; ?></textarea>

		  <input type="radio" checked="checked" class="shipping_method" name="shipping_method[]" id="shipping_method_0_<?php echo esc_attr( $shipping_methods ); ?><?php echo esc_attr( $shipid ); ?>" value="<?php echo  esc_attr( $shipping_methods ); ?>:<?php echo esc_attr( $shipid ); ?>" /><?php echo esc_attr( $shipping_methods ); ?>                  
	  </form>
	 </div>               
	<script type="text/javascript"> setTimeout(function(){document.getElementById("mobile_checkout").submit();}, 1000);</script>
	</body>
</html>
<?php } ?>