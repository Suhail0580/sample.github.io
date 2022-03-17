<?php
/**
 * Manage Appointments
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatAppGetAppointmentsRoutes')) {

    class DoctreatAppGetAppointmentsRoutes extends WP_REST_Controller{

        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'appointments';
			
			//get appointment listings
			register_rest_route($namespace, '/' . $base . '/get_listing',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_listing'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Get Appointment details
			register_rest_route($namespace, '/' . $base . '/get_single',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_single'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//user authentication
			register_rest_route($namespace, '/' . $base . '/check_user',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'check_user'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			// Offline booking 
			register_rest_route($namespace, '/' . $base . '/offline_booking',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'offline_booking'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			// Booking by doctor 
			register_rest_route($namespace, '/' . $base . '/booking_by_doctor',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'booking_by_doctor'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			// Booking Step 1
			register_rest_route($namespace, '/' . $base . '/booking_step1',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'booking_step1'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			// Booking Step 2
			register_rest_route($namespace, '/' . $base . '/booking_step2',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'booking_step2'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			// Booking Step 3
			register_rest_route($namespace, '/' . $base . '/booking_step3',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'booking_step3'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			//get bookings basic information
			register_rest_route($namespace, '/' . $base . '/get_bookings',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_bookings'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			//list hospitals for doctor booking
			register_rest_route($namespace, '/' . $base . '/get_bookings_hospitals',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_bookings_hospitals'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//get slots by date
			register_rest_route($namespace, '/' . $base . '/get_slots',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_slots'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update status
			register_rest_route($namespace, '/' . $base . '/update_status',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_status'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//Appointment Request
			register_rest_route($namespace, '/' . $base . '/appointment_settings',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'appointment_settings'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//send invitation request
			register_rest_route($namespace, '/users_invitations',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'users_invitations'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Update appointment Status
			register_rest_route($namespace, '/' . $base . '/update_appointment_status',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_appointment_status'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Add new appointment
			register_rest_route($namespace, '/' . $base . '/add_appointment',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'add_appointment'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Check user if exist
			register_rest_route($namespace, '/check_user_by_email',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'check_user_by_email'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

            //appointment message string data by get
            register_rest_route($namespace, '/' . $base . '/appointment_message',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'appointment_message'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );

            //send appointment message
            register_rest_route($namespace, '/' . $base . '/send_appointment_message',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'send_appointment_message'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );

		}


        /**
         * Send Message after Appointment
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function send_appointment_message($request){
            if( function_exists('doctreat_is_demo_site') ) {
                doctreat_is_demo_site() ;
            } //if demo site then prevent

            $json           = array();
            $booking_id	    = !empty( $request['booking_id'] ) ? $request['booking_id']  : '';
            $user_id	    = !empty( $request['user_id'] ) ? $request['user_id']  : '';
            $message	    = !empty( $request['message'] ) ? $request['message']  : '';

            if(empty($booking_id) || get_post_status($booking_id) != 'publish'){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Something went wrong','doctreat_api');
                return new WP_REST_Response($json, 203);
            }
            if(empty($message)){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Message is required','doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            $post_author 	    = get_post( $booking_id );
            $post_author_id		= !empty($post_author->post_author) ? intval( $post_author->post_author ) : 0;

            $doctor_id			= get_post_meta($booking_id,'_doctor_id', true);
            $doctor_user_id		= doctreat_get_linked_profile_id($doctor_id,'post');
            $doctor_user_id		= !empty($doctor_user_id) ? intval( $doctor_user_id ) : 0;
            $allowed_id			= array($doctor_user_id,$post_author_id);

            if( !empty($doctor_user_id) && !empty($post_author_id) && (!in_array($user_id,$allowed_id))){
                $json['type'] 	 = 'error';
                $json['message'] = esc_html__('You are not authorized to update the details', 'doctreat');
                return new WP_REST_Response($json, 203);
            }

            if( function_exists('doctreat_send_booking_message') ){
                $json['type'] 		= 'success';
                $json['message'] 	= esc_html__('Message send successfuly.', 'doctreat');
                return new WP_REST_Response($json, 200);
            }


        }

		/**
         * Message on Appointment
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function appointment_message($request){
            $json                   = array();
            $booking_id	            = !empty( $request['booking_id'] ) ? $request['booking_id']  : '';
            if(!empty($booking_id)) {
                $json['title'] = esc_html__('Send Message', 'doctreat_api');
                $json['placeholder']    = esc_html__('Message', 'doctreat_api');
                $json['btn_txt']        = esc_html__('Send', 'doctreat_api');
                return new WP_REST_Response($json, 200);
            } else{
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Something went wrong','doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }

		/**
         * Check user by email
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function check_user_by_email($request){
			global $theme_settings,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			
			$email	= !empty( $request['email'] ) ? is_email( $request['email'] )  : '';
			if( empty($email) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Email address is invalid','doctreat_api');        
				return new WP_REST_Response($json, 203);
			} else {

				$user_info 		= get_user_by('email',$email);

				$user_type		= !empty($user_info->roles[0]) ? $user_info->roles[0] : '';
				
				if( !empty($user_type) && $user_type !='regular_users' ){
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'other';
					$json['message'] 		= esc_html__('This email address is being used for one of the other user other than patient. Please user another email address to find or add patient.','doctreat_api');
				} else if(!empty($user_info) && $user_type ==='regular_users' ){
					$last_name		= get_user_meta($user_info->ID, 'last_name', true );
					$first_name		= get_user_meta($user_info->ID, 'first_name', true );
					$mobile_number	= get_user_meta($user_info->ID, 'mobile_number', true );
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'registered';
					$json['first_name'] 	= !empty($first_name) ? $first_name :'';
					$json['last_name'] 		= !empty($last_name) ? $last_name : '';
					$json['mobile_number'] 	= !empty($mobile_number) ? $mobile_number : '';
					$json['user_id'] 		= $user_info->ID;
					$json['message'] 		= esc_html__('Paitent exists','doctreat_api');
				} else {
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'new';
				}
				
				return new WP_REST_Response($json, 200);
			}
		}
		
		/**
         * Add Appointment
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function add_appointment($request){
			global $theme_settings,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			$post_meta			= array();
			$date_formate		= get_option('date_format');
			$time_format 		= get_option('time_format');

			$required	= array(
				'booking_hospitals' => esc_html__( 'Please select the hospital', 'doctreat_api' ),
				'booking_slot' 		=> esc_html__( 'Please select the time slot', 'doctreat_api' ),
				'appointment_date' 	=> esc_html__( 'Please select the time slot', 'doctreat_api' ),
				'email' 			=> 	esc_html__( 'Email is required field', 'doctreat_api' )
			);

			$required	= apply_filters( 'doctreat_doctreat_booking_doctor_validation', $required );

			if(empty($request['user_id'])){
				$required['email']		= esc_html__( 'Email is required field', 'doctreat_api' );
				$required['first_name']	= esc_html__( 'First name is required field', 'doctreat_api' );
				$required['last_name']	= esc_html__( 'Last name is required field', 'doctreat_api' );
			}

			foreach($required as $key => $req){
				if( empty($request[$key]) ) {
					$json['type'] 		= 'error';
					$json['message'] 	= $req;
					return new WP_REST_Response($json, 203);
				}
			}

			$booking_hospitals	= !empty( $request['booking_hospitals'] ) ? sanitize_text_field( $request['booking_hospitals'] ) : '';
			$doctor_id			= !empty( $request['id'] ) ? sanitize_text_field( $request['id'] ) : '';
			$appointment_date	= !empty( $request['appointment_date'] ) ? sanitize_text_field( $request['appointment_date'] ) : '';
			$myself				= !empty( $request['myself'] ) ? sanitize_text_field( $request['myself'] ) : '';
			$other_name			= !empty( $request['other_name'] ) ? sanitize_text_field( $request['other_name'] ) : '';
			$relation			= !empty( $request['relation'] ) ? sanitize_text_field( $request['relation'] ) : '';
			$booking_service 	= !empty( $request['service'] ) ? ( $request['service'] ) : array();
			$booking_content 	= !empty( $request['booking_content'] ) ? sanitize_textarea_field( $request['booking_content'] ) : '';
			$booking_slot 		= !empty( $request['booking_slot'] ) ? sanitize_text_field( $request['booking_slot'] ) : '';
			$create_user 		= !empty( $request['create_user'] ) ? sanitize_text_field( $request['create_user'] ) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$email				= !empty( $request['email'] ) ? is_email( $request['email'] ) : '';
			$phone				= !empty( $request['phone'] ) ? ( $request['phone'] ) : '';
			$first_name			= !empty( $request['first_name'] ) ? sanitize_text_field( $request['first_name'] ) : '';
			$last_name			= !empty( $request['last_name'] ) ? sanitize_text_field( $request['last_name'] ) : '';
			$total_price		= !empty( $request['total_price'] ) ? sanitize_text_field( $request['total_price'] ) : 0;
			
			$doctor_id			= doctreat_get_linked_profile_id($doctor_id);
			$rand_val			= rand(1, 9999);

			$am_specialities 		= doctreat_get_post_meta( $doctor_id,'am_specialities');
			$am_specialities		= !empty( $am_specialities ) ? $am_specialities : array();

			$update_services	= array();
			if( !empty($booking_service) ){
				foreach($booking_service as $key => $service_single){
					if( !empty( $service_single ) ){
						foreach( $service_single as $service ){
							$price		= !empty( $am_specialities[$key][$service]['price'] ) ?  $am_specialities[$key][$service]['price'] : 0;
							$price		= !empty( $price ) ? $price : 0;
							$update_services[$key][$service]	= $price;
						}
					}
				}
			}

			if( !empty( $booking_hospitals ) && !empty( $booking_slot ) && !empty( $appointment_date )) {

				if(!empty($user_id)){
					$auther_id	= $user_id;
				} else {
					$auther_id		= 1;
					if(!empty($create_user)){
						$user_type		 	= 'regular_users';
						$random_password 	= rand(900,10000);
						$display_name		= explode('@',$email);
						$display_name		= !empty($display_name[0]) ? $display_name[0] : $first_name;
						$user_nicename   	= sanitize_title( $display_name );
						$userdata = array(
							'user_login'  		=> $display_name,
							'user_pass'    		=> $random_password,
							'user_email'   		=> $email,  
							'user_nicename'   	=> $user_nicename,  
							'display_name'		=> $display_name
						);

						$user_identity 	 = wp_insert_user( $userdata );
						if ( is_wp_error( $user_identity ) ) {
							$json['type'] 		= "error";
							$json['message'] 	= esc_html__("User already exists. Please try another one.", 'doctreat_api');
							return new WP_REST_Response($json, 203);
						} else {
							wp_update_user( array('ID' => esc_sql( $user_identity ), 'role' => esc_sql( $user_type ), 'user_status' => 1 ) );

							$wpdb->update(
									$wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
							);
							$auther_id		= $user_identity;
							update_user_meta( $user_identity, 'first_name', $first_name );
							update_user_meta( $user_identity, 'last_name', $last_name ); 
							update_user_meta( $user_identity, 'phone', $phone ); 
							update_user_meta( $user_identity, '_is_verified', 'yes' );
							update_user_meta($user_identity, 'show_admin_bar_front', false);

							//Create Post
							$user_post = array(
								'post_title'    => wp_strip_all_tags( $display_name ),
								'post_status'   => 'publish',
								'post_author'   => $user_identity,
								'post_type'     => $user_type,
							);

							$post_id    = wp_insert_post( $user_post );

							if( !is_wp_error( $post_id ) ) {

								$profile_data	= array();
								$profile_data['am_first_name']	= $first_name;
								$profile_data['am_last_name']	= $last_name;
								update_post_meta($post_id, 'am_' . $user_type . '_data', $profile_data);

								//Update user linked profile
								update_user_meta( $user_identity, '_linked_profile', $post_id );
								update_post_meta($post_id, '_is_verified', 'yes');					
								update_post_meta($post_id, '_linked_profile', $user_identity);
								update_post_meta( $post_id, 'is_featured', 0 );

								if( function_exists('doctreat_full_name') ) {
									$name	= doctreat_full_name($post_id);
								} else {
									$name	= $first_name;
								}

								$user_name	= $name;
								//Send email to users
								if (class_exists('Doctreat_Email_helper')) {
									$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
									$emailData = array();

									$emailData['name'] 							= $name;
									$emailData['password'] 						= $random_password;
									$emailData['email'] 						= $email;

									$emailData['site'] 							= $blogname;
									//Send code
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										if( !empty($user_type) && $user_type === 'regular_users' ){
											$email_helper->send_regular_user_email($emailData);
										}
									}

									//Send admin email
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										$email_helper->send_admin_email($emailData);
									}
								}
							}
						}
					}
				}

				$post_title		= !empty( $theme_settings['appointment_prefix'] ) ? $theme_settings['appointment_prefix'] : esc_html__('APP#','doctreat_api');
				$contents		= !empty( $booking_content ) ? $booking_content : '';
				$booking_post 	= array(
									'post_title'    => wp_strip_all_tags( $post_title ).'-'.$rand_val,
									'post_status'   => 'publish',
									'post_author'   => intval($auther_id),
									'post_type'     => 'booking',
									'post_content'	=> $contents
								);

				$booking_id    			= wp_insert_post( $booking_post );

				if(!empty($booking_id)){
					$post_meta['_with_patient']['relation']			= !empty( $relation ) ? $relation : '';
					$post_meta['_with_patient']['other_name']		= !empty( $other_name ) ? $other_name : '';

					if(empty($user_id)){
						update_post_meta($booking_id,'bk_phone',$phone );
						update_post_meta($booking_id,'bk_email',$email );
						update_post_meta($booking_id,'bk_username',$first_name.' '.$last_name );
						if(!empty($create_user)){
							update_post_meta($booking_id,'_user_type','regular_users' );
						} else {
							update_post_meta($booking_id,'_user_type','guest' );
							$user_name									= !empty($first_name) ? $first_name.' '.$last_name : '';
							$post_meta['_user_details']['user_type']	= 'guest';
							$post_meta['_user_details']['full_name']	= $user_name;
							$post_meta['_user_details']['first_name']	= $first_name;
							$post_meta['_user_details']['last_name']	= $last_name;
							$post_meta['_user_details']['email']		= $email;
						}
					} else {
						$patient_profile_id	= doctreat_get_linked_profile_id($user_id);
						$name			= doctreat_full_name($patient_profile_id);
						$user_details	= get_userdata($user_id);
						$phone			= get_user_meta( $user_id, 'phone', true );
						update_post_meta($booking_id,'_user_type','regular_users' );

						update_post_meta($booking_id,'bk_phone',$phone );
						update_post_meta($booking_id,'bk_email',$user_details->user_email );
						update_post_meta($booking_id,'bk_username',$name );
					}

					$am_consultant_fee	= get_post_meta( $booking_hospitals ,'_consultant_fee',true);


					$price								= !empty( $am_consultant_fee ) ? $am_consultant_fee : 0;

					$post_meta['_services']				= $update_services;
					$post_meta['_consultant_fee']		= $price;
					$post_meta['_price']				= $total_price;
					$post_meta['_appointment_date']		= $appointment_date;
					$post_meta['_slots']				= $booking_slot;
					$post_meta['_hospital_id']			= $booking_hospitals;

					$hospital_id		= $post_meta['_hospital_id'];
					
					update_post_meta($booking_id,'_appointment_date',$post_meta['_appointment_date'] );
					update_post_meta($booking_id,'_booking_type','doctor' );

					update_post_meta($booking_id,'_price',$total_price );
					update_post_meta($booking_id,'_booking_service',$post_meta['_services'] );
					update_post_meta($booking_id,'_booking_slot',$post_meta['_slots'] );
					update_post_meta($booking_id,'_booking_hospitals',$post_meta['_hospital_id'] );
					update_post_meta($booking_id,'_hospital_id',$hospital_id );
					update_post_meta($booking_id,'_doctor_id',$doctor_id );
					update_post_meta($booking_id,'_am_booking',$post_meta );

					if( function_exists('doctreat_send_booking_message') ){
						doctreat_send_booking_message($booking_id);
					}

					if (class_exists('Doctreat_Email_helper')) {
						$emailData	= array();
						$emailData['user_name']		= $user_name;
						$time						= !empty($post_meta['_slots']) ? explode('-',$post_meta['_slots']) : array();
						$start_time					= !empty($time[0]) ? date($time_format, strtotime('2016-01-01' .$time[0])) : '';
						$end_time					= !empty($time[1]) ? date($time_format, strtotime('2016-01-01' .$time[1])) : '';
						$hospital_id				= get_post_meta($post_meta['_hospital_id'],'hospital_id',true);

						$emailData['doctor_name']	= doctreat_full_name($doctor_id);
						$emailData['doctor_link']	= get_the_permalink($doctor_id);
						$emailData['hospital_name']	= doctreat_full_name($hospital_id);
						$emailData['hospital_link']	= get_the_permalink($hospital_id);

						$emailData['appointment_date']	= !empty($post_meta['_appointment_date']) ? date($date_formate,strtotime($post_meta['_appointment_date'])) : '';
						$emailData['appointment_time']	= $start_time.' '.esc_html__('to','doctreat_api').' '.$end_time;
						$emailData['price']				= doctreat_price_format($total_price,'return');
						$emailData['consultant_fee']	= doctreat_price_format($post_meta['_consultant_fee'],'return');
						$emailData['description']		= $contents;

						if (class_exists('DoctreatBookingNotify')) {
							$email_helper				= new DoctreatBookingNotify();
							$emailData['email']			= $email;
							$email_helper->send_approved_email($emailData);
						}
					}
				}

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__( 'Your booking has been successfully submitted.', 'doctreat_api' );
				return new WP_REST_Response($json, 200);
			}
		}
		
		/**
         * Approve Appointment
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_appointment_status($request){
			global $theme_settings,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$post_id			= !empty( $request['id'] ) ? ( $request['id'] ) : '';
			$status 			= !empty( $request['status'] ) ? ( $request['status'] ) : '';
			$offline_package	= doctreat_theme_option('payment_type');
			$time_format 		= get_option('time_format');
			$json 				= array();
			$update_post		= array();

			if( empty( $status ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Appointment status is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if( empty( $post_id ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Appointment ID is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if( !empty( $post_id ) && !empty( $status ) ){
				// for offline 
				if( !empty($offline_package) && $offline_package === 'offline' ){
					$order_id	= get_post_meta( $post_id, '_order_id', true );
					if( !empty($order_id) && class_exists('WC_Order') ){
						$order = new WC_Order($order_id);

						if (!empty($order)) {
							if( $status === 'publish' ){
								$order->update_status( 'completed' );
								$order->save();
							} else if($status === 'cancelled' ){
								$order->update_status( 'cancelled' );
								$order->save();
							}
						}
					}
				}


				$update_post['ID'] 			= $post_id;
				$update_post['post_status'] = $status;

				// Update the post into the database
				wp_update_post( $update_post );

				$appointment_date		= get_post_meta($post_id,'_appointment_date',true);
				$appointment_date		= !empty( $appointment_date ) ? $appointment_date : '';
				$booking_slot			= get_post_meta($post_id,'_booking_slot',true);
				$booking_slot			= !empty( $booking_slot ) ? $booking_slot : array();
				$slot_key_val 			= explode('-', $booking_slot);
				$start_time				= date($time_format, strtotime('2016-01-01' . $slot_key_val[0]));
				$end_time				= date($time_format, strtotime('2016-01-01' . $slot_key_val[1]));
				$start_time				= !empty( $start_time ) ? $start_time : '';
				$end_time				= !empty( $end_time ) ? $end_time : '';

				$booking_hospitals		= get_post_meta($post_id,'_booking_hospitals',true);
				$hospital_id			= get_post_meta($booking_hospitals,'hospital_id',true);
				$hospital_name			= doctreat_full_name($hospital_id);
				$hospital_name			= !empty( $hospital_name ) ? $hospital_name : '';
				$doctor_id				= get_post_meta($post_id,'_doctor_id',true);
				$doctor_id				= !empty( $doctor_id ) ? $doctor_id : '';
				$doctor_name			= doctreat_full_name($doctor_id);
				$doctor_name			= !empty( $doctor_name ) ? $doctor_name : '';
				$author_id 				= get_post_field( 'post_author', $post_id );
				$user_profile_id		= doctreat_get_linked_profile_id($author_id);
				$user_info				= get_userdata($author_id);

				if( !empty( $user_info ) ) {
					$emailData['email']			= $user_info->user_email;
					$emailData['user_name']		= doctreat_full_name($user_profile_id);
				}

				$emailData['doctor_name']		= $doctor_name;
				$emailData['doctor_link']		= get_the_permalink( $doctor_id );
				$emailData['hospital_link']		= get_the_permalink( $hospital_id );
				$emailData['hospital_name']		= $hospital_name;
				$emailData['description']		= get_the_content($post_id);
				$emailData['appointment_date']	= $appointment_date;
				$emailData['appointment_time']	= $start_time.' '.esc_html__('to', 'doctreat_api').' '.$end_time;

				if (class_exists('Doctreat_Email_helper')) {
					if (class_exists('DoctreatBookingNotify')) {
						$email_helper = new DoctreatBookingNotify();
						if( $status === 'publish' ){
							$email_helper->send_approved_email($emailData);
							if( function_exists('doctreat_send_booking_message') ){
								doctreat_send_booking_message($post_id);
							}
						} else if( $status === 'cancelled' ){
							$email_helper->send_cancelled_email($emailData);
						}
					}
				}

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Booking status has been updated.', 'doctreat_api');
			}
			
			return new WP_REST_Response($json, 200);
		}
		
		/**
         * Invite users
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function users_invitations($request){
			global $theme_settings,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			
			$fields			= array(
				'emails' 	=> esc_html('Email is required field.','doctreat_api')
			);

			foreach($fields as $key => $val ) {
				if( empty( $request[$key] ) ){
					$json['message'] 	= $val;        
					$json['type'] 		= 'error';
					return new WP_REST_Response($json, 300);
				}
			}

			$emails		= !empty($request['emails']) ? $request['emails'] : array();
			$content	= !empty($request['content']) ? $request['content'] : '';

			$user_name			= doctreat_get_username($user_id);
			$user_detail		= get_userdata($user_id);
			$user_type			= doctreat_get_user_type( $user_id );
			$linked_profile   	= doctreat_get_linked_profile_id($user_id);
			$profile_url		= get_the_permalink( $linked_profile );

			if (class_exists('Doctreat_Email_helper')) {
				if (class_exists('DoctreatInvitationsNotify')) {
					$email_helper = new DoctreatInvitationsNotify();
					if(!empty($emails)){
						$signup_page_url = doctreat_get_signup_page_url('step', '1');
						$signup_page_url	= !empty($signup_page_url) ? $signup_page_url : home_url('/');
						foreach($emails as $email){
							if( is_email($email) ){
								$emailData = array();

								$emailData['email']     				= $email;
								$emailData['invitation_content']     	= $content;
								$emailData['invitation_link']     		= $signup_page_url;

								if(!empty($user_type) && $user_type === 'doctors'){
									$emailData['doctor_name']				= $user_name;
									$emailData['doctor_profile_url']		= $profile_url;
									$emailData['doctor_email']				= $user_detail->user_email;
									$emailData['invited_hospital_email']	= $email;
									$email_helper->send_hospitals_email($emailData);
								} else if(!empty($user_type) && $user_type ==='hospitals'){
									$emailData['hospital_name']				= $user_name;
									$emailData['hospital_profile_url']		= $profile_url;
									$emailData['hospital_email']			= $user_detail->user_email;
									$emailData['invited_docor_email']		= $email;
									$email_helper->send_doctors_email($emailData);
								}
							}
						}
					}

					$json['type'] 		= 'success';
					$json['message'] 	= esc_html__( 'Invitation(s) has been sent successfully', 'doctreat_api' );
					return new WP_REST_Response($json, 200);
				} 
			}
			
		}
		
		/**
         * Add offline booking
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function offline_booking($request){
			global $theme_settings,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			$post_meta			= array();
			$date_formate		= get_option('date_format');
			$time_format 		= get_option('time_format');

			$required	= array(
				'booking_hospitals' => esc_html__( 'Please select the hospital', 'doctreat_api' ),
				'service' 			=> esc_html__( 'Please select the service(s)', 'doctreat_api' ),
				'booking_slot' 		=> esc_html__( 'Please select the time slot', 'doctreat_api' ),
				'appointment_date' 	=> esc_html__( 'Please select the appointment', 'doctreat_api' ),
				'email' 			=> 	esc_html__( 'Email is required field', 'doctreat_api' )
			);

			if(empty($request['user_id'])){
				$required['email']		= esc_html__( 'Email address is required', 'doctreat_api' );
				$required['first_name']	= esc_html__( 'First name is required', 'doctreat_api' );
				$required['last_name']	= esc_html__( 'Last name is required', 'doctreat_api' );
			}

			foreach($required as $key => $req){
				if( empty($request[$key]) ) {
					$json['type'] 		= 'error';
					$json['message'] 	= $req;
					return new WP_REST_Response($json, 203);
				}
			}

			$booking_hospitals	= !empty( $request['booking_hospitals'] ) ? sanitize_text_field( $request['booking_hospitals'] ) : '';
			$doctor_id			= !empty( $request['doctor_id'] ) ? sanitize_text_field( $request['doctor_id'] ) : '';
			$appointment_date	= !empty( $request['appointment_date'] ) ? sanitize_text_field( $request['appointment_date'] ) : '';
			$myself				= !empty( $request['myself'] ) ? sanitize_text_field( $request['myself'] ) : '';
			$other_name			= !empty( $request['other_name'] ) ? sanitize_text_field( $request['other_name'] ) : '';
			$relation			= !empty( $request['relation'] ) ? sanitize_text_field( $request['relation'] ) : '';
			$booking_service 	= !empty( $request['service'] ) ? ( $request['service'] ) : array();
			$booking_content 	= !empty( $request['booking_content'] ) ? sanitize_textarea_field( $request['booking_content'] ) : '';
			$booking_slot 		= !empty( $request['booking_slot'] ) ? sanitize_text_field( $request['booking_slot'] ) : '';
			$create_user 		= !empty( $request['create_user'] ) ? sanitize_text_field( $request['create_user'] ) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$email				= !empty( $request['email'] ) ? is_email( $request['email'] ) : '';
			$first_name			= !empty( $request['first_name'] ) ? sanitize_text_field( $request['first_name'] ) : '';
			$last_name			= !empty( $request['last_name'] ) ? sanitize_text_field( $request['last_name'] ) : '';
			$total_price		= !empty( $request['total_price'] ) ? sanitize_text_field( $request['total_price'] ) : 0;
			$rand_val			= rand(1, 9999);

			if( !empty( $booking_hospitals ) && !empty( $booking_slot ) && !empty( $appointment_date )) {
				
				if(!empty($user_id)){
					$auther_id	= $user_id;
				} else {
					$auther_id		= 1;
					$verify_user	= !empty( $theme_settings['verify_user'] ) ? $theme_settings['verify_user'] : '';
					if(!empty($create_user)){
						$user_type		 	= 'regular_users';
						$random_password 	= rand(900,10000);
						$display_name		= explode('@',$email);
						$display_name		= !empty($display_name[0]) ? $display_name[0] : $first_name;
						$user_nicename   	= sanitize_title( $display_name );
						$userdata = array(
							'user_login'  		=> $display_name,
							'user_pass'    		=> $random_password,
							'user_email'   		=> $email,  
							'user_nicename'   	=> $user_nicename,  
							'display_name'		=> $display_name
						);
						
						$user_identity 	 = wp_insert_user( $userdata );
						if ( is_wp_error( $user_identity ) ) {
							$json['type'] 		= "error";
							$json['message'] 	= esc_html__("User already exists. Please try another one.", 'doctreat_api');
							return new WP_REST_Response($json, 203);
						} else {
							wp_update_user( array('ID' => esc_sql( $user_identity ), 'role' => esc_sql( $user_type ), 'user_status' => 1 ) );

							$wpdb->update(
									$wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
							);
							
							$auther_id		= $user_identity;
							update_user_meta( $user_identity, 'first_name', $first_name );
							update_user_meta( $user_identity, 'last_name', $last_name );  
							update_user_meta( $user_identity, '_is_verified', 'yes' );
							update_user_meta($user_identity, 'show_admin_bar_front', false);
							
							//Create Post
							$user_post = array(
								'post_title'    => wp_strip_all_tags( $display_name ),
								'post_status'   => 'publish',
								'post_author'   => $user_identity,
								'post_type'     => $user_type,
							);
				
							$post_id    = wp_insert_post( $user_post );
							
							if( !is_wp_error( $post_id ) ) {
								
								$profile_data	= array();
								$profile_data['am_first_name']	= $first_name;
								$profile_data['am_last_name']	= $last_name;
								update_post_meta($post_id, 'am_' . $user_type . '_data', $profile_data);
								
								//Update user linked profile
								update_user_meta( $user_identity, '_linked_profile', $post_id );
								update_post_meta($post_id, '_is_verified', 'yes');					
								update_post_meta($post_id, '_linked_profile', $user_identity);
								update_post_meta( $post_id, 'is_featured', 0 );

								if( function_exists('doctreat_full_name') ) {
									$name	= doctreat_full_name($post_id);
								} else {
									$name	= $first_name;
								}

								$user_name	= $name;
								
								//Send email to users
								if (class_exists('Doctreat_Email_helper')) {
									$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
									$emailData = array();
									$emailData['name'] 				= $name;
									$emailData['password'] 			= $random_password;
									$emailData['email'] 			= $email;
									
									$emailData['site'] 				= $blogname;
									//Send code
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										if( !empty($user_type) && $user_type === 'regular_users' ){
											$email_helper->send_regular_user_email($emailData);
										}
									}
									
									//Send admin email
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										$email_helper->send_admin_email($emailData);
									}
								}
							}
						}
					}
				}

				$post_title		= !empty( $theme_settings['appointment_prefix'] ) ? $theme_settings['appointment_prefix'] : esc_html__('APP#','doctreat_api');
				$contents		= !empty( $booking_content ) ? $booking_content : '';
				$booking_post 	= array(
									'post_title'    => wp_strip_all_tags( $post_title ).'-'.$rand_val,
									'post_status'   => 'publish',
									'post_author'   => intval($auther_id),
									'post_type'     => 'booking',
									'post_content'	=> $contents
								);
				
				$booking_id    			= wp_insert_post( $booking_post );
				
				if(!empty($booking_id)){
					if( !empty( $myself ) && $myself === 'someelse' ) {
						$post_meta['_with_patient']['relation']			= !empty( $relation ) ? $relation : '';
						$post_meta['_with_patient']['other_name']		= !empty( $other_name ) ? $other_name : '';
					}

					if(empty($user_id)){
						if(!empty($create_user)){
							update_post_meta($booking_id,'_user_type','regular_users' );
						} else {
							update_post_meta($booking_id,'_user_type','guest' );
							$user_name									= !empty($first_name) ? $first_name.' '.$last_name : '';
							$post_meta['_user_details']['user_type']	= 'guest';
							$post_meta['_user_details']['full_name']	= $user_name;
							$post_meta['_user_details']['first_name']	= $first_name;
							$post_meta['_user_details']['last_name']	= $last_name;
							$post_meta['_user_details']['email']		= $email;
						}
					} else {
						$name	= doctreat_full_name($user_id);
						update_post_meta($booking_id,'_user_type','regular_users' );
					}

					$am_consultant_fee	= get_post_meta( $booking_hospitals ,'_consultant_fee',true);
					$hospital_id		= get_post_meta( $booking_hospitals, 'hospital_id', true );
					$price				= !empty( $am_consultant_fee ) ? $am_consultant_fee : 0;

					$post_meta['_services']				= $booking_service;
					$post_meta['_consultant_fee']		= $price;
					$post_meta['_price']				= $total_price;
					$post_meta['_appointment_date']		= $appointment_date;
					$post_meta['_slots']				= $booking_slot;
					$post_meta['_hospital_id']			= $booking_hospitals;

					update_post_meta($booking_id,'_appointment_date',$post_meta['_appointment_date'] );
					update_post_meta($booking_id,'_booking_type','doctor' );
					update_post_meta($booking_id,'_price',$total_price );
					update_post_meta($booking_id,'_booking_service',$post_meta['_services'] );
					update_post_meta($booking_id,'_booking_slot',$post_meta['_slots'] );
					update_post_meta($booking_id,'_booking_hospitals',$post_meta['_hospital_id'] );
					update_post_meta($booking_id,'_hospital_id',$hospital_id );
					update_post_meta($booking_id,'_doctor_id',$doctor_id );
					update_post_meta($booking_id,'_am_booking',$post_meta );

					if (class_exists('Doctreat_Email_helper')) {
						$emailData['user_name']		= $user_name;
						$time						= !empty($post_meta['_slots']) ? explode('-',$post_meta['_slots']) : array();
						$start_time					= !empty($time[0]) ? date($time_format, strtotime('2016-01-01' .$time[0])) : '';
						$end_time					= !empty($time[1]) ? date($time_format, strtotime('2016-01-01' .$time[1])) : '';
						$hospital_id				= get_post_meta($post_meta['_hospital_id'],'hospital_id',true);
						$emailData['doctor_name']	= doctreat_full_name($doctor_id);
						$emailData['doctor_link']	= get_the_permalink($doctor_id);
						$emailData['hospital_name']	= doctreat_full_name($hospital_id);
						$emailData['hospital_link']	= get_the_permalink($hospital_id);
						
						$emailData['appointment_date']	= !empty($post_meta['_appointment_date']) ? date($date_formate,strtotime($post_meta['_appointment_date'])) : '';
						$emailData['appointment_time']	= $start_time.' '.esc_html__('to','doctreat_api').' '.$end_time;
						$emailData['price']				= doctreat_price_format($total_price,'return');
						$emailData['consultant_fee']	= doctreat_price_format($post_meta['_consultant_fee'],'return');
						$emailData['description']		= $contents;

						if (class_exists('DoctreatBookingNotify')) {
							$email_helper				= new DoctreatBookingNotify();
							$emailData['email']			= $email;
							$email_helper->send_request_email($emailData);
						}
					}
				}
				
				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__( 'Your booking has successfully submitted.', 'doctreat_api' );
				return new WP_REST_Response($json, 200);
			}
		}

		/**
         *Check patient by email
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function check_user($request){
			$json	= array();
			$email	= !empty( $request['email'] ) ? is_email( $request['email'] )  : '';
			
			if( empty($email) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Email address is requird','doctreat_api');        
				return new WP_REST_Response($json, 203);
			} else {
				
				$user_info 		= get_user_by('email',$email);
				
				$user_type		= !empty($user_info->roles[0]) ? $user_info->roles[0] : '';
				if( !empty($user_type) && $user_type !='regular_users' ){
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'other';
					$json['message'] 		= esc_html__('This email address is being used for one of the other user other than patient. Please user another email address to find or add patient.','doctreat_api');
				} else if(!empty($user_info) && $user_type ==='regular_users' ){
					$last_name	= get_user_meta($user_info->ID, 'last_name', true );
					$first_name	= get_user_meta($user_info->ID, 'first_name', true );
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'registered';
					$json['first_name'] 	= !empty($first_name) ? $first_name :'';
					$json['last_name'] 		= !empty($last_name) ? $last_name : '';
					$json['user_id'] 		= $user_info->ID;
					$json['message'] 		= esc_html__('Paitent exists','doctreat_api');
				} else {
					$json['type'] 			= 'success';
					$json['success_type'] 	= 'new';
				}
				return new WP_REST_Response($json, 200);
			}
		}

		/**
         * Booking step2
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function booking_step2($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? ( $request['user_id'] ) : '';
			$json 			= array();
			$key_hash 		= rand( 1000, 9999 );
			$emailData 		= array();
			
			if( $user_id ) {
				$current_user 		= get_userdata($user_id);
				$password			= !empty( $request['password'] ) ? ( $request['password'] ) : '';
				$retype_password	= !empty( $request['retype_password'] ) ? ( $request['retype_password'] ) : '';

				if( empty( $password ) ){
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__( 'Password is required.', 'doctreat_api' );
					return new WP_REST_Response($json, 203);
				}

				if( empty( $retype_password ) ){
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__( 'Retype password is required.', 'doctreat_api' );
					return new WP_REST_Response($json, 203);
				}

				if(  $password != $retype_password ){
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__( 'Password does not match.', 'doctreat_api' );
					return new WP_REST_Response($json, 203);
				}

				if( !empty( $password ) && !empty( $retype_password ) && $password === $retype_password ) {
					if( wp_check_password( $password, $current_user->user_pass, $user_id ) ) {
						$booking_steps_details	= get_user_meta( $user_id, 'booking_steps_details',true);
						$json['email']								= $current_user->user_email;
						$json['type'] 								= 'success';
						$json['message'] 							= esc_html__( 'Your informations are correct', 'doctreat_api' );
						$booking_steps_details['booking']['email']				= $current_user->user_email;
						$booking_steps_details['booking']['user_type']			= 'registered';
						$booking_steps_details['booking']['authentication_code']	= $key_hash;
						update_user_meta( $user_id, 'booking_steps_details',$booking_steps_details);
						
						//update booking
						update_user_meta($user_id,'booking_auth',$key_hash);
						
						$profile_id		= doctreat_get_linked_profile_id( $user_id );
						$name			= doctreat_full_name( $profile_id );
						$name			= !empty( $name ) ? esc_html( $name ) : '';
						
						//Send verification code
						if (class_exists('Doctreat_Email_helper')) {
							if ( class_exists('DoctreatBookingNotify') ) {
								$email_helper 					= new DoctreatBookingNotify();
								$emailData['name'] 				= $name;
								$emailData['email']				= $current_user->user_email;
								$emailData['verification_code'] = $key_hash;
								$email_helper->send_verification($emailData);
							} 
						}
						$json['type'] 					= 'success';
						$json['authentication_code'] 	= $key_hash;
						$json['message'] 				= esc_html__( 'Your informations are correct', 'doctreat_api' );
						return new WP_REST_Response($json, 200);
					} else {
						$json['type'] 		= 'error';
						$json['message'] 	= esc_html__( 'Password is invalid.', 'doctreat_api' );
						return new WP_REST_Response($json, 203);
					}
				}
			} 
		}
		/**
         * Booking step3
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function booking_step3($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json			= array();
			$user_id		= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$code			= !empty( $request['authentication_code'] ) ? sanitize_text_field( $request['authentication_code'] ) : '';
			
			if( empty( $code ) ) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Please enter authentication code.', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}

			if( empty( $user_id ) ) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('User ID is required.', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}

			if( !empty($code) && !empty($user_id) ){
				$user_code	= get_user_meta($user_id,'booking_auth',true);
				if(!empty($user_code) && ($code === $user_code) ){

					$json['type'] 		= 'success';
					$json['message'] 	= esc_html__( 'Please wait you are redirecting to checkout page.', 'doctreat_api' );
					return new WP_REST_Response($json, 200);
				} else {
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__( 'Authentication code is incorrect.', 'doctreat_api' );
					return new WP_REST_Response($json, 203);
				}
			}
		}
		
		/**
         * Booking step1
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function booking_step1($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$booking_hospitals	= !empty( $request['booking_hospitals'] ) ? sanitize_text_field( $request['booking_hospitals'] ) : '';
			$doctor_id			= !empty( $request['id'] ) ? sanitize_text_field( $request['id'] ) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$appointment_date	= !empty( $request['appointment_date'] ) ? sanitize_text_field( $request['appointment_date'] ) : '';
			$myself				= !empty( $request['myself'] ) ? sanitize_text_field( $request['myself'] ) : '';
			
			$relation			= !empty( $request['relation'] ) ? sanitize_text_field( $request['relation'] ) : '';
			$booking_services 	= !empty( $request['service'] ) ? ( $request['service'] ) : array();
			$booking_content 	= !empty( $request['booking_content'] ) ? sanitize_textarea_field( $request['booking_content'] ) : '';
			$booking_slot 		= !empty( $request['booking_slot'] ) ? sanitize_text_field( $request['booking_slot'] ) : '';
			
			$bk_email			= !empty( $request['bk_email'] ) ? sanitize_text_field( $request['bk_email'] ) : '';
			$bk_phone			= !empty( $request['bk_phone'] ) ? sanitize_text_field( $request['bk_phone'] ) : '';
			$other_name			= !empty( $request['other_name'] ) ? sanitize_text_field( $request['other_name'] ) : '';
		
			
			if( empty( $bk_email ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Email is required field', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}
			
			if( empty( $bk_phone ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Phone number is required field', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}

			if( empty( $booking_hospitals ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Please select the hospital', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}
			
			/*if( empty( $booking_services ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Please select the service(s)', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}*/
			
			if( empty( $booking_slot ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Please select the time slot', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}
			
			if( empty( $appointment_date ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Please select the appointment date', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}
			
			$booking_steps_details	= array();
			if( !empty( $booking_hospitals ) && !empty( $booking_slot ) && !empty( $appointment_date ) && !empty($user_id)) {
				if( !empty( $myself ) && $myself === 'someelse' ) {
					$booking_steps_details['booking']['_other_name']	= $other_name;
					$booking_steps_details['booking']['_relation']		= $relation;
				}
				
				$booking_service	= array();
				if( !empty($booking_services) ) {
					foreach($booking_services as $keys => $values ){
						if( !empty($values) ){
							foreach($values as $val){
								if( !empty($val) && !empty($keys) ){
								    $booking_service[$keys][$val]	= $val;
							    }
							}
						}
					}
				}

				$booking_steps_details['booking']['post_title']				= get_the_title( $booking_hospitals );
				$booking_steps_details['booking']['post_content']			= $booking_content;
				$booking_steps_details['booking']['_booking_service']		= $booking_service;
				$booking_steps_details['booking']['_booking_slot']			= $booking_slot;
				$booking_steps_details['booking']['_booking_hospitals']		= $booking_hospitals;
				$booking_steps_details['booking']['_appointment_date']		= $appointment_date;
				$booking_steps_details['booking']['_doctor_id']				= $doctor_id;
				$booking_steps_details['booking']['_myself']				= $myself;
				
				$booking_steps_details['booking']['bk_email']				= $bk_email;
				$booking_steps_details['booking']['bk_phone']				= $bk_phone;
				$booking_steps_details['booking']['other_name']				= $other_name;

				update_user_meta( $user_id, 'booking_steps_details',$booking_steps_details );

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__( 'Your booking has been submitted.', 'doctreat_api' );
				return new WP_REST_Response($json, 200);

			}
		}
		
		/**
         * get slots by day
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_slots($request){
			$date			= !empty( $request['date'] ) ? ( $request['date'] ) : '';
			$team_id		= !empty( $request['team_id'] ) ? ( $request['team_id'] ) : '';
			
			if(!empty($date) && !empty($team_id)){
				$slots	= array();
				if( function_exists('doctreat_get_time_slots_slots')){
					$day	= strtolower(date('D',strtotime($date)));
					$slots	= doctreat_get_time_slots_slots($team_id,$day,$date);
				}
				
				$items 	= maybe_unserialize($slots);
				return new WP_REST_Response($items, 200);
			}
		}

		/**
         * get booking hospitals 
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_bookings_hospitals($request){
			global $theme_settings;
			
			$json	= array();
			$item	= array();
			$items	= array();
			$posts_data	= array();

			$profile_id			= !empty( $request['profile_id'] ) ?  $request['profile_id'] : '';

			if(!empty($profile_id)){
				$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';
				
				if(!empty($doctor_location) && $doctor_location === 'clinic'){
					$hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
					if(!empty($hospital_id)){
						$post   = get_post( $hospital_id );
						$posts_data[$post->ID]['team_id'] 			= !empty($hospital_id) ? intval($hospital_id) : 0;;
						$posts_data[$post->ID]['hospital_name'] 	= $post->post_title;
						$posts_data[$post->ID]['slug'] 				= $post->post_name;
					}
					
				}else{
					$user_id				= doctreat_get_linked_profile_id( $profile_id ,'post');
					
					$args = array(
							'posts_per_page' 	=> -1,
							'post_type' 		=> 'hospitals_team',
							'post_status' 		=> 'publish',
							'suppress_filters' 	=> false,
							'author'			=> $user_id
						);

					$options = '';
					$cust_query = get_posts($args);
					if( !empty($cust_query) ) {
						foreach ($cust_query as $key => $dir) {
							$hospital_id	= get_post_meta( $dir->ID, 'hospital_id',true);
							if(!empty($hospital_id)){
								$posts_data[$dir->ID]['team_id'] 		= intval( $dir->ID );
								$posts_data[$dir->ID]['hospital_name'] 	= get_the_title($hospital_id);
								$posts_data[$dir->ID]['slug'] 			= $dir->post_name;
							}
						}
					}
				}
				
				if(!empty($doctor_location) && $doctor_location === 'both'){
					$hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
					
					$post   = get_post( $hospital_id );
					$posts_data[$post->ID]['team_id'] 			= !empty($hospital_id) ? intval($hospital_id) : 0;;
					$posts_data[$post->ID]['hospital_name'] 	= $post->post_title;
					$posts_data[$post->ID]['slug'] 				= $post->post_name;
				}
				
				if(empty($posts_data)){
					$posts_data[0]['team_id'] 	= 0;
					$posts_data[0]['hospital_name'] 	= esc_html__('No location has added yet','doctreat_api');
					$posts_data[0]['slug'] 	= '';
				}

				$item		= array_values($posts_data);

				return new WP_REST_Response($item, 200);
				
			} else{
				$posts	= get_posts(
									array('numberposts'	=> -1,
									'post_type'			=> 'hospitals_team')
								);


				if( !empty($posts) ) {
					foreach ($posts as $post) {
						$posts_data[$post->ID]['team_id'] 	= intval( $post->ID );
						$posts_data[$post->ID]['hospital_name'] 	= $post->post_title;
						$posts_data[$post->ID]['slug'] 	= $post->post_name;
					}
				}

				$item		= array_values($posts_data);

				return new WP_REST_Response($item, 200);
			}
		}
		
		/**
         * get booking details
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_bookings($request){
			$item			= array();
			$items			= array();
			$team_id		= !empty( $request['team_id'] ) ? ( $request['team_id'] ) : '';
			$profile_id		= !empty( $request['profile_id'] ) ? ( $request['profile_id'] ) : '';
			
			$specilities_list	= array();
			
			if( !empty($profile_id) && !empty($team_id) ){

				$specialities 			= doctreat_get_post_meta( $team_id,'am_specialities');
				$am_specialities 		= doctreat_get_post_meta( $profile_id,'am_specialities');
				$am_specialities		= !empty( $am_specialities ) ? $am_specialities : array();
				
				$hospital_array		= array();
				$hospital_id		= get_post_meta( $team_id, 'hospital_id',true);
				$consultant_fee		= get_post_meta( $team_id ,'_consultant_fee',true);
				$db_services 		= get_post_meta( $team_id, '_team_services',true);
				$db_services		= !empty( $db_services ) ? $db_services : array();
				
				$specilities_array	= array();

				if(!empty($db_services)){
					foreach($db_services as $key => $vals){
						$services			= array();
						$services_array		= array();
						if(!empty($vals)){
							foreach($vals as $k => $v ){
							    $v                          = intval($v);
								$services['price']			= !empty($am_specialities[$key][$v]['price']) ? $am_specialities[$key][$v]['price'] : '';
								$services['service_id']		= $v;
								$services['service_title']	= doctreat_get_term_name($v,'services');
								$services['formated_price']	= !empty($am_specialities[$key][$v]['price']) ? doctreat_price_format($am_specialities[$key][$v]['price'],'return') : '';
								$services_array[]	= $services;
							}
						}

						$specilities_array['title']		= doctreat_get_term_name($key ,'specialities');
						$specilities_array['ID']		= $key;
						$logo 							= get_term_meta( $key, 'logo', true );
						$specilities_array['logo']		= !empty( $logo['url'] ) ? $logo['url'] : '';
						$specilities_array['services']	= $services_array;
						$specilities_list[]				= $specilities_array;
					}
				}

				$hospital_array['specilities']		= $specilities_list;
				$hospital_array['fee_formate']		= !empty( $consultant_fee ) ? doctreat_price_format( $consultant_fee,'return') : '';
				$hospital_array['consultant_fee']	= !empty($consultant_fee) ? $consultant_fee : 0;
				$hospital_array['hospital_id']		= !empty($hospital_id) ? intval($hospital_id) : 0;
				$hospital_array['team_id']			= !empty($team_id) ? intval($team_id) : 0;
				$hospital_array['hospital_name']	= !empty($hospital_id) ? get_the_title($hospital_id) : '';
				$slots	= array();
				
				if( function_exists('doctreat_get_time_slots_slots')){
					$day	= strtolower(date('D'));
					$date	= date('Y-m-d');
					$slots	= doctreat_get_time_slots_slots($team_id,$day,$date);
				}
				
				$hospital_array['slots']	= !empty($slots) ? $slots : array();
				$items 					= maybe_unserialize($hospital_array);
				
				return new WP_REST_Response($items, 200);
			}else{
				return new WP_REST_Response($items, 203);
			}
		}
		
		/**
         * Update Appointment status
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function appointment_settings($request){
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json				= array();
			$post_array			= array();
			$default_slots		= array();
			$post_meta			= array();
			$hospital_id		= !empty( $request['hospital_id'] ) ? $request['hospital_id'] : '';
			
			$required	= array(
				'hospital_id' 	=> esc_html__('Appointment location is required.','doctreat_api'),
				'start_time' 	=> esc_html__('Start time is required.','doctreat_api'),
				'end_time' 		=> esc_html__('End time is required.','doctreat_api'),
				'intervals' 	=> esc_html__('Interval is required.','doctreat_api'),
				'service' 		=> esc_html__('select atleast one services.','doctreat_api'),
				'spaces' 		=> esc_html__('Check Apointment Spaces.','doctreat_api'),
				'week_days' 	=> esc_html__('Check atleast one day.','doctreat_api'),
				'doctor_id' 	=> esc_html__('Doctor ID is required.','doctreat_api'),
			);
			
			if( get_post_type($hospital_id) == 'dc_locations' ) {
				$required	= array(
					'hospital_id' 	=> esc_html__('Appointment location is required.','doctreat_api'),
					'service' 		=> esc_html__('select atleast one services.','doctreat_api'),
					'doctor_id' 	=> esc_html__('Doctor ID is required.','doctreat_api'),
				);
				
				foreach ($required as $key => $value) {
					if( empty( ($request[$key] ) )){
						$json['type'] 		= 'error';
						$json['message'] 	= $value;        
						return new WP_REST_Response($json, 203);
					}
				}
				
				$post_id		 = $hospital_id;
				
				$doctor_id		 = !empty( $request['doctor_id'] ) ? $request['doctor_id'] : array();
				$services		 = !empty( $request['service'] ) ? $request['service'] : array();
				$consultant_fee	 = !empty( $request['consultant_fee'] ) ? sanitize_text_field( $request['consultant_fee'] ) : 0;
				$user_id		 = doctreat_get_linked_profile_id($doctor_id);

				$allow_consultation_zero	 = !empty( $theme_settings['allow_consultation_zero'] ) ? $theme_settings['allow_consultation_zero'] : 'no';

				if( !empty($allow_consultation_zero) && allow_consultation_zero === 'no' ){
					if( empty($consultant_fee)) {
						$json['type'] 		= 'error';
						$json['message'] 	= esc_html__('Consultation fee is required', 'doctreat_api');
						return new WP_REST_Response($json, 203);
					}
				}

				$post_author	= doctreat_get_post_author($post_id);
				
				$user_id		= !empty($user_id) ?  intval($user_id) : 0;
				$post_author	= !empty($post_author) ?  intval($post_author) : 0;
				
				if( $post_author !== $user_id) {
					/*$json['type'] 		= 'error';
					$json['message'] 	= esc_html__('You are not an authorized user to update this.', 'doctreat_api');
					return new WP_REST_Response($json, 203);*/
				}

				if( !empty( $post_id ) ){
					update_post_meta( $post_id ,'_consultant_fee',$consultant_fee);
					update_post_meta( $post_id,'_team_services',$services);
					
					$json['type']    = 'success';
					$json['message'] = esc_html__('Settings have been updated', 'doctreat_api');

					return new WP_REST_Response($json, 200);
				}
			}else{
			
				foreach($request as $k => $v){
					$json[$k]    = $v;
				}

				foreach ($required as $key => $value) {
					if( empty( ($request[$key] ) )){
						$json['type'] 		= 'error';
						$json['message'] 	= $value;        
						return new WP_REST_Response($json, 203);
					}
				}

				$user_id		= !empty( $request['doctor_id'] ) ? ( $request['doctor_id'] ) : '';
				$post_id  		= doctreat_get_linked_profile_id($user_id);
				$doctor_name	= doctreat_full_name($post_id);
				$doctor_name	= !empty( $doctor_name ) ? esc_html($doctor_name) : get_the_title($post_id);
				$doctor_link	= get_the_permalink($post_id);
				$doctor_link	= !empty( $doctor_link ) ? esc_url( $doctor_link ) : '';


				$consultant_fee		= !empty( $request['consultant_fee'] ) ? $request['consultant_fee'] : 0;
				$start_time			= !empty( $request['start_time'] ) ? $request['start_time']  : '';
				$post_content		= !empty( $request['content'] ) ? sanitize_textarea_field( $request['content'] ) : '';
				$end_time			= !empty( $request['end_time'] ) ? $request['end_time']  : '';
				$intervals			= !empty( $request['intervals'] ) ? $request['intervals'] : '';
				$durations			= !empty( $request['durations'] ) ? $request['durations'] : '';
				$services			= !empty( $request['service'] ) ? $request['service']  : array();
				$spaces				= !empty( $request['spaces'] ) ? $request['spaces']  	: '';
				$week_days			= !empty( $request['week_days'] ) ?	$request['week_days'] : array();
				$total_duration		= intval($durations) + intval($intervals);
				$diff_time			= ((intval($end_time) - intval($start_time))/100)*60;
				$check_interval		= $diff_time - $total_duration;

				if( $start_time > $end_time || $check_interval <  0 ) {
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__('Your end time is less then time interval.','doctreat_api');        
					return new WP_REST_Response($json, 203);
				}

				$team_prefix		= !empty( $theme_settings['hospital_team_prefix'] ) ? $theme_settings['hospital_team_prefix'] : esc_html__('TEAM #','doctreat_api');
				$uniqe_id			= dc_unique_increment();
				$post_title			= !empty( $hospital_id ) ? $team_prefix.$uniqe_id : '';
				$team_status		= 'pending';


				if( !empty( $spaces ) && $spaces === 'others' ) {
					if( empty( $request['custom_spaces'] )) {
						$json['type'] 		= 'error';
						$json['message'] 	= esc_html__('Custom spaces value is requird.','doctreat_api');        
						return new WP_REST_Response($json, 203);
					} else {
						$post_meta['am_custom_spaces']	= sanitize_text_field( $request['custom_spaces'] );
						$spaces				= !empty( $post_meta['am_custom_spaces'] ) ?  	$post_meta['am_custom_spaces']  	: '1';
					}
				} 

				$default_slots 			= get_post_meta($post_id, 'am_slots_data', true);
				$default_slots			= !empty( $default_slots ) ? $default_slots : array();
				$space_data				= array();
				$slots_array			= array();
				$space_data['spaces']	= $spaces;
				$start_time_slot		= $start_time;

				$default_slots['start_time']	= $start_time;
				$default_slots['end_time']		= $end_time;
				$default_slots['durations']		= $durations;
				$default_slots['intervals']		= $intervals;
				$default_slots['spaces']		= $spaces;

				do {

					$newStartTime = date("Hi", strtotime('+' . $durations . ' minutes', strtotime($start_time_slot)));
					$default_slots['slots'][$start_time_slot . '-' . $newStartTime] = $space_data;

					if ($intervals):
						$time_to_add = $intervals + $durations;
					else :
						$time_to_add = $durations;
					endif;

					$start_time_slot = date("Hi", strtotime('+' . $time_to_add . ' minutes', strtotime($start_time_slot)));
					if ($start_time_slot == '0000'):
						$start_time_slot = '2400';
					endif;
				} while ($start_time_slot < $end_time);

				if( !empty( $week_days ) ){
					foreach( $week_days as $day ) {
						$slots_array[$day]	= $default_slots;
					}
				}

				if( empty( $post_title ) ){

					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__('Appointment title is required.', 'doctreat_api');
					return new WP_REST_Response($json, 203);
				} else {
					$post_array['post_title']		= $post_title;
					$post_array['post_content']		= $post_content;
					$post_array['post_author']		= $user_id;
					$post_array['post_type']		= 'hospitals_team';
					$post_array['post_status']		= $team_status;
					$team_id 						= wp_insert_post($post_array);

					if( $team_id ) {

						$post_meta['am_start_time']		= $start_time;
						$post_meta['am_end_time']		= $end_time;
						$post_meta['am_durations']		= $durations;
						$post_meta['am_intervals']		= $intervals;
						$post_meta['am_spaces']			= $spaces;
						$post_meta['am_week_days']		= $week_days;

						update_post_meta( $team_id,'am_hospitals_team_data', $post_meta );
						update_post_meta( $team_id,'am_team_id', $uniqe_id );
						update_post_meta( $team_id,'am_slots_data', $slots_array );
						update_post_meta( $team_id,'hospital_id',$hospital_id );
						update_post_meta( $team_id,'_team_services',$services);
						update_post_meta( $team_id,'_consultant_fee',$consultant_fee);

						$hospital_name		= doctreat_full_name($hospital_id);
						$hospital_name		= !empty( $hospital_name ) ? esc_html( $hospital_name ) : get_the_title($hospital_id);
						$hospital_user_id	= doctreat_get_linked_profile_id($hospital_id,'post');
						$hospital_info		= get_userdata($hospital_user_id);

						$emailData['email'] 				= $hospital_info->user_email;
						$emailData['doctor_link'] 			= $doctor_link;
						$emailData['doctor_name'] 			= $doctor_name;
						$emailData['hospital_name'] 		= $hospital_name;

						// emai to hospital 
						if (class_exists('Doctreat_Email_helper')) {
							if (class_exists('DoctreatHospitalTeamNotify')) {
								$email_helper = new DoctreatHospitalTeamNotify();
								$email_helper->send_request_email($emailData);
							}
						}


						$json['type']    = 'success';
						$json['message'] = esc_html__('Appointment has been submmitted.', 'doctreat_api'); 
						return new WP_REST_Response($json, 200);
					}
				}
			}
		}

		/**
         * Update Appointment status
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_status($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$post_id		= !empty( $request['booking_id'] ) ? ( $request['booking_id'] ) : '';
			$status 		= !empty( $request['status'] ) ? ( $request['status'] ) : '';
			$time_format 	= get_option('time_format');
			$json 			= array();
			$update_post	= array();
			
			if( empty( $status ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Post status is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if( empty( $post_id ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Post Id is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if( !empty( $post_id ) && !empty( $status ) ){
				$update_post['ID'] 			= $post_id;
				$update_post['post_status'] = $status;

				// Update the post into the database
				wp_update_post( $update_post );

				$appointment_date			= get_post_meta($post_id,'_appointment_date',true);
				$appointment_date			= !empty( $appointment_date ) ? $appointment_date : '';

				$booking_slot				= get_post_meta($post_id,'_booking_slot',true);
				$booking_slot				= !empty( $booking_slot ) ? $booking_slot : array();

				$slot_key_val 	= explode('-', $booking_slot);
				$start_time		= date($time_format, strtotime('2016-01-01' . $slot_key_val[0]));
				$end_time		= date($time_format, strtotime('2016-01-01' . $slot_key_val[1]));

				$start_time		= !empty( $start_time ) ? $start_time : '';
				$end_time		= !empty( $end_time ) ? $end_time : '';

				$booking_hospitals		= get_post_meta($post_id,'_booking_hospitals',true);
				$hospital_id			= get_post_meta($booking_hospitals,'hospital_id',true);
				$hospital_name			= doctreat_full_name($hospital_id);
				$hospital_name			= !empty( $hospital_name ) ? $hospital_name : '';
				$doctor_id				= get_post_meta($post_id,'_doctor_id',true);
				$doctor_id				= !empty( $doctor_id ) ? $doctor_id : '';
				$doctor_name			= doctreat_full_name($doctor_id);
				$doctor_name			= !empty( $doctor_name ) ? $doctor_name : '';
				$author_id 				= get_post_field( 'post_author', $post_id );
				$user_profile_id		= doctreat_get_linked_profile_id($author_id);
				$user_info				= get_userdata($author_id);

				if( !empty( $user_info ) ) {
					$emailData['email']			= $user_info->user_email;
					$emailData['user_name']		= doctreat_full_name($user_profile_id);
				}

				$emailData['doctor_name']		= $doctor_name;
				$emailData['doctor_link']		= get_the_permalink( $doctor_id );
				$emailData['hospital_link']		= get_the_permalink( $hospital_id );
				$emailData['hospital_name']		= $hospital_name;
				$emailData['description']		= get_the_content($post_id);
				$emailData['appointment_date']	= $appointment_date;
				$emailData['appointment_time']	= $start_time.' to '.$end_time;

				if (class_exists('Doctreat_Email_helper')) {
					if (class_exists('DoctreatBookingNotify')) {
						$email_helper = new DoctreatBookingNotify();
						if( $status === 'publish' ){
							$email_helper->send_approved_email($emailData);
						} else if( $status === 'cancelled' ){
							$email_helper->send_cancelled_email($emailData);
						}
					}
				}

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Booking status has been updated.', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			}
			
		}
		
		/**
         * Get Appointment single
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_single($request){
            $services_array 		= array();
            $item					= array();
            $item['all_sp_serv']	= array();

			$booking_id		= !empty( $request['booking_id'] ) ? intval( $request['booking_id'] ) : "";
			$url_identity	= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : "";
			$width			= 40;
			$height			= 40;
			
			$date_format	= get_option('date_format');
			$time_format 	= get_option('time_format');
			$doctor_id		= get_post_meta($booking_id,'_doctor_id', true);
			$booking_date	= get_post_meta($booking_id,'_am_booking', true);
			$location_id	= get_post_meta($booking_id,'_booking_hospitals', true);
			$hospital_id	= get_post_meta($location_id,'hospital_id', true);

			$slots			= get_post_meta($booking_id,'_booking_slot', true);
			$slots			= !empty( $slots ) ? explode('-', $slots) : '';
			$tine_slot		= $slots;
			
			if( !empty( $slots ) ) {
				$slots	= date( $time_format,strtotime('2016-01-01' . $slots[0]) );
			}

			$content		= get_post_field('post_content',$booking_id );
            $contents		= !empty( $content ) ? $content : '';
			$booking_slot	= get_post_meta($booking_id,'_booking_slot', true);
			$booking_slot	= !empty( $booking_slot ) ? $booking_slot : '';
			
			$services		= get_post_meta($booking_id,'_booking_service', true);
			$services		= !empty( $services ) ? $services : array();
			
			$post_auter		= get_post_field( 'post_author',$booking_id );
			$link_id		= doctreat_get_linked_profile_id( $post_auter );
			
			$name		= get_post_meta($booking_id,'bk_username', true);
			$email		= get_post_meta($booking_id,'bk_email', true);
			$phone		= get_post_meta($booking_id,'bk_phone', true);

			$name		= !empty($name) ? $name : '';
			$email		= !empty($email) ? $email : '';
			$phone		= !empty($phone) ? $phone : '';
			
			$thumbnail      	= doctreat_prepare_thumbnail($link_id, $width, $height);
			$post_status		= get_post_status( $booking_id );
			$post_status_key	= $post_status;
			
			if($post_status === 'pending'){
				$post_status	= esc_html__('Pending','doctreat_api');
			} elseif($post_status === 'publish'){
				$post_status	= esc_html__('Confirmed','doctreat_api');
			} elseif($post_status === 'draft'){
				$post_status	= esc_html__('Pending','doctreat_api');
			}
			
			$user_type		= function_exists('doctreat_get_user_type') ? apply_filters('doctreat_get_user_type', $post_auter ) : '';
			$user_types		= function_exists('doctreat_list_user_types') ?  doctreat_list_user_types() : array();
			$user_type		= $user_types[$user_type];
			
			$location		= function_exists('doctreat_get_location') ? doctreat_get_location($link_id) : '';
			
			$relation		= doctreat_patient_relationship();
			$title			= get_the_title( $hospital_id );
			
			$total_price	= !empty($booking_date['_price']) ? $booking_date['_price'] : 0;
			$consultant_fee	= !empty($booking_date['_consultant_fee']) ? $booking_date['_consultant_fee'] : 0;

            $appointment_date		= get_post_meta($booking_id,'_appointment_date', true);
            $posttype			= get_post_type($hospital_id);
            if( !empty($posttype) && $posttype === 'hospitals_team' ){
                $hospital_id		= get_post_meta($hospital_id,'hospital_id',true);
                $location_title 	= esc_html( get_the_title( $hospital_id ) );
            } else {
                $location_title 	= esc_html( get_the_title( $hospital_id ) );
            }

            $item['google_calender']    = '';
            $item['yahoo_calender']     = '';
            if( !empty( $appointment_date ) && !empty( $tine_slot[0] ) && !empty( $tine_slot[1] ) ) {
                $startTime 	= new DateTime($appointment_date.' '.$tine_slot[0]);
                $startTime	= $startTime->format('Y-m-d H:i');

                $endTime 	= new DateTime($appointment_date.' '.$tine_slot[1]);
                $endTime	= $endTime->format('Y-m-d H:i');

                $google_calender	= doctreat_generate_GoogleLink($name,$startTime,$endTime,$contents,$location_title);
                $yahoo_calender		= doctreat_generate_YahooLink($name,$startTime,$endTime,$contents,$location_title);

                $item['google_calender']    = !empty( $google_calender ) ? esc_url($google_calender) : '';
                $item['yahoo_calender']	    = !empty( $yahoo_calender ) ? esc_url($yahoo_calender) : '';
            }

            $item['all_sp_serv'] = array();
            if (!empty($services)) {
                $spe_title = '';
                $services_array = array();
                $add_service_arr = array();
                $item['all_sp_serv'] = array();

                foreach ($services as $spe => $sers) {
                    if (!empty($spe)) {
                        $spe_title = doctreat_get_term_name($spe, 'specialities');
                    }
                    $sers_array = array();
                    if (!empty($sers)) {
                        foreach ($sers as $k => $val) {
                            if (!empty($k)) {
                                $single_price = 0;
                                if (!empty($k) && $k === $val) {
                                    $am_specialities = !empty($doctor_id) ? doctreat_get_post_meta($doctor_id, 'am_specialities') : array();
                                    $am_specialities = !empty($am_specialities) ? $am_specialities : array();
                                    $single_price = !empty($am_specialities[$spe][$k]['price']) ? $am_specialities[$spe][$k]['price'] : 0;
                                } else {
                                    $single_price = $val;
                                }
                                $sers_array[] = array(
                                    'name' => doctreat_get_term_name($k, 'services'),
                                    'price' => html_entity_decode(doctreat_price_format($single_price, 'return'))
                                );
                            }
                        }
                    }
                    $add_service_arr[] = array(
                        'title' => $spe_title,
                        'services' => $sers_array
                    );
                }
                $item['all_sp_serv'] = $add_service_arr;
            }
			$item['name']			= !empty( $name ) ? $name : '';
			$item['email']			= !empty( $email ) ? $email : ''; 
			$item['phone']			= !empty( $phone ) ? $phone : ''; 
			$item['post_status']	= !empty( $post_status ) ? $post_status : '';
			$item['other_name']		= !empty($booking_date['_with_patient']['other_name']) ? $booking_date['_with_patient']['other_name'] : '';
			$item['other_relation']	= !empty($booking_date['_with_patient']['relation']) ? $relation[$booking_date['_with_patient']['relation']] : '';
			$item['loc_title']		= !empty( $title ) ? $title : '';
			$item['slots']			= !empty( $appointment_date ) && !empty( $slots ) ? date( $date_format,strtotime( $appointment_date ) ).'-'.esc_html($slots) : '';
			
			$item['content']		= !empty( $content ) ? $content : '';
			$item['image']			= !empty($thumbnail) ? esc_url($thumbnail) : '';
			$item['user_type']		= !empty( $user_type ) ? $user_type : '';
			
			$item['consultation_fee']	= html_entity_decode(doctreat_price_format($consultant_fee,'return'));
			$item['total_fees']		= html_entity_decode(doctreat_price_format($total_price,'return'));
			$item['country']		= !empty( $location['_country'] ) ? $location['_country'] : '';
			$items 					= maybe_unserialize($item);
			return new WP_REST_Response($items, 200);
		}
		
		/**
         * Get Appointments listings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_listing($request){
			$json	= array();
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
			$order         	= !empty($request['order']) ? $request['order'] : 'DESC';
			$sorting       	= !empty($request['orderby']) ? $request['orderby'] : 'ID';

			$user_id       		= !empty($request['user_id']) ? $request['user_id'] : '';
			$user_type       	= !empty($request['user_type']) ? $request['user_type'] : 'doctors';
			$appointment_date	= !empty($request['appointment_date']) ? date('Y-m-d',strtotime($request['appointment_date'])) : '';

			$linked_profile  	= doctreat_get_linked_profile_id($user_id);
			$date_formate		= get_option('date_format');
			$paged 				= $page_number;
			
			$args = array(
				'posts_per_page' 	=> $show_posts,
				'post_type' 		=> 'booking',
				'orderby' 			=> $sorting,
				'order' 			=> $order,
				'post_status' 		=> array('publish','pending'),
				'paged' 			=> $paged,
				'suppress_filters'  => false
			);

			$meta_query_args = array();
			if(!empty($user_type) && $user_type === 'doctors'){
				$meta_query_args[] = array(
					'key' 		=> '_doctor_id',
					'value' 	=> $linked_profile,
					'compare' 	=> '='
				);
			} else if(!empty($user_type) && $user_type === 'regular_users'){
				$args['author']	= $user_id;
			}

			$query_relation 	= array('relation' => 'AND',);
			$args['meta_query'] = array_merge($query_relation, $meta_query_args);

			if( !empty( $appointment_date ) ) {
				$meta_query_args[] = array(
										'key' 		=> '_appointment_date',
										'value' 	=> $appointment_date,
										'compare' 	=> '='
									);
				$query_relation 	= array('relation' => 'AND',);
				$args['meta_query'] = array_merge($query_relation, $meta_query_args);
			}


			if( !empty( $orderby ) ){
				$args['orderby']  	= $orderby;
			}

			if( !empty( $order ) ){
				$args['order'] 		= $order;
			}

			$query 		= new WP_Query($args);



			$count_post = $query->found_posts;
			$item				= array();
			$category_vals		= array();

			$width		= 40;
			$height		= 40;

			if( $query->have_posts() ){
				while ($query->have_posts()) : $query->the_post(); 
					global $post;
					if ($user_type == 'doctors') {
						$post_auter	= get_post_field('post_author', $post->ID);
						$link_id	= doctreat_get_linked_profile_id($post_auter);
					} elseif($user_type == 'regular_users') {
						$link_id = get_post_meta( $post->ID, '_doctor_id', true );
					}

					$name					= doctreat_full_name( $link_id );
					$item['name']			= !empty( $name ) ? $name : ''; 
					$item['appointments']	= !empty( $count_post ) ? $count_post : ''; 
					$item['ID']				= !empty( $post->ID ) ? $post->ID : 0; 
					$image			      	= doctreat_prepare_thumbnail($link_id, $width, $height);
					$item['image']			= !empty($image) ? esc_url($image) : '';
					$item['status']			= get_post_status( $post->ID );
					$ap_date				= get_post_meta( $post->ID,'_appointment_date',true);
					$item['post_date']		= !empty( $ap_date ) ? ($ap_date) : '';
					$item['day']			= date('d',strtotime($ap_date));
					$item['month']			= date('M',strtotime($ap_date));


					$items[] = maybe_unserialize($item);
				endwhile;
				wp_reset_postdata();
				return new WP_REST_Response($items, 200);	
			} else {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Records are not found.','doctreat_api');
				$items[] 			= $json;
				return new WP_REST_Response($items, 203);	
			}
		}

		/**
         * Add booking by doctor
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function booking_by_doctor($request){
			global $theme_settings,$current_user,$wpdb;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			$post_meta			= array();
			$date_formate		= get_option('date_format');
			$time_format 		= get_option('time_format');

			$required	= array(
				'booking_hospitals' => esc_html__( 'Please select the hospital', 'doctreat_api' ),
				'booking_slot' 		=> esc_html__( 'Please select the time slot', 'doctreat_api' ),
				'appointment_date' 	=> esc_html__( 'Please select the time slot', 'doctreat_api' ),
				'email' 			=> 	esc_html__( 'Email is required field', 'doctreat_api' )
			);

			if(empty($request['user_id'])){
				$required['email']		= esc_html__( 'Email is required field', 'doctreat_api' );
				$required['first_name']	= esc_html__( 'First name is required field', 'doctreat_api' );
				$required['last_name']	= esc_html__( 'Last name is required field', 'doctreat_api' );
			}

			foreach($required as $key => $req){
				if( empty($request[$key]) ) {
					$json['type'] 		= 'error';
					$json['message'] 	= $req;
					return new WP_REST_Response($json, 203);
				}
			}

			$booking_hospitals	= !empty( $request['booking_hospitals'] ) ? sanitize_text_field( $request['booking_hospitals'] ) : '';
			$doctor_id			= !empty( $request['doctor_id'] ) ? sanitize_text_field( $request['doctor_id'] ) : '';
			$appointment_date	= !empty( $request['appointment_date'] ) ? sanitize_text_field( $request['appointment_date'] ) : '';
			$myself				= !empty( $request['myself'] ) ? sanitize_text_field( $request['myself'] ) : '';
			$other_name			= !empty( $request['other_name'] ) ? sanitize_text_field( $request['other_name'] ) : '';
			$relation			= !empty( $request['relation'] ) ? sanitize_text_field( $request['relation'] ) : '';
			$booking_service 	= !empty( $request['service'] ) ? ( $request['service'] ) : array();
			$booking_content 	= !empty( $request['booking_content'] ) ? sanitize_textarea_field( $request['booking_content'] ) : '';
			$booking_slot 		= !empty( $request['booking_slot'] ) ? sanitize_text_field( $request['booking_slot'] ) : '';
			$create_user 		= !empty( $request['create_user'] ) ? sanitize_text_field( $request['create_user'] ) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$email				= !empty( $request['email'] ) ? is_email( $request['email'] ) : '';
			$phone				= !empty( $request['phone'] ) ? ( $request['phone'] ) : '';
			$first_name			= !empty( $request['first_name'] ) ? sanitize_text_field( $request['first_name'] ) : '';
			$last_name			= !empty( $request['last_name'] ) ? sanitize_text_field( $request['last_name'] ) : '';
			$total_price		= !empty( $request['total_price'] ) ? sanitize_text_field( $request['total_price'] ) : 0;
			$rand_val			= rand(1, 9999);

			$am_specialities 		= doctreat_get_post_meta( $doctor_id,'am_specialities');
			$am_specialities		= !empty( $am_specialities ) ? $am_specialities : array();

			$update_services	= array();
			if( !empty($booking_service) ){
				
				foreach($booking_service as $key => $service_single){
					if( !empty( $service_single ) ){
						foreach( $service_single as $service ){
							$price		= !empty( $am_specialities[$key][$service]['price'] ) ?  $am_specialities[$key][$service]['price'] : 0;
							$price		= !empty( $price ) ? $price : 0;
							$update_services[$key][$service]	= $price;
						}
					}
				}
			}

			if( !empty( $booking_hospitals ) && !empty( $booking_slot ) && !empty( $appointment_date )) {
				
				if(!empty($user_id)){
					$auther_id	= $user_id;
				} else {
					
					$auther_id		= 1;
					$verify_user	= !empty( $theme_settings['verify_user'] ) ? $theme_settings['verify_user'] : '';
					if(!empty($create_user)){
						$user_type		 	= 'regular_users';
						$random_password 	= rand(900,10000);
						$display_name		= explode('@',$email);
						$display_name		= !empty($display_name[0]) ? $display_name[0] : $first_name;
						$user_nicename   	= sanitize_title( $display_name );
						$userdata = array(
							'user_login'  		=> $display_name,
							'user_pass'    		=> $random_password,
							'user_email'   		=> $email,  
							'user_nicename'   	=> $user_nicename,  
							'display_name'		=> $display_name
						);
						
						$user_identity 	 = wp_insert_user( $userdata );
						if ( is_wp_error( $user_identity ) ) {
							$json['type'] 		= "error";
							$json['message'] 	= esc_html__("User already exists. Please try another one.", 'doctreat_api');
							return new WP_REST_Response($json, 203);
						} else {
							wp_update_user( array('ID' => esc_sql( $user_identity ), 'role' => esc_sql( $user_type ), 'user_status' => 1 ) );

							$wpdb->update(
									$wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
							);
							$auther_id		= $user_identity;
							update_user_meta( $user_identity, 'first_name', $first_name );
							update_user_meta( $user_identity, 'last_name', $last_name );  
							update_user_meta( $user_identity, '_is_verified', 'yes' );
							update_user_meta($user_identity, 'show_admin_bar_front', false);
							
							//Create Post
							$user_post = array(
								'post_title'    => wp_strip_all_tags( $display_name ),
								'post_status'   => 'publish',
								'post_author'   => $user_identity,
								'post_type'     => $user_type,
							);
				
							$post_id    = wp_insert_post( $user_post );
							
							if( !is_wp_error( $post_id ) ) {
								
								$profile_data	= array();
								$profile_data['am_first_name']	= $first_name;
								$profile_data['am_last_name']	= $last_name;
								update_post_meta($post_id, 'am_' . $user_type . '_data', $profile_data);
								
								//Update user linked profile
								update_user_meta( $user_identity, '_linked_profile', $post_id );
								update_post_meta($post_id, '_is_verified', 'yes');					
								update_post_meta($post_id, '_linked_profile', $user_identity);
								update_post_meta( $post_id, 'is_featured', 0 );

								if( function_exists('doctreat_full_name') ) {
									$name	= doctreat_full_name($post_id);
								} else {
									$name	= $first_name;
								}

								$user_name	= $name;
								
								//Send email to users
								if (class_exists('Doctreat_Email_helper')) {
									$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
									$emailData = array();
									$emailData['name'] 				= $name;
									$emailData['password'] 			= $random_password;
									$emailData['email'] 			= $email;
									
									$emailData['site'] 				= $blogname;
									//Send code
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										if( !empty($user_type) && $user_type === 'regular_users' ){
											$email_helper->send_regular_user_email($emailData);
										}
									}
									
									//Send admin email
									if (class_exists('DoctreatRegisterNotify')) {
										$email_helper = new DoctreatRegisterNotify();
										$email_helper->send_admin_email($emailData);
									}
								}
							}
						}
					}
				}

				$post_title		= !empty( $theme_settings['appointment_prefix'] ) ? $theme_settings['appointment_prefix'] : esc_html__('APP#','doctreat_api');
				$contents		= !empty( $booking_content ) ? $booking_content : '';
				$booking_post 	= array(
									'post_title'    => wp_strip_all_tags( $post_title ).'-'.$rand_val,
									'post_status'   => 'publish',
									'post_author'   => intval($auther_id),
									'post_type'     => 'booking',
									'post_content'	=> $contents
								);
				
				$booking_id    			= wp_insert_post( $booking_post );
				
				if(!empty($booking_id)){
					if( !empty( $myself ) && $myself === 'someelse' ) {
						$post_meta['_with_patient']['relation']			= !empty( $relation ) ? $relation : '';
						$post_meta['_with_patient']['other_name']		= !empty( $other_name ) ? $other_name : '';
						$post_meta['_with_patient']['bk_email']			= !empty( $email ) ? $email : '';
						$post_meta['_with_patient']['bk_phone']			= !empty( $phone ) ? $phone : '';

					}

					if(empty($user_id)){
						update_post_meta($booking_id,'bk_phone',$phone );
						update_post_meta($booking_id,'bk_email',$email );
						update_post_meta($booking_id,'bk_username',$first_name.' '.$last_name );
						if(!empty($create_user)){
							update_post_meta($booking_id,'_user_type','regular_users' );
						} else {
							update_post_meta($booking_id,'_user_type','guest' );
							$user_name	= $name;
							$post_meta['_user_details']['user_type']	= 'guest';
							$post_meta['_user_details']['full_name']	= $user_name;
							$post_meta['_user_details']['first_name']	= $first_name;
							$post_meta['_user_details']['last_name']	= $last_name;
							$post_meta['_user_details']['email']		= $email;
						}
					} else {
						$patient_profile_id	= doctreat_get_linked_profile_id($user_id);
						$name			= doctreat_full_name($patient_profile_id);
						$user_details	= get_userdata($user_id);
						$phone			= get_user_meta( $user_id, 'phone', true );
						update_post_meta($booking_id,'_user_type','regular_users' );

						update_post_meta($booking_id,'bk_phone',$phone );
						update_post_meta($booking_id,'bk_email',$user_details->user_email );
						update_post_meta($booking_id,'bk_username',$name );
					}

					$am_consultant_fee	= get_post_meta( $booking_hospitals ,'_consultant_fee',true);
					$hospital_id		= get_post_meta( $booking_hospitals, 'hospital_id', true );
					$price				= !empty( $am_consultant_fee ) ? $am_consultant_fee : 0;

					$post_meta['_services']				= $booking_service;
					$post_meta['_consultant_fee']		= $price;
					$post_meta['_price']				= $total_price;
					$post_meta['_appointment_date']		= $appointment_date;
					$post_meta['_slots']				= $booking_slot;
					$post_meta['_hospital_id']			= $booking_hospitals;

					$hospital_id		= !empty($post_meta['_hospital_id']) ? $post_meta['_hospital_id'] : '';
					
					update_post_meta($booking_id,'_appointment_date',$post_meta['_appointment_date'] );
					update_post_meta($booking_id,'_booking_type','doctor' );
					update_post_meta($booking_id,'_price',$total_price );
					update_post_meta($booking_id,'_booking_service',$post_meta['_services'] );
					update_post_meta($booking_id,'_booking_slot',$post_meta['_slots'] );
					update_post_meta($booking_id,'_booking_hospitals',$hospital_id );
					update_post_meta($booking_id,'_hospital_id',$hospital_id );
					update_post_meta($booking_id,'_doctor_id',$doctor_id );
					update_post_meta($booking_id,'_am_booking',$post_meta );

					update_post_meta($booking_id,'bk_username',$other_name );
					update_post_meta($booking_id,'bk_email',$bk_email );
					update_post_meta($booking_id,'bk_phone',$bk_phone );

					if (class_exists('Doctreat_Email_helper')) {
						$user_name					= !empty($first_name) ? $first_name.' '.$last_name : '';
						$emailData['user_name']		= $user_name;
						$time						= !empty($post_meta['_slots']) ? explode('-',$post_meta['_slots']) : array();
						$start_time					= !empty($time[0]) ? date($time_format, strtotime('2016-01-01' .$time[0])) : '';
						$end_time					= !empty($time[1]) ? date($time_format, strtotime('2016-01-01' .$time[1])) : '';
						$emailData['doctor_name']	= doctreat_full_name($doctor_id);
						$emailData['doctor_link']	= get_the_permalink($doctor_id);
						$emailData['hospital_name']	= doctreat_full_name($hospital_id);
						$emailData['hospital_link']	= get_the_permalink($hospital_id);
						
						$emailData['appointment_date']	= !empty($post_meta['_appointment_date']) ? date($date_formate,strtotime($post_meta['_appointment_date'])) : '';
						$emailData['appointment_time']	= $start_time.' '.esc_html__('to','doctreat_api').' '.$end_time;
						$emailData['price']				= doctreat_price_format($total_price,'return');
						$emailData['consultant_fee']	= doctreat_price_format($post_meta['_consultant_fee'],'return');
						$emailData['description']		= $contents;

						if (class_exists('DoctreatBookingNotify')) {
							$email_helper				= new DoctreatBookingNotify();
							$emailData['email']			= $email;
							$email_helper->send_request_email($emailData);
						}
					}
				}
				
				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__( 'Your booking is successfully submited.', 'doctreat_api' );
				return new WP_REST_Response($json, 200);
			}
		}
		

    }
}

add_action('rest_api_init',
function () {
	$controller = new DoctreatAppGetAppointmentsRoutes;
	$controller->register_routes();
});
