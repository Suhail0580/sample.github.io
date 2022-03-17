<?php
/**
 * Teams Management
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat App
 *
 */
if (!class_exists('DoctreatAppGetTeamRoutes')) {

    class DoctreatAppGetTeamRoutes extends WP_REST_Controller{

        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'team';
			
			//Get hospital team listing
			register_rest_route($namespace, '/' . $base . '/get_hospital_listing',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_hospital_listing'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get doctor's team listing
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
			
			//get team details
			register_rest_route($namespace, '/' . $base . '/get_team_details',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_team_details'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single
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
			
			//update team details
			register_rest_route($namespace, '/' . $base . '/update_team_details',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_team_details'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			//Remove single sloat
			register_rest_route($namespace, '/' . $base . '/remove_single_slot',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'remove_single_slot'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			
			//Remove multiple sloat
			register_rest_route($namespace, '/' . $base . '/remove_slot',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'remove_slot'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

			//Remove location
			register_rest_route($namespace, '/' . $base . '/remove_location',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'remove_location'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update slot
			register_rest_route($namespace, '/' . $base . '/update_slot',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_slot'),
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
			
			//Find location
			register_rest_route($namespace, '/' . $base . '/find_location',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'find_location'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

            //Invite doctor
            register_rest_route($namespace, '/' . $base . '/invite_doctor',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'invite_doctor'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );
        }

        /**
         * Invite Doctor
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function invite_doctor($request){
            if( function_exists('doctreat_is_demo_api') ) {
                doctreat_is_demo_api() ;
            } //if demo site then prevent

            $emails     = !empty( $request['emails'] ) ?  $request['emails'] : array();
            $content 	= !empty( $request['message'] ) ?  $request['message'] : '';
            $user_id 	= !empty( $request['user_id'] ) ?  $request['user_id'] : '';

            if(empty($emails)){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Email is required!','doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            $user_role  = '';
            $userdata   = get_userdata($user_id);
            if (!empty($userdata->roles[0])) {
                $user_role = $userdata->roles[0];
            }

            if($user_role != 'hospitals') {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('You cannot do this.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if(!empty($user_id)) {
                $user_name = doctreat_get_username($user_id);
                $user_detail = get_userdata($user_id);
                $user_type = doctreat_get_user_type($user_id);
                $linked_profile = doctreat_get_linked_profile_id($user_id);
                $profile_url = get_the_permalink($linked_profile);
                if (class_exists('Doctreat_Email_helper')) {
                    if (class_exists('DoctreatInvitationsNotify')) {
                        $email_helper = new DoctreatInvitationsNotify();
                        if (!empty($emails)) {
                            $signup_page_url = doctreat_get_signup_page_url();
                            $signup_page_url = !empty($signup_page_url) ? $signup_page_url : home_url('/');
                            foreach ($emails as $email) {
                                if (is_email($email)) {
                                    $emailData = array();
                                    $emailData['email'] = $email;
                                    $emailData['invitation_content'] = $content;
                                    $emailData['invitation_link'] = $signup_page_url;
                                    if (!empty($user_type) && $user_type === 'doctors') {
                                        $emailData['doctor_name'] = $user_name;
                                        $emailData['doctor_profile_url'] = $profile_url;
                                        $emailData['doctor_email'] = $user_detail->user_email;
                                        $emailData['invited_hospital_email'] = $email;
                                        $email_helper->send_hospitals_email($emailData);
                                    } else if (!empty($user_type) && $user_type === 'hospitals') {
                                        $emailData['hospital_name'] = $user_name;
                                        $emailData['hospital_profile_url'] = $profile_url;
                                        $emailData['hospital_email'] = $user_detail->user_email;
                                        $emailData['invited_docor_email'] = $email;
                                        $email_helper->send_doctors_email($emailData);
                                    }
                                }
                            }
                        }
                        $json['type'] = 'success';
                        $json['message'] = esc_html__('Your invitation is send to your email address.', 'doctreat_api');
                        return new WP_REST_Response($json, 200);
                    }
                }
            } else {
                $json['type'] = 'success';
                $json['message'] = esc_html__('Something went wrong.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

        }
		
		/**
         * Get hospital
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function find_location($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id 	= !empty( $request['user_id'] ) ?  $request['user_id'] : '';
			$term 	= !empty( $request['term'] ) ?  $request['term'] : '';
			$results 	= new WP_Query( array( 'posts_per_page' => -1, 's' => esc_html( $term ), 'post_type' => 'hospitals' ) );
			$items 		= array();

			if ( !empty( $results->posts ) ) {
				foreach ( $results->posts as $result ) {
					$suggestion 			= array();
					$suggestion['label'] 	= $result->post_title;
					$suggestion['id'] 		= $result->ID;
					$exist_post				= doctreat_get_total_posts_by_meta( 'hospitals_team','hospital_id',$result->ID,array( 'publish','pending' ), $user_id );

					if( empty( $exist_post )) {
						$items[] = $suggestion;
					} 

				}
			}

			return new WP_REST_Response($items, 200);
		}
		
		/**
         * Remove location
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_location($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			
			$json		= array();
			$id 		= !empty( $request['id'] ) ?  $request['id'] : '';
			$user_id 	= !empty( $request['user_id'] ) ?  $request['user_id'] : '';
			if( empty( $id ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Post ID is not set.','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}
			
			$author_id = get_post_field( 'post_author', $id );
			
			if( $user_id != $author_id ) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('You have no access to remove this location','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}
			
			wp_delete_post($id, true);

			$json['type']    	= 'success';
			$json['message'] 	= esc_html__('You are successfully remove location', 'doctreat_api');   
			return new WP_REST_Response($json, 200);
		}

		/**
         * Remove slot by day
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_slot($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json		= array();
			$id 		= !empty( $request['id'] ) ?  $request['id'] : '';
			$day 		= !empty( $request['day'] ) ?  $request['day'] : '';
			
			$user_id 	= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';

			$required	= array(
				'id' 		=> esc_html__('Post ID is required.','doctreat_api'),
				'user_id' 	=> esc_html__('User ID is required.','doctreat_api'),
				'day' 		=> esc_html__('Day key is required.','doctreat_api')
			);

			foreach ($required as $key => $value) {
				if( empty( ($request[$key] ) )){
						$json['type'] 		= 'error';
						$json['message'] 	= $value;        
						return new WP_REST_Response($json, 203);
				}
			}

			$post_author	= get_post_field('post_author', $id);

			if( $post_author != $user_id) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Sorry, you are not authorized person to update', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			$default_slots 			= get_post_meta($id, 'am_slots_data', true);
			$default_slots			= !empty( $default_slots ) ? $default_slots : array();
			unset($default_slots[$day]['slots']);
			$update				= update_post_meta($id,'am_slots_data', $default_slots);
			$json['type']    	= 'success';
			$json['message'] 	= esc_html__('You have successfully removed the slot(s).', 'doctreat_api');   

			return new WP_REST_Response($json, 200);

		}
		/**
         * Remove single slot
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_single_slot($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json		= array();
			$id 		= !empty( $request['id'] ) ?  $request['id'] : '';
			$day 		= !empty( $request['day'] ) ?  $request['day'] : '';
			$slot_key	= !empty( $request['slot_key'] ) ?  $request['slot_key']  : '';
			$user_id 	= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';

			$required	= array(
				'id' 		=> esc_html__('Post ID is required.','doctreat_api'),
				'user_id' 	=> esc_html__('User ID is required.','doctreat_api'),
				'slot_key' 	=> esc_html__('Slot key is required.','doctreat_api'),
				'day' 		=> esc_html__('Day key is required.','doctreat_api')
			);

			foreach ($required as $key => $value) {
				if( empty( ($request[$key] ) )){
						$json['type'] 		= 'error';
						$json['message'] 	= $value;        
						return new WP_REST_Response($json, 203);
				}
			}

			$post_author	= get_post_field('post_author', $id);

			if( $post_author != $user_id) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('You are not permission to update this Providing Services.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			$default_slots 			= get_post_meta($id, 'am_slots_data', true);
			$default_slots			= !empty( $default_slots ) ? $default_slots : array();


			unset($default_slots[$day]['slots'][$slot_key]);
			$update				= update_post_meta($id,'am_slots_data', $default_slots);
			$json['type']    	= 'success';
			$json['message'] 	= esc_html__('You have successfully removed slot(s).', 'doctreat_api');   

			return new WP_REST_Response($json, 200);

		}

		
		/**
         * Update Team detial
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_slot($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$slots				= array();

			$required	= array(
				'post_id' 		=> esc_html__('Post ID is required.','doctreat_api'),
				'user_id' 		=> esc_html__('User ID is required.','doctreat_api'),
				'start_time' 	=> esc_html__('Start time is required.','doctreat_api'),
				'end_time' 		=> esc_html__('End time is required.','doctreat_api'),
				'intervals' 	=> esc_html__('Interval is required.','doctreat_api'),
				'spaces' 		=> esc_html__('Check Apointment Spaces.','doctreat_api'),
				'week_day' 		=> esc_html__('Day is required.','doctreat_api'),
			);

			foreach ($required as $key => $value) {
				if( empty( ($request[$key] ) )){
					$json['type'] 		= 'error';
					$json['message'] 	= $value;        
					return new WP_REST_Response($json, 203);
				}
			}

			$post_id		= !empty( $request['post_id'] ) ? sanitize_text_field( $request['post_id']) : '';
			$user_id		= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id']) : '';
			$spaces			= !empty( $request['spaces'] ) ? sanitize_text_field( $request['spaces']) : '';
			$start_time		= !empty( $request['start_time'] ) ?  $request['start_time']  : '';
			$end_time		= !empty( $request['end_time'] ) ?  	$request['end_time']  : '';

			$post_author	= get_post_field('post_author', $post_id);
			
			if( $post_author != $user_id) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('You are not permission to update this Providing Services.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if( $start_time > $end_time) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('start time is less then end time.','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}

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

			$day				= !empty( $request['week_day'] ) ?  $request['week_day'] : '';
			$intervals			= !empty( $request['intervals'] ) ? 	$request['intervals'] : '';
			$durations			= !empty( $request['durations'] ) ? 	$request['durations'] : '';

			$total_duration		= intval($durations) + intval($intervals);
			$diff_time			= ((intval($end_time) - intval($start_time))/100)*60;
			$check_interval		= $diff_time - $total_duration;
			
			if( $start_time > $end_time || $check_interval <  0 ) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Your end date is less then time interval','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}

			$default_slots 		= get_post_meta($post_id, 'am_slots_data', true);
			$default_slots		= !empty( $default_slots ) ? $default_slots : array();
			$slots				= $default_slots[$day]['slots'];

			if( !empty( $slots ) ){
				$slots_keys	= array_keys($slots);
				foreach( $slots_keys as $slot ) {
					$slot_vals  = explode('-', $slot);
					$count_slot	= $slot_vals[0].$slot_vals[1];
					if( ($start_time <= $slot_vals[0]) && ( $slot_vals[0] <= $end_time) || ($start_time <= $slot_vals[1]) && ( $slot_vals[1] <= $end_time) ) {
						unset($slots[$slot]);
					}
				}
			}

			$spaces_data['spaces'] = $spaces;

			do {

				$newStartTime 	= date("Hi", strtotime('+' . $durations . ' minutes', strtotime($start_time)));
				$slots[$start_time . '-' . $newStartTime] = $spaces_data;

				if ($intervals):
					$time_to_add = $intervals + $durations;
				else :
					$time_to_add = $durations;
				endif;

				$start_time = date("Hi", strtotime('+' . $time_to_add . ' minutes', strtotime($start_time)));
				if ($start_time == '0000'):
					$start_time = '2400';
			endif;
			} while ($start_time < $end_time);

			$default_slots[$day]['slots'] = $slots;

			$update	= update_post_meta( $post_id,'am_slots_data', $default_slots );		
			$json['type']    = 'success';
			$json['message'] = esc_html__('Your slots has been updated.', 'doctreat_api');   
			return new WP_REST_Response($json, 200);
			
		}

		/**
         * Update Team detial
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_team_details($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id 		= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id'] ) : '';
			$post_id		= !empty( $request['post_id'] ) ? sanitize_text_field($request['post_id']) : '';
			$services		= !empty( $request['service'] ) ? $request['service'] : array();
			$consultant_fee	 = !empty( $request['consultant_fee'] ) ? sanitize_text_field( $request['consultant_fee'] ) : '';

			$json 		= array();
			$emailData	= array();

			if( empty($post_id)) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('No kiddies please!', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			if( empty($consultant_fee)) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Consultation fee is required', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			$post_author	= get_post_field('post_author', $post_id);
			
			if( $post_author != $user_id) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Your are not authorized person to update it', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			if( !empty( $post_id ) ){
				update_post_meta( $post_id ,'_consultant_fee',$consultant_fee);
				update_post_meta( $post_id,'_team_services',$services);
				$json['type']    = 'success';
				$json['message'] = esc_html__('Services has been updated', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			}
			
		}

		/**
         * Get team deatls
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_team_details($request){

			$json	= array();
			$item	= array();
			$items	= array();
			
			$time_format 	= get_option('time_format');
			$width			= 100;
			$height			= 100;

			$team_id		= !empty( $request['team_id'] ) ? intval( $request['team_id'] ) : "";
			
			$db_services 	= get_post_meta($team_id, '_team_services',true);
			$db_services	= !empty( $db_services ) ? $db_services : array();

			$hospital_id			= get_post_meta($team_id,'hospital_id',true);
			$item['hospital_img']   = apply_filters(
										'doctreat_doctor_avatar_fallback', 
										doctreat_get_doctor_avatar( array('width' => $width, 'height' => $height ), $hospital_id ), 
										array( 'width' => $width, 'height' => $height )
									);

			$hospital_name			= get_the_title($hospital_id);
			$item['hospital_name']	= !empty( $hospital_name ) ? $hospital_name : '';

			$am_week_days			= get_post_meta( $team_id,'am_slots_data',true);
			$item['week_days']		= !empty( $am_week_days ) ? array_keys($am_week_days) : array();

			$item['verified'] 		= get_post_meta($hospital_id, '_is_verified',true);

			$post_status				= get_post_status ($team_id);
			$item['hospital_status']	= !empty( $post_status ) ? $post_status	: '';

			$am_consultant_fee	= get_post_meta( $team_id ,'_consultant_fee',true);
			$am_consultant_fee	= !empty( $am_consultant_fee ) ? $am_consultant_fee : '';

			$hospital_name	= '';
			if( function_exists('doctreat_full_name')){
				$hospital_name	= doctreat_full_name($hospital_id);
			}

			$am_slots_data 		= get_post_meta( $team_id,'am_slots_data',true);
			$am_slots_data		= !empty( $am_slots_data ) ? $am_slots_data : array();
			$days				= array();
			
			if( function_exists('doctreat_get_week_array') ){
				$days			= doctreat_get_week_array();
			}

			$new_slots_array	= array();
			if(!empty($days)){
				foreach( $days as $key => $day ) { 
					$day_slots	= !empty( $am_slots_data[$key] ) ? $am_slots_data[$key] : array();
					$slots		= !empty( $day_slots['slots'] ) ? $day_slots['slots'] : '';
					$new_slots_array[$key]	= array();
					if( !empty( $slots ) ){
						foreach( $slots as $slot_key => $slot_val ) { 
							$slots_array	= array();
							$slot_key_val 	= !empty($slot_key) ? explode('-', $slot_key) : array();
							$start_time		= !empty($slot_key_val[0]) ? date($time_format, strtotime('2016-01-01' . $slot_key_val[0])) : '';
							$end_time		= !empty($slot_key_val[1]) ? date($time_format, strtotime('2016-01-01' . $slot_key_val[1])) : '';
							$spaces			= !empty($slot_val['spaces']) ? $slot_val['spaces'] : 0;

							$slots_array['key']			= $slot_key;
							$slots_array['start_time']	= $start_time;
							$slots_array['end_time']	= $end_time;
							$slots_array['spaces']		= $spaces;
							$new_slots_array[$key][]	= $slots_array;
						}
					}
				}
			}

			$services	= array();
			if(!empty($db_services)){
				foreach($db_services as $key => $vals){
					if(!empty($vals)){
						foreach($vals as $k => $v ){
							$services[]['service_id']	= $v;
						}
					}
					
				}
			}

			$item['consultant_fee']	= $am_consultant_fee;
			$item['hospital_name']	= $hospital_name;
			$item['slots']			= $new_slots_array;
			$item['services']		= $services;
			$items[] = maybe_unserialize($item);
			return new WP_REST_Response($items, 200);

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
			
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$post_id 	= !empty( $request['id'] ) ? sanitize_text_field( $request['id'] ) : '';
			$status 	= !empty( $request['status'] ) ? sanitize_text_field( $request['status'] ) : '';

			$json 		= array();
			$emailData	= array();

			if( empty( $post_id ) ) {
				$json['type'] = 'error';
				$json['message'] = esc_html__( 'Doctor ID is missing.', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}

			if( empty( $status ) ) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__( 'Doctor status is required.', 'doctreat_api' );
				return new WP_REST_Response($json, 203);
			}

			$doctor_id 		= get_post_field( 'post_author', $post_id );
			$doctor_profile	= doctreat_get_linked_profile_id( $doctor_id);
			$doctor_name	= doctreat_full_name($doctor_profile);
			$doctor_name	= !empty( $doctor_name ) ? esc_html( $doctor_name ) : '';
			$author_id 		= get_post_meta( $post_id ,'hospital_id', true);
			$hospital_link	= get_the_permalink( $author_id );
			$hospital_link	= !empty( $hospital_link ) ? esc_url( $hospital_link ) : '';
			$hospital_name	= doctreat_full_name($author_id);
			$hospital_name	= !empty( $hospital_name ) ? esc_html( $hospital_name ) : '';
			$author_id		= doctreat_get_linked_profile_id( $author_id,'post');

			if( !empty($post_id) && !empty( $status ) ){
			   $post_data 		= array(
									  'ID'           => $post_id,
									  'post_status'  => $status
								  );

				wp_update_post( $post_data );

				if( !empty( $post_id ) && !empty( $status ) ) {

					$doctor_info				= get_userdata($doctor_id);
					$emailData['email']			= $doctor_info->user_email;
					$emailData['doctor_name']	= $doctor_name;
					$emailData['hospital_link']	= $hospital_link;
					$emailData['hospital_name']	= $hospital_name;

					if (class_exists('Doctreat_Email_helper')) {
						if (class_exists('DoctreatHospitalTeamNotify')) {
							$email_helper = new DoctreatHospitalTeamNotify();
							if( $status === 'publish' ){
								$email_helper->send_approved_email($emailData);
							} else if( $status === 'trash' ){
								$email_helper->send_cancelled_email($emailData);
							}
						}
					}

					$json['type'] 		= 'success';
					$json['message'] 	= esc_html__('You have successfully update this doctor status.', 'doctreat_api');
					return new WP_REST_Response($json, 200);

				}

			} else {
				$json['type'] = 'error';
				$json['message'] = esc_html__('Oops! something is going wrong.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
		}
		
		/**
         * Get Appointment single
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_single($request){
			$json	= array();
			$item	= array();
			$items	= array();
			
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
						
			$booking_slot	= get_post_meta($booking_id,'_booking_slot', true);
			$booking_slot	= !empty( $booking_slot ) ? $booking_slot : '';
			
			$services		= get_post_meta($booking_id,'_booking_service', true);
			$services		= !empty( $services ) ? $services : array();
			
			$post_auter		= get_post_field( 'post_author',$booking_id );
			$link_id		= doctreat_get_linked_profile_id( $post_auter );
			
			$name			= doctreat_full_name( $link_id );
			
			$thumbnail      = doctreat_prepare_thumbnail($link_id, $width, $height);
			$post_status	= get_post_status( $booking_id );
			$user_type		= function_exists('doctreat_get_user_type') ? apply_filters('doctreat_get_user_type', $post_auter ) : '';
			$user_types		= function_exists('doctreat_list_user_types') ?  doctreat_list_user_types() : array();
			$user_type		= $user_types[$user_type];
			
			$location		= function_exists('doctreat_get_location') ? doctreat_get_location($link_id) : '';
			
			$relation		= doctreat_patient_relationship();
			$title				= get_the_title( $hospital_id );
			
						
			$am_specialities 		= doctreat_get_post_meta( $doctor_id,'am_specialities');
			$am_specialities		= !empty( $am_specialities ) ? $am_specialities : array();
			
			$google_calender		= '';
			$yahoo_calender			= '';
			$appointment_date		= get_post_meta($booking_id,'_appointment_date', true);
			$services_array 		= array();
			$item['all_sp_serv']	= array();
			
			if( !empty( $services ) ) {
				foreach( $services as $spe => $sers) {
					$spe_array	= '';
					if( !empty( $spe ) ){
						$spe_array = doctreat_get_term_name( $spe ,'specialities');
					}
					$sers_array	= '';
					if( !empty( $sers ) ){
						foreach( $sers as $k => $val) {
							$sers_array = doctreat_get_term_name( $k ,'services');
						}
					}
					
					$services_array['specialities']	= $spe_array;
					$services_array['services']		= $sers_array;
					$item['all_sp_serv'][]			= $services_array;
				}
			}
			
			$item['content']		= !empty( $content ) ? $content : '';
			$item['image']			= !empty($thumbnail) ? esc_url($thumbnail) : '';
			$item['name']			= !empty( $name ) ? $name : ''; 
			$item['user_type']		= !empty( $user_type ) ? $user_type : '';
			$item['country']		= !empty( $location['_country'] ) ? $location['_country'] : '';
			$item['post_status']	= !empty( $post_status ) ? $post_status : '';
			$item['loc_title']		= !empty( $title ) ? $title : '';
			$item['slots']			= !empty( $appointment_date ) && !empty( $slots ) ? date( $date_format,strtotime( $appointment_date ) ).'-'.esc_html($slots) : '';
			$item['other_name']		= !empty($booking_date['_with_patient']['other_name']) ? $booking_date['_with_patient']['other_name'] : '';
			$item['other_relation']	= !empty($booking_date['_with_patient']['relation']) ? $booking_date['_with_patient']['relation'] : '';
			$items 					= maybe_unserialize($item);
			return new WP_REST_Response($items, 200);
			
			
		}
		
		/**
         * Get clinic detail
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_clinic_details($hospital_id){
			$item				= array();
			$items				= array();
			
			if(!empty($hospital_id)){
				$post   = get_post( $hospital_id );
				$width 	= 80;
				$height	= 80;
				$thumbnail      = doctreat_prepare_thumbnail($hospital_id, $width, $height);

				$item['name']			= !empty( $post->post_title ) ? $post->post_title : ''; 
				$item['ID']				= !empty($hospital_id) ? intval($hospital_id) : 0;;
				$item['hospital_id']	= !empty($hospital_id) ? intval($hospital_id) : 0;;
				$item['status']			= get_post_status( $hospital_id );
				$item['image'] 			= $thumbnail;

				$am_week_days	= get_post_meta( $hospital_id,'am_slots_data',true);
				$days			= !empty( $am_week_days ) ? array_keys($am_week_days) : array();
				$day_array		= array();
				foreach($days as $day){
					$day_array[]['d']	= $day;
				}

				$item['days']	= $day_array;
				return maybe_unserialize($item);
			}
			
			return maybe_unserialize($item);
		}
		
		/**
         * Get Hospila & clinic list for doctors
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_hospital_listing($request){
			global $theme_settings;
			$item				= array();
			$items				= array();
			$category_vals		= array();
			
			$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
			$order         	= !empty($request['order']) ? $request['order'] : 'DESC';
			$sorting       	= !empty($request['orderby']) ? $request['orderby'] : 'ID';
			$user_id       	= !empty($request['user_id']) ? $request['user_id'] : '';
			$fields       	= !empty($request['fields']) ? $request['fields'] : '';
			$location       = !empty($request['location']) ? $request['location'] : '';

			$profile_id     = doctreat_get_linked_profile_id( $user_id );

			$required_fields = array(
				'user_id'   => esc_html__('User ID is required', 'doctreat_api')
			);

			if(!empty($fields)){
				if($fields === 'ids'){
					$show_posts	= -1;
				}
			}

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
            $args = $items = array();
            $hospital_id = '';
            if(!empty($location) && $location === 'clinic'){
                $hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
                $items[]		= $this->get_clinic_details($hospital_id);
            } elseif (!empty($location) && $location === 'hospital'){
                $date_formate		= get_option('date_format');
                $paged 				= $page_number;
                $args = array(
                    'posts_per_page' 	=> $show_posts,
                    'post_type' 		=> 'hospitals_team',
                    'orderby' 			=> $sorting,
                    'order' 			=> $order,
                    'post_status' 		=> array('publish','pending'),
                    'author' 			=> 2,
                    'paged' 			=> $paged,
                    'suppress_filters'  => false
                );
            } else {
                $date_formate		= get_option('date_format');
                $paged 				= $page_number;
                $args = array(
                    'posts_per_page' 	=> $show_posts,
                    'post_type' 		=> 'hospitals_team',
                    'orderby' 			=> $sorting,
                    'order' 			=> $order,
                    'post_status' 		=> array('publish','pending'),
                    'author' 			=> 2,
                    'paged' 			=> $paged,
                    'suppress_filters'  => false
                );
                $hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
                $items[]		= $this->get_clinic_details($hospital_id);
            }
            $query 		= new WP_Query($args);
				$count_post = $query->found_posts;
				$width		= 100;
				$height		= 100;
            if( $query->have_posts() ){
					while ($query->have_posts()) : $query->the_post();
						global $post;
						$hospital_id			= get_post_meta( $post->ID, 'hospital_id', true );
						$name					= doctreat_full_name( $hospital_id );
						$item['name']			= !empty( $name ) ? $name : '';
						$item['ID']				= $post->ID;
						$item['hospital_id']	= $hospital_id;
						$link				= get_the_permalink( $hospital_id );
						$item['status']		= get_post_status( $post->ID );

						$item['image'] = apply_filters(
										'doctreat_doctor_avatar_fallback',
										doctreat_get_doctor_avatar( array('width' => $width, 'height' => $height ), $hospital_id ),
										array( 'width' => $width, 'height' => $height )
									);

						$am_week_days	= get_post_meta( $post->ID,'am_slots_data',true);
						$days			= !empty( $am_week_days ) ? array_keys($am_week_days) : array();
						$day_array		= array();
						foreach($days as $day){
							$day_array[]['d']	= $day;
						}

						$item['days']	= $day_array;
						$items[] 		= maybe_unserialize($item);

					endwhile;
					wp_reset_postdata();
				}
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
			$item	= array();
			$items	= array();
			$meta_query_args	= array();
			
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
			$order         	= !empty($request['order']) ? $request['order'] : 'DESC';
			$sorting       	= !empty($request['orderby']) ? $request['orderby'] : 'ID';
			$status       	= !empty($request['status']) ? $request['status'] : array('publish','pending','draft');
			$user_id       	= !empty($request['user_id']) ? $request['user_id'] : '';
		
			$required_fields = array(
				'user_id'   			=> esc_html__('User ID is required', 'doctreat_api')
			);

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
		
			$linked_profile  	= doctreat_get_linked_profile_id($user_id);
			$date_formate		= get_option('date_format');
			$paged 				= $page_number;
			$args = array(
				'posts_per_page' 	=> $show_posts,
				'post_type' 		=> 'hospitals_team',
				'orderby' 			=> $sorting,
				'order' 			=> $order,
				'post_status' 		=> $status,
				'paged' 			=> $paged,
				'suppress_filters'  => false
			);
			
			$meta_query_args[] = array(
					'key' 		=> 'hospital_id',
					'value' 	=> $linked_profile,
					'compare' 	=> '='
				);
		
			$query_relation 	= array('relation' => 'AND',);
			$args['meta_query'] = array_merge($query_relation, $meta_query_args);

		
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
			
			$width		= 100;
			$height		= 100;
		
			if( $query->have_posts() ){
				while ($query->have_posts()) : $query->the_post(); 
					global $post;
					$doctors_id 			= get_post_field ('post_author', $post->ID);
					$doctor_profile_id		= doctreat_get_linked_profile_id( $doctors_id );

					$name				= doctreat_full_name( $doctor_profile_id );
					$item['name']		= !empty( $name ) ? $name : ''; 
					$item['ID']			= $post->ID;
					$link					= get_the_permalink( $doctor_profile_id );
					$item['status']			= get_post_status( $post->ID );

					$item['image'] = apply_filters(
									'doctreat_doctor_avatar_fallback', 
									doctreat_get_doctor_avatar( array('width' => $width, 'height' => $height ), $doctor_profile_id ), 
									array( 'width' => $width, 'height' => $height )
								);

				
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
	}

}

add_action('rest_api_init',
function () {
	$controller = new DoctreatAppGetTeamRoutes;
	$controller->register_routes();
});
