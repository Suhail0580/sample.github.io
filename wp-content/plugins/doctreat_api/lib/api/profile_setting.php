<?php
/**
 * APP API to set profile settings
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatAppProfileSettingRoutes')) {

    class DoctreatAppProfileSettingRoutes extends WP_REST_Controller{
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'profile';

            register_rest_route($namespace, '/' . $base . '/setting',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_profile'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/get_setting',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_setting'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/update_block_setting',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_block_setting'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			 register_rest_route($namespace, '/' . $base . '/get_user_email',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_user_email'),
                        'args' 		=> array(),
				 		'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/get_remove_reasons',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_remove_reasons'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/update_password',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_password'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/remove_account',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'remove_account'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/update-basic',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_profile_basic'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			
			//Payout settings 
			register_rest_route($namespace, '/' . $base . '/get_payout_setting',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_payout_setting'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/update_payout_setting',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_payout_setting'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/get_payout_listings',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_payout_listings'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Delete Saved items
			register_rest_route($namespace, '/' . $base . '/delete_saved_items',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'delete_saved_items'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

			
			//Update languages
			register_rest_route($namespace, '/' . $base . '/update_user_languages',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_user_languages'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/get_user_languages',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_user_languages'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			
			//Update user service and specialities 
			register_rest_route($namespace, '/' . $base . '/update_user_services_specialities',
                array(
					array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_user_services_specialities'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Get user service and specialities 
			register_rest_route($namespace, '/' . $base . '/get_user_services_specialities',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_user_services_specialities'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			
			//Get dashboard insights data
			register_rest_route($namespace, '/' . $base . '/get_user_dashboard_insights',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_user_dashboard_insights'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//update specialities
			register_rest_route($namespace, '/' . $base . '/update_user_specialities',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_user_specialities'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//delete specialities or services
			register_rest_route($namespace, '/' . $base . '/delete_user_specialities_services',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'delete_user_specialities_services'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update gallery
			register_rest_route($namespace, '/' . $base . '/update_profile_gallery',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_profile_gallery'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update awards and downloads
			register_rest_route($namespace, '/' . $base . '/update_profile_awards_downloads',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_profile_awards_downloads'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update certificate
			register_rest_route($namespace, '/' . $base . '/update_profile_registration_certificate',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_profile_registration_certificate'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update profile location
			register_rest_route($namespace, '/' . $base . '/update_profile_location',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_profile_location'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update profile experience and education
			register_rest_route($namespace, '/' . $base . '/update_profile_education_experience',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_profile_education_experience'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);
			
			//update profile booking numbers
			register_rest_route($namespace, '/' . $base . '/update_booking_contact',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array(&$this, 'update_booking_contact'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
			);

        }
		
		/**
         * Update Profile Gallery
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_gallery($request)
		{
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$am_gallery		  	= !empty($request['am_gallery'] ) ? json_decode( $request['am_gallery'],true) : array();
			$gallery_size 		= !empty($request['size']) ? $request['size'] : 0;
			$am_videos		  	= !empty($request['am_videos'] ) ? json_decode( $request['am_videos'],true) : array();
			
			//update gallery
			if( !empty( $_FILES ) && $gallery_size != 0 ){
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once( ABSPATH . 'wp-includes/pluggable.php' );

				$counter	= 0;
				$attachments			= array();
				for ($x = 0; $x < $gallery_size; $x++) {
					$submitted_files = $_FILES['am_gallery_files'.$x];
					$uploaded_image  = wp_handle_upload($submitted_files, array('test_form' => false));
					$file_name		 = basename($submitted_files['name']);
					$file_type 		 = wp_check_filetype($uploaded_image['file']);

					// Prepare an array of post data for the attachment.
					$attachment_details = array(
						'guid' => $uploaded_image['url'],
						'post_mime_type' => $file_type['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
						'post_content' => '',
						'post_status' => 'inherit'
					);

					require_once(ABSPATH . 'wp-admin/includes/image.php');
					$attach_id 		= wp_insert_attachment($attachment_details, $uploaded_image['file']);
					$attach_data 	= wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);

					$attachments['attachment_id']		= $attach_id;
					$attachments['url']		= wp_get_attachment_url($attach_id);
					$attachments['name']	= $file_name;
					$rand 					= rand(9999, 999);

					if(!empty($attachments)){
						$am_gallery[$rand]		= $attachments;
					}
				}
			}

			$post_id  		= doctreat_get_linked_profile_id($user_id);

			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		= doctreat_get_post_meta( $post_id );
				$post_type		= get_post_type($post_id);
				
				$post_meta['am_gallery']		= $am_gallery;
				$post_meta['am_videos']			= $am_videos;
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
				
				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			}
			
			$json['type']    = 'error';
			$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
			return new WP_REST_Response($json, 203);
		}

		
		/**
         * Update Profile registration
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_registration_certificate($request)
		{
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$am_registration_number	= !empty($request['am_registration_number'] ) ? $request['am_registration_number'] :'';
			$total_attachments 	= !empty($request['size']) ? $request['size'] : 0;
			$am_document		= array();
			$attach_id			= array();
			
			//Resgistration attachment
			if( !empty( $_FILES ) && !empty( $total_attachments ) ){
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once( ABSPATH . 'wp-includes/pluggable.php' );

				$counter	= 0;
				$attachment			= array();
				$submitted_files = $_FILES['am_document_files0'];
				$uploaded_image  = wp_handle_upload($submitted_files, array('test_form' => false));
				$file_name		 = basename($submitted_files['name']);
				$file_type 		 = wp_check_filetype($uploaded_image['file']);

				// Prepare an array of post data for the attachment.
				$attachment_details = array(
					'guid' => $uploaded_image['url'],
					'post_mime_type' => $file_type['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
					'post_content' => '',
					'post_status' => 'inherit'
				);

				$attach_id 		= wp_insert_attachment($attachment_details, $uploaded_image['file']);
				$attach_data 	= wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
				wp_update_attachment_metadata($attach_id, $attach_data);
				$rand 					= rand(9999, 999);

				$am_document['id']				= intval($attach_id);
				$am_document['url']				= wp_get_attachment_url($attach_id);
			}

			$post_id  	= doctreat_get_linked_profile_id($user_id);
			
			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		= doctreat_get_post_meta( $post_id );
				$post_type		= get_post_type($post_id);
				
				if(!empty($am_document)){
					$post_meta['am_is_verified']	= '';
					$post_meta['am_document']		= $am_document;
				}
				
				$post_meta['am_registration_number']	= $am_registration_number;
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
				
				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			}
			
			$json['type']    = 'error';
			$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
			return new WP_REST_Response($json, 203);
		}
		
		/**
         * Update Profile Location
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_location($request)
		{
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();

			//Location update
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$location 			= !empty($request['location']) ? doctreat_get_term_by_type('slug',$request['location'],'locations' ): '';

			$address			= !empty($request['address'] ) ? $request['address'] : '';
			$longitude			= !empty($request['longitude'] ) ? $request['longitude'] : '';
			$latitude			= !empty($request['latitude'] ) ? $request['latitude'] : '';

			$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';
			$post_id  			= doctreat_get_linked_profile_id($user_id);
			
			if(!empty($doctor_location) && ( $doctor_location === 'clinic' || $doctor_location === 'both' )){
				$location_id	= get_post_meta($post_id, '_doctor_location', true);
				$location_id	= !empty( $location_id ) ? intval( $location_id ) : '';
				$location_title	= !empty( $request['location_title'] ) ? $request['location_title'] : '';

				if( empty($location_id) ){
					$doctor_location = array(
										'post_title'   	=> $location_title,
										'post_type'		=> 'dc_locations',
										'post_status'	=> 'publish',
										'post_author'	=> $user_id
									);
					
					$location_id	= wp_insert_post( $doctor_location );
					update_post_meta( $post_id, '_doctor_location', $location_id );
				} else {
					$doctor_location = array(
										'ID'           => $location_id,
										'post_title'   => $location_title
									);

					wp_update_post( $doctor_location );
				}

				
				//Resgistration attachment
				if( !empty( $_FILES ) ){
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once( ABSPATH . 'wp-includes/pluggable.php' );

					$submitted_files = $_FILES['am_clinic_avatar'];
					$uploaded_image  = wp_handle_upload($submitted_files, array('test_form' => false));
					$file_name		 = basename($submitted_files['name']);
					$file_type 		 = wp_check_filetype($uploaded_image['file']);

					// Prepare an array of post data for the attachment.
					$attachment_details = array(
						'guid' => $uploaded_image['url'],
						'post_mime_type' => $file_type['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
						'post_content' => '',
						'post_status' => 'inherit'
					);

					$attach_id 		= wp_insert_attachment($attachment_details, $uploaded_image['file']);
					$attach_data 	= wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);

					if( !empty($attach_id) ){
						$loc_thumnail_id	= get_post_thumbnail_id($location_id);
						set_post_thumbnail($location_id, $attach_id);

						if(!empty($loc_thumnail_id)) {
							wp_delete_attachment($loc_thumnail_id);
						}
					}
				}
				

				wp_set_post_terms( $location_id, $location, 'locations' );
				
				update_post_meta( $location_id, '_address', $address);
				update_post_meta( $location_id, '_longitude', $longitude);
				update_post_meta( $location_id, '_latitude', $latitude);
			}else{
				wp_set_post_terms( $post_id, $location, 'locations' );
				update_post_meta( $post_id, '_address', $address);
				update_post_meta( $post_id, '_longitude', $longitude);
				update_post_meta( $post_id, '_latitude', $latitude);
			}

			$json['type']    = 'success';
			$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
			return new WP_REST_Response($json, 200);
		}
		
		/**
         * Update Profile education and experience
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_education_experience($request)
		{
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$am_education		= !empty($request['am_education'] ) ? $request['am_education'] : array();
			$am_experiences		= !empty($request['am_experiences'] ) ? $request['am_experiences'] : array();
			
			$post_id  		= doctreat_get_linked_profile_id($user_id);

			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		= doctreat_get_post_meta( $post_id );
				$post_type		= get_post_type($post_id);
				
				$post_meta['am_experiences']			= $am_experiences;
				$post_meta['am_education']				= $am_education;
				
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
				
				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			}
			
			$json['type']    = 'error';
			$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
			return new WP_REST_Response($json, 203);

		}
		
		/**
         * Update Profile awards and downloads
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_awards_downloads($request)
		{
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$am_award			= !empty($request['am_award'] ) ? json_decode($request['am_award'],true) : array();
			$am_downloads		= !empty($request['am_downloads'] ) ? json_decode($request['am_downloads'],true) : array();
			$total_attachments 	= !empty($request['size']) ? $request['size'] : 0;
			
			//Brochures files
			if( !empty( $_FILES ) && $total_attachments != 0 ){
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once( ABSPATH . 'wp-includes/pluggable.php' );

				$counter	= 0;
				$attachments			= array();
				for ($x = 0; $x < $total_attachments; $x++) {
					$submitted_files = $_FILES['am_downloads_files'.$x];
					$uploaded_image  = wp_handle_upload($submitted_files, array('test_form' => false));
					$file_name		 = basename($submitted_files['name']);
					$file_type 		 = wp_check_filetype($uploaded_image['file']);

					// Prepare an array of post data for the attachment.
					$attachment_details = array(
						'guid' => $uploaded_image['url'],
						'post_mime_type' => $file_type['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
						'post_content' => '',
						'post_status' => 'inherit'
					);

					$attach_id 		= wp_insert_attachment($attachment_details, $uploaded_image['file']);
					$attach_data 	= wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);


					$attachments['id']		= $attach_id;
					$attachments['media']	= wp_get_attachment_url($attach_id);
					$rand 					= rand(9999, 999);
					$am_downloads[$rand]	= $attachments;
				}
			}
			
			$post_id  		= doctreat_get_linked_profile_id($user_id);

			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		= doctreat_get_post_meta( $post_id );
				$post_type		= get_post_type($post_id);
				
				$post_meta['am_award']					= $am_award;
				$post_meta['am_downloads']				= $am_downloads;
				
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
				
				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			}
			
			$json['type']    = 'error';
			$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
			return new WP_REST_Response($json, 203);

		}
		
		/**
         * Delete user specialities and services 
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function delete_user_specialities_services($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			
			$type			= !empty( $request['type'] ) ? $request['type'] : '';
			$speciality_id	= !empty( $request['speciality_id'] ) ? intval($request['speciality_id']) : '';
			$service_id		= !empty( $request['service_id'] ) ? intval($request['service_id']) : '';
			
			$post_id  		= doctreat_get_linked_profile_id($user_id);
			$post_meta		= doctreat_get_post_meta( $post_id );
			$am_specialities = !empty( $post_meta['am_specialities'] ) ? $post_meta['am_specialities'] : array();
			
			if(!empty($type) && $type === 'speciality' && !empty($speciality_id)){
				unset($am_specialities[$speciality_id]);
			}else if(!empty($type) && $type === 'service'  && !empty($speciality_id)  && !empty($service_id) ){
				unset($am_specialities[$speciality_id][$service_id]);
			}else{
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Some error occur, please try again later','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}
			
			$post_type		= get_post_type($post_id);
			$post_meta['am_specialities']	= $am_specialities;
			update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
			
			$json['type'] 		= 'success';
			$json['message'] 	= esc_html__('You settings has been updated','doctreat_api');        
			return new WP_REST_Response($json, 200);
			
		}
		
		/**
         * Update user serivces
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function update_user_specialities($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent

			$post_meta		= array();
			$json	= array();
			$item	= array();
			$items	= array();
			$post_id		= !empty($request['profile_id']) ? $request['profile_id'] : 0;

			if( function_exists('doctreat_get_post_meta')){
				$post_meta		= doctreat_get_post_meta( $post_id );
			}
			
			$required	= array(
				'profile_id' 	=> esc_html__('Profile ID is required.','doctreat_api'),
				'speciality' 	=> esc_html__('Speciality ID is required.','doctreat_api'),
				'service' 		=> esc_html__('service is required.','doctreat_api'),
				'price' 		=> esc_html__('Price is required.','doctreat_api')
			);

			foreach ($required as $key => $value) {
				if( empty( ($request[$key] ) )){
					$json['type'] 		= 'error';
					$json['message'] 	= $value;        
					return new WP_REST_Response($json, 203);
				}
			}
			
			$post_type		= get_post_type($post_id);
			$post_meta		= !empty( $post_meta ) ? $post_meta : array();

			$speciality		= !empty( $request['speciality'] ) ? $request['speciality'] : '';
			$service		= !empty( $request['service'] ) ? $request['service'] : '';
			$price			= !empty( $request['price'] ) ? $request['price'] : '';
			$description	= !empty( $request['description'] ) ? $request['description'] : '';
			
			$post_meta['am_specialities'][$speciality][$service]['service']	= $service;
			$post_meta['am_specialities'][$speciality][$service]['price']	= $price;
			$post_meta['am_specialities'][$speciality][$service]['description']	= $description;
			
			update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
		
			if( !empty( $service ) ){
				$services_list = wp_get_post_terms( $post_id, 'services', array( 'fields' => 'ids' ) );
				array_push($services_list,$service);
				wp_set_post_terms( $post_id, $services_list, 'services' );
			}
			
			if( !empty( $speciality ) ){
				$specialities_list = wp_get_post_terms( $post_id, 'specialities', array( 'fields' => 'ids' ) );
				array_push($specialities_list,$speciality);
				wp_set_post_terms( $post_id,$specialities_list, 'specialities' );
			}

			$json['type'] 		= 'success';
			$json['message'] 	= esc_html__("Service has been updated", 'doctreat_api');
			return new WP_REST_Response($json, 200);
		}
		
		/**
         * Get user dashboard insights
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_user_dashboard_insights($request) {
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			
			$json	= array();
			$item	= array();
			
			//messages
			$json['messages']['new_messages_img']	= !empty( $theme_settings['new_messages']['url'] ) ? $theme_settings['new_messages']['url'] : '';
			$json['messages']['count']	= apply_filters('doctreat_chat_count', $user_id,'yes' );
			
			//package Expiry
			$product_id			= doctreat_get_subscription_metadata( 'subscription_id',intval($user_id) );
			$expiry_string		= doctreat_get_subscription_metadata( 'subscription_package_string',intval( $user_id ) );
			$title				= esc_html( get_the_title($product_id));
			$user_role			= doctreat_get_user_type( $user_id );
			$pakeges_features	= doctreat_get_pakages_features();
			
			$json['package']['title']		= !empty( $title ) ? esc_html( $title ) : esc_html__('Nill', 'doctreat_api');
			$json['package']['package_expiry_img']	= !empty( $theme_settings['package_expiry']['url'] ) ? $theme_settings['package_expiry']['url'] : '';
			$json['package']['package_expiry']		= $expiry_string;
			
			if(!empty($pakeges_features)){
				foreach($pakeges_features as $key => $vals){
					if( $vals['user_type'] === $user_role || $vals['user_type'] == 'common' ) {
						$text	 = !empty( $vals['text'] ) ? $vals['text'] : '';
						$title	 = !empty( $vals['title'] ) ? $vals['title'] : '';
						$feature	= doctreat_get_subscription_metadata($key,$user_id);

						if( $key	=== 'dc_duration_type') {
							$feature = doctreat_get_duration_types($feature,'value');
						}elseif($key	=== 'dc_badget' ) {
							if(!empty($feature) ){
								$badges		= get_term( intval($feature) );
								if(!empty($badges->name)) {
									$feature	= $badges->name;
								} else {
									$feature	= 'no';
								}
							} else{
								$feature	= 'no';
							}
						}elseif( !empty( $feature ) && $feature === 'yes') {
							$feature	= 'yes';
						} elseif( !empty( $feature ) && $feature === 'no') {
							$feature	= 'no';
						}

						$feature	= !empty( $feature ) ? $feature : '0';

						$json['package']['features'][$key]['feature']	= $title;
						$json['package']['features'][$key]['value']	= !empty($text) ? $text.' '.$feature : $feature;	
					}
				}
			}
			
			//articles
			$json['article']['published_articles_img']	= !empty( $theme_settings['published_articles_img']['url'] ) ? $theme_settings['published_articles_img']['url'] : '';
			$json['article']['published_articles']		= count_user_posts($user_id);
			
			//available balance
			$json['current_balance']['balance_img']	= !empty( $theme_settings['current_balance_img']['url'] ) ? $theme_settings['current_balance_img']['url'] : '';
			$json['current_balance']['balance']		= html_entity_decode( doctreat_price_format( doctreat_get_sum_earning_doctor($user_id,'completed','doctor_amount'),'return') );
			

			return new WP_REST_Response($json, 200);
			
		}
		
		/**
         * Get user services & specialities
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_user_services_specialities($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 		= array();
			$meta_data 	= array();
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$post_id  		= doctreat_get_linked_profile_id($user_id);
			$am_specialities = doctreat_get_post_meta( $post_id,'am_specialities');
			
			$db_data	= array();
			
			if( !empty( $am_specialities ) ){
				foreach( $am_specialities as $keys => $item ) {
					$specialities = get_term_by('id', $keys, 'specialities');
					if(!empty($specialities)){
						$db_data[$keys]['id']		= $specialities->term_id;
						$db_data[$keys]['title']	= $specialities->name;
					}
					
					$db_services	= array();
					if( !empty( $item )) {
						$sp_services	= doctreat_list_service_by_specialities($keys);
						foreach ( $item as $service_key => $service ){ 
							$service_title	= doctreat_get_term_name($service_key ,'services');
							$db_services[$service_key]['id']			= $service_key;
							$db_services[$service_key]['title']			= !empty( $service_title ) ? $service_title : '';
							$db_services[$service_key]['price']			= !empty( $service['price'] ) ? $service['price'] : 0;
							$db_services[$service_key]['price_fromated']= !empty( $service['price'] ) ? html_entity_decode( doctreat_price_format($service['price'],'return') ) : html_entity_decode( doctreat_price_format(0,'return') );
							$db_services[$service_key]['description']	= !empty( $service['description'] ) ? $service['description'] : '';
							
							$db_data[$keys]['services']	= array_values( $db_services );
						}
					}
				}
				
				$json['specialities_services'] 		= array_values($db_data);
				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Specialities found', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			}
			
			$json['type'] 		= array_values($db_data);
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Some error occur, please try again later', 'doctreat_api');
			return new WP_REST_Response($json, 203);
			
		}
		
			
		/**
         * Update user services & specialities
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_user_services_specialities($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 		= array();
			$meta_data 	= array();

			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$post_id  		= doctreat_get_linked_profile_id($user_id);

			$post_meta		= doctreat_get_post_meta( $post_id );
			$post_type		= get_post_type($post_id);
			$post_meta		= !empty( $post_meta ) ? $post_meta : array();
			$specialities	= !empty( $request['am_specialities'] ) ? $request['am_specialities'] : array();

			$service			= array();
			$specialities_array	= array();

			if( !empty( $specialities ) ){
				foreach( $specialities as $keys => $vals ){
					if( !empty( $vals['speciality_id'] ) ){
						$specialities_array[] = $vals['speciality_id'];
						$meta_data[$vals['speciality_id']] = array();
						if( !empty( $vals['services'] ) ) {
							foreach( $vals['services'] as $key => $val ) {
								if( !empty( $val['service'] ) ){
									$service[] = $val['service'];
									$meta_data[$vals['speciality_id']][$val['service']] = $val;
								}
							}
						}
					}
				}
			}

			if( !empty($post_type) && ($post_type ==='doctors') ){

				$service_count	= count($service);
				$service_count	= !empty($service_count) ? intval($service_count) : 0;
				$dc_services	= doctreat_is_feature_value( 'dc_services', $user_id);

				if( ( empty($dc_services) ) || ( $service_count > $dc_services )  ){
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__('Your package limit for submitting services has reached to maximum. Please upgrade or buy package to submit more services.', 'doctreat_api');
					return new WP_REST_Response($json, 203);
				} 
			}

			$post_meta['am_specialities']	= $meta_data;
			update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);

			if( !empty( $service ) ){
				wp_set_post_terms( $post_id, $service, 'services' );
			}

			if( !empty( $specialities_array ) ){
				wp_set_post_terms( $post_id, $specialities_array, 'specialities' );
			}
			
			$json['type'] 		= 'success';
			$json['message'] 	= esc_html__('Specialities and services has been updated', 'doctreat_api');
			return new WP_REST_Response($json, 200);
		}
		
		/**
         * Get languages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_user_languages($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$post_id  		= doctreat_get_linked_profile_id($user_id);
			$languages 		= doctreat_get_taxonomy_array('languages');
			$term_list 		= !empty($post_id) ? wp_get_post_terms( $post_id, 'languages', array( 'fields' => 'all' ) ) : array();
			
			//update languages
			if( !empty( $languages ) ){
				
				$json['languages'] 		= $languages;
				$json['user_languages'] = $term_list;
				$json['type'] 		= 'success';
				return new WP_REST_Response($json, 200);
			}
			
			$json['languages'] 		= array();
			$json['user_languages'] = array();
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Some error occur, please try again later', 'doctreat_api');
			return new WP_REST_Response($json, 203);
		}
		
		/**
         * Update languages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_user_languages($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$post_id  		 = doctreat_get_linked_profile_id($user_id);
			
			//update languages
			if( !empty( $request['languages'] ) ){
				$lang		= array();
				$lang_slugs	= array();
				foreach( $request['languages'] as $key => $item ){
					$lang[] = $item;

				}

				if( !empty( $lang ) ){
					wp_set_post_terms($post_id, $lang, 'languages');
				}
				
				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Languages has been updated', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			}
			
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Some error occur, please try again later', 'doctreat_api');
			return new WP_REST_Response($json, 203);
		}
		
		/**
         * Delete saved items
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function delete_saved_items($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id		= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$post_id		= !empty($user_id) ? doctreat_get_linked_profile_id($user_id) : 0;
			$json			=  array();
			$item_id		= !empty( $request['item_id'] ) ? array(intval( $request['item_id'] )) : array();
			$item_type		= !empty( $request['item_type'] ) ? ( $request['item_type'] ) : '';
			$all			= !empty( $request['all'] ) ? ( $request['all'] ) : 'no';
				
			if( !empty($post_id) ){
				if(!empty($all) && $all === 'yes'){
					update_post_meta( $post_id, $item_type, array() );
				}else{
					$save_items_ids		= get_post_meta( $post_id, $item_type, true);
					$updated_values 	= array_diff(  $save_items_ids , $item_id);
					update_post_meta( $post_id, $item_type, $updated_values );
				}

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Removed save item successfully.', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			}
			
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Some error occur, please try again later', 'doctreat_api');
			return new WP_REST_Response($json, 203);
													
			
		}
		
		/**
         * Get payout settings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_payout_setting($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$payrols		= array();
			if( function_exists('doctreat_get_payouts_lists') ){
				$payrols		= doctreat_get_payouts_lists();
			}
			
			$contents	= get_user_meta($user_id,'payrols',true);
			
			$json	= array();
			$json['payout_settings']	= $payrols;
			$json['saved_settings']		= $contents;
				

			$json['type'] = 'success';
			$json['message'] = esc_html__('Payout settings', 'doctreat_api');
			return new WP_REST_Response($json, 200);
													
			
		}
		
		/**
         * Update payout settings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_payout_setting($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent

			$json	= array();
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$data 			= array();
			$payrols		= doctreat_get_payouts_lists();
			$fields			= !empty( $payrols[$request['payout_data']['type']]['fields'] ) ? $payrols[$request['payout_data']['type']]['fields'] : array();

			if( !empty($fields) ) {
				foreach( $fields as $key => $field ){
					if( $field['required'] === true && empty( $request['payout_data'][$key] ) ){
						$json['type'] 		= 'error';
						$json['message'] 	= $field['message'];
						return new WP_REST_Response($json, 203);
					}
				}
			}

			update_user_meta($user_id,'payrols',$request['payout_data']);
			$json['type'] 	 = 'success';
			$json['message'] = esc_html__('Payout settings updated', 'doctreat_api');
			return new WP_REST_Response($json, 200);
		}
		
		/**
         * Update payout settings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_payout_listings($request) {
			global $wpdb;
			$json	= array();
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';

			$payments			= doctreat_get_payments_doctreat($user_id);
			$table_name 		= $wpdb->prefix . "dc_payouts_history";
			$earning_sql		= "SELECT * FROM $table_name where ( user_id =".$user_id." AND status= 'completed')";
			$total_query 		= "SELECT COUNT(1) FROM (${earning_sql}) AS combined_table";
			$total 				= $wpdb->get_var( $total_query );
			$total				= !empty($total) ? intval($total) : 0; 
			$items_per_page 	= get_option('posts_per_page');
			$page 				= isset( $request['page'] ) ? abs( (int) $request['page'] ) : 1;
			$offset 			= ( $page * $items_per_page ) - $items_per_page;
			$payments 			= $wpdb->get_results( $earning_sql . " ORDER BY id DESC LIMIT ${offset}, ${items_per_page}" );
			$total_pages		= ceil($total / $items_per_page);
			$date_formate		= get_option('date_format');
			$payrols_list		= doctreat_get_payouts_lists();
			$payments			= !empty($payments) ? maybe_unserialize($payments) : array();
			
			
			$payment_list	= array();
			
			if(!empty($payments)){
				foreach($payments  as $key => $item ){
					$list_item	= !empty($item) ? maybe_unserialize($item) :array();
					if(!empty($list_item)){
						foreach($list_item as $ukey => $data){
							$payment_list[$key][$ukey]	= !empty($data) ? maybe_unserialize($data) :array();
						} 
					}
				}
			}
			
			$json['payment_list'] 	 = !empty($payment_list) ? maybe_unserialize($payment_list) : array();
			$json['payout_list'] 	 = $payrols_list;
			$json['total'] 	 		 = $total;
			$json['type'] 	 = 'success';
			$json['message'] = esc_html__('Payout settings updated', 'doctreat_api');
			return new WP_REST_Response($json, 200);
		}
		
		
		/**
         * Remove Account
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_account($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$password			= !empty( $request['password'] ) ? sanitize_text_field($request['password']) : '';
			$retype				= !empty( $request['retype'] ) ? sanitize_text_field($request['retype']) : '';
			$reason				= !empty( $request['reason'] ) ? sanitize_text_field($request['reason']) : '';
			$description		= !empty( $request['description'] ) ? sanitize_textarea_field($request['description']) : '';
			$required = array(
				'password'   	=> esc_html__('Password is required', 'doctreat_api'),
				'retype'  		=> esc_html__('Retype your password', 'doctreat_api'),
				'reason' 		=> esc_html__('Select reason to delete your account', 'doctreat_api'),
			);

			foreach ($required as $key => $value) {
			   if( empty( sanitize_text_field($request[$key] ) )){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
			
			$user			= get_userdata($user_id);
			$user_name 	 	= doctreat_get_username($user_id);
			$user_email	 	= $user->user_email;
			$is_password 	= wp_check_password($password, $user->user_pass, $user_id);
			$post_id		= doctreat_get_linked_profile_id($user_id);

			if( $is_password ){
				require_once(ABSPATH.'wp-admin/includes/user.php');
				wp_delete_user($user_id);
				wp_delete_post($post_id,true);

				$reason		 = doctreat_get_account_delete_reasons($reason);

				//Send email to users
				if (class_exists('Doctreat_Email_helper')) {
					if (class_exists('DoctreatDeleteAccount')) {
						$email_helper 	= new DoctreatDeleteAccount();
						$emailData 		= array();

						$emailData['username'] 			= esc_html( $user_name );
						$emailData['reason'] 			= esc_html( $reason );
						$emailData['email'] 			= esc_html( $user_email );
						$emailData['description'] 		= sanitize_textarea_field( $description );
						$email_helper->send($emailData);
					}
				}

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('You account has been deleted.', 'doctreat_api');

				return new WP_REST_Response($json, 200);
			} else{
				$json['type'] = 'error';
				$json['message'] = esc_html__('Password doesn\'t match', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
		}
		
		/**
         * List remove account reasons
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_remove_reasons($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$reasons		 = function_exists('doctreat_get_account_delete_reasons') ? doctreat_get_account_delete_reasons() : array();
			
			$reason_array	= array();
			foreach($reasons as $key => $val ){
				$reasons_data			= array();
				$reasons_data['key']	= $key;
				$reasons_data['val']	= $val;
				$reason_array[]			= $reasons_data;
			}
			return new WP_REST_Response($reason_array, 200);
		}
		
		/**
         * Update password
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_password($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$old_password		= !empty( $request['password'] ) ? sanitize_text_field($request['password']) : '';
			$password			= !empty( $request['retype'] ) ? sanitize_text_field($request['retype']) : '';
			$json				= array();
			
			if( empty( $old_password ) || empty( $password ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Current and new password fields are required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			$user_info 	= get_userdata($user_id);
			$user_pass	= !empty($user_info->user_pass) ? $user_info->user_pass : '';
			
        	$is_password 	= wp_check_password($old_password, $user_pass, $user_id);

			if ($is_password) {

				if (empty($old_password) ) {
					$json['type'] 		= 'error';
					$json['message'] 	= esc_html__('Please add your new password.', 'doctreat_api');
					return new WP_REST_Response($json, 203);
				 } else {
					wp_update_user(array('ID' => $user_id, 'user_pass' => $password));
					$json['type'] 		= 'success';
					$json['message'] 	= esc_html__('Password Updated.', 'doctreat_api');
					return new WP_REST_Response($json, 200);
				}

			} else {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Old Password doesn\'t matched with the existing password', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
		}
		
		/**
         * Get Account setting
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_setting($request) {
			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';

			$linked_profile  	= doctreat_get_linked_profile_id($user_id);
			$post_type			= get_post_type($linked_profile);
			$settings			= function_exists('doctreat_get_account_settings') ? doctreat_get_account_settings($post_type) : array();
			$json['block_text']	= !empty($settings['_profile_blocked']) ? $settings['_profile_blocked'] : '';
			$block_val			= get_post_meta($linked_profile, '_profile_blocked', true);
			$json['block_val']	= !empty($block_val) ? $block_val : '';
			return new WP_REST_Response($json, 200);
			
		}
		
		/**
         * Get user Email
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_user_email($request) {
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$json 				= array();
			
			if(empty($user_id)) {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('User ID is required field..', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			} else {
				$user_info 			= get_userdata($user_id);
				$json['email']		= !empty($user_info->user_email) ? $user_info->user_email : '';
				return new WP_REST_Response($json, 200);
			}
		}
		
		
		/**
         * Update block Account setting
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_block_setting($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			
			$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
			$block_setting		= !empty( $request['block_setting'] ) ?  $request['block_setting']  : '';
			$linked_profile  	= doctreat_get_linked_profile_id($user_id);
			$json				= array();
			
			if(!empty($user_id)) {
				update_post_meta($linked_profile,'_profile_blocked',$block_setting);
				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Account is updated successfully.', 'doctreat_api');
				return new WP_REST_Response($json, 200);
			} else {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('User Id is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			
		}
		
        /**
         * Get Profile Data
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_profile($request) {
			global $theme_settings;
			$user_id		= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$json	= array();
			
			if(!empty($user_id)) {
				$post_id  		= doctreat_get_linked_profile_id($user_id);
				$post_meta		= doctreat_get_post_meta( $post_id);
                $days		    = doctreat_get_week_array();
                $term_lists     = !empty($post_id) ? wp_get_post_terms( $post_id, 'languages', array( 'fields' => 'ids' ) ) : array();
				
				$array_data		= array();
				$array_data['am_name_base']				= !empty($post_meta['am_name_base']) ? $post_meta['am_name_base'] : '';
				$array_data['am_sub_heading']			= !empty($post_meta['am_sub_heading']) ? $post_meta['am_sub_heading'] : '';
				$array_data['am_first_name']			= !empty($post_meta['am_first_name']) ? $post_meta['am_first_name'] : '';
				$array_data['am_last_name']				= !empty($post_meta['am_last_name']) ? $post_meta['am_last_name'] : '';
				$array_data['am_web_url']				= !empty($post_meta['am_web_url']) ? $post_meta['am_web_url'] : '';
                $gallery_images                         = doctreat_get_post_meta( $post_id,'am_gallery');

                /* attached gallery data */
                $gallery_data = array();
                if( !empty( $gallery_images ) ){
                    foreach($gallery_images as $gallery_image ) {
                        $banner_file_size 		= !empty( $gallery_image['attachment_id']) ? filesize(get_attached_file($gallery_image['attachment_id'])) : '';
                        $banner_document_name	= !empty( $gallery_image['attachment_id'] ) ? esc_html( get_the_title( $gallery_image['attachment_id'] ) ) : '';
                        $banner_filetype        = !empty( $gallery_image['attachment_id'] ) ? wp_check_filetype( $gallery_image['url'] ) : '';
                        $banner_extension  		= !empty( $banner_filetype['ext'] ) ? $banner_filetype['ext'] : '';
                        $gallery_image_url 		= !empty( $gallery_image['attachment_id'] ) ? wp_get_attachment_image_src( $gallery_image['attachment_id'], array(150,150), true ) : '';
                        $gallery_data[] = array(
                            'file_size'         => $banner_file_size,
                            'file_name'         => $banner_document_name,
                            'file_extension'    => $banner_extension,
                            'file_url'          => esc_url( $gallery_image_url[0] ),
                        );
                    }
                }
                $array_data['am_gallery'] = $gallery_data;

                $array_lang = array();
                if(!empty($term_lists) && is_array($term_lists)){
                    foreach ($term_lists as $lang){
                        $term_detail = get_term_by('id', $lang, 'languages');
                        $array_lang[] = array(
                            'id'    => $term_detail->term_id,
                            'name'  => $term_detail->name,
                            'slug'  => $term_detail->slug,
                        );
                    }
                }
                $array_data['am_languages']    = $array_lang;
				$display_name				= get_the_title( $post_id );
				$array_data['display_name']	= !empty( $display_name ) ? $display_name : '';
				
				$address					= get_post_meta( $post_id , '_address',true );
				$array_data['address']		= !empty( $address ) ? $address : '';
				$latitude					= get_post_meta( $post_id , '_latitude',true );
				$array_data['latitude']		= !empty( $latitude ) ? $latitude : '';
				$longitude					= get_post_meta( $post_id , '_longitude',true );
				$array_data['longitude']	= !empty( $longitude ) ? $longitude : '';
				
				
				$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';

				if(!empty($doctor_location) && ( $doctor_location === 'clinic' || $doctor_location === 'both' )){
					$hospital_id	= get_post_meta($post_id, '_doctor_location', true);
					if(!empty($hospital_id)){
						$attachment_id 			= get_post_thumbnail_id($hospital_id);
						$image_url 				= !empty( $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, 'doctreat_doctors_type', true ) : '';
						$array_data['am_hospital_logo']	= !empty($image_url[0])? $image_url[0] : '';
						$array_data['am_hospital_name']	= !empty($hospital_id) ? get_the_title($hospital_id) : '';
					}else{
						$array_data['am_hospital_logo']	= '';
						$array_data['am_hospital_name']	= '';
					}
				} else{
					$array_data['am_hospital_logo']	= '';
					$array_data['am_hospital_name']	= '';
				}

				$array_data['am_week_days']			= !empty($post_meta['am_week_days']) ? $post_meta['am_week_days'] : array();
				$array_data['am_availability']		= !empty($post_meta['am_availability']) ? $post_meta['am_availability'] : '';
				$array_data['am_other_time']		= !empty($post_meta['am_other_time']) ? $post_meta['am_other_time'] : '';

				$location 		= wp_get_post_terms( $post_id, 'locations');

				//Get country
				if( !empty( $location[0]->name ) ){
					$location = !empty( $location[0]->name ) ? $location[0]->name : '';
				}

				$array_data['location']		= !empty( $location ) ? $location : '';
								
				$post_object 			= get_post( $post_id );
				$content 	 			= $post_object->post_content;
				$array_data['content']	= !empty( $content ) ? $content : '';
				
				$attachment_id 							= get_post_thumbnail_id($post_id);
				$array_data['profile_attachment_id']	= !empty($attachment_id) ? $attachment_id : '';
				$image_url								= !empty( $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, 'doctreat_doctors_type', true ) : '';	
				$array_data['profile_image_url']		= !empty($image_url[0]) ? esc_url($image_url[0]) : '';
				$array_data['am_short_description']		= !empty($post_meta['am_short_description']) ? $post_meta['am_short_description'] : '';
				$array_data['am_starting_price']		= !empty($post_meta['am_starting_price']) ? $post_meta['am_starting_price'] : '';
				$array_data['am_mobile_number']		    = !empty($post_meta['am_mobile_number']) ? $post_meta['am_mobile_number'] : '';
				
				$membership_array	= array();
				if(!empty($post_meta['am_memberships_name'])) {
					foreach($post_meta['am_memberships_name'] as $key => $val ) {
						$membership_array[]['name']	= $val;
					}
				}
				
				$array_data['am_memberships']	= $membership_array;
				
				$education_array	= array();
				if(!empty($post_meta['am_education'])) {
					foreach($post_meta['am_education'] as $key => $val ) {
						$education_array[$key]['institute_name']	= !empty($val['institute_name']) ? $val['institute_name'] : '';
						$education_array[$key]['start_date']		= !empty($val['start_date']) ? $val['start_date'] : '';
						$education_array[$key]['ending_date']		= !empty($val['ending_date']) ? $val['ending_date'] : '';
						$education_array[$key]['degree_title']		= !empty($val['degree_title']) ? $val['degree_title'] : '';
						$education_array[$key]['degree_description']= !empty($val['degree_description']) ? $val['degree_description'] : '';
						
					}
				}
				
				$array_data['am_education']	= array_values($education_array);
				
				$experiences_array	= array();
				if(!empty($post_meta['am_experiences'])) {
					foreach($post_meta['am_experiences'] as $key => $val ) {
						$experiences_array[$key]['company_name']		= !empty($val['company_name']) ? $val['company_name'] : '';
						$experiences_array[$key]['start_date']			= !empty($val['start_date']) ? $val['start_date'] : '';
						$experiences_array[$key]['ending_date']			= !empty($val['ending_date']) ? $val['ending_date'] : '';
						$experiences_array[$key]['job_title']			= !empty($val['job_title']) ? $val['job_title'] : '';
						$experiences_array[$key]['job_description']		= !empty($val['job_description']) ? $val['job_description'] : '';
						
					}
				}
				
				$array_data['am_experiences']	= array_values($experiences_array);
				
				$award_array	= array();
				if(!empty($post_meta['am_award'])) {
					foreach($post_meta['am_award'] as $key => $val ) {
						$award_array[$key]['title']		= !empty($val['title']) ? $val['title'] : '';
						$award_array[$key]['year']		= !empty($val['year']) ? $val['year'] : '';
					}
				}
				
				$array_data['am_award']	= array_values($award_array);
				$array_data['document_url']		= !empty( $post_meta['am_document']['url'] ) ? $post_meta['am_document']['url'] : '';
				$array_data['document_id']		= !empty( $post_meta['am_document']['id'] ) ? intval( $post_meta['am_document']['id'] ) : '';
				$array_data['document_size']	= !empty( $array_data['document_id']) ? size_format(filesize(get_attached_file($array_data['document_id'])),2) : '';
				$array_data['document_name']	= !empty( $array_data['document_id'] ) ? get_the_title( $array_data['document_id'] ) : '';
				$array_data['document_verified']	= !empty( $post_meta['am_is_verified'] ) ? $post_meta['am_is_verified'] : '';
				$array_data['reg_number']			= !empty( $post_meta['am_registration_number'] ) ? $post_meta['am_registration_number'] : '';
				$array_data['am_videos']		  	= !empty( $post_meta['am_videos'] ) ? $post_meta['am_videos'] : array();
				
				$array_data['am_downloads_image'] 	= get_template_directory_uri().'/images/file-icon.png';
				$downloads_array	= array();
				
				if(!empty($post_meta['am_downloads'])) {
					foreach($post_meta['am_downloads'] as $key => $val ) {
						$downloads_array[$key]['id']		= !empty($val['id']) ? $val['id'] : '';
						$downloads_array[$key]['media']		= !empty($val['media']) ? $val['media'] : '';
						
						$downloads_array[$key]['size'] 		= !empty( $val['id']) ? size_format(filesize(get_attached_file($val['id'])),2) : '';	
						$downloads_array[$key]['name']   	= !empty( $val['id'] ) ? get_the_title( $val['id'] ) : '';
						
					}
				}
				
				$array_data['am_downloads']				= array_values($downloads_array);
				$contact_numbers						= !empty($post_meta['am_booking_contact']) ? $post_meta['am_booking_contact'] : array();
				$array_data['am_booking_detail']		= !empty($post_meta['am_booking_detail']) ? $post_meta['am_booking_detail'] : '';
				$am_phone_numbers						= !empty($post_meta['am_phone_numbers']) ? array_values($post_meta['am_phone_numbers']) : array();
				$array_data['am_phone_numbers']	        = $am_phone_numbers;
				
				$contact_array	= array();
				if(!empty($contact_numbers)){
					foreach( $contact_numbers as $contact_number ){
						if(!empty($contact_number)){
							$contact_array[]['number']	= $contact_number;
						}
					}
				}
					
				$array_data['am_booking_contact']	= $contact_array;
				
				$item[]	= maybe_unserialize($array_data);
				return new WP_REST_Response($item, 200);
				
			} else {
				$item	= array();
				return new WP_REST_Response($item, 203);
			}
		}
		
		/**
         * Update Booking numbers Data
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_booking_contact($request)
        {
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent

			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';

			$required_fields = array(
				'id'				=> esc_html__('User ID is required','doctreat_api')
			);

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
			
			$booking_option	= !empty($theme_settings['booking_system_contact']) ? $theme_settings['booking_system_contact'] : '';

			$booking_settings = array();
			if(!empty($booking_option) && $booking_option === 'doctor'){
				$booking_contact_numbers	= !empty($request['am_booking_contact'] ) ? $request['am_booking_contact'] : array();
				$booking_detail				= !empty($request['am_booking_detail'] ) ? $request['am_booking_detail'] : array();
			} else {
				$booking_contact_numbers	= !empty( $theme_settings['am_booking_contact'] ) ? $theme_settings['am_booking_contact'] : array();
				$booking_detail				= !empty( $theme_settings['am_booking_detail']) ? $theme_settings['am_booking_detail'] : '';
			}
			
			$post_id  		= doctreat_get_linked_profile_id($user_id);

			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		= doctreat_get_post_meta( $post_id);
				$post_type		= get_post_type($post_id);
				
				$post_meta['am_booking_detail']		= !empty($booking_detail) ? $booking_detail : '';		
				$post_meta['am_booking_contact']	= $booking_contact_numbers;
				
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);
				
				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
				
			} else {
				$json['type']    = 'error';
				$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
				return new WP_REST_Response($json, 203);
			}

		}
		
		/**
         * Update Profile Data
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		
        public function update_profile_basic($request)
        {
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent

			$json	= array();
			$item	= array();
			$items	= array();
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';

			$required_fields = array(
				'am_first_name'   	=> esc_html__('First  name is required', 'doctreat_api'),
				'am_last_name'  	=> esc_html__('Last name is required', 'doctreat_api'),
				'id'				=> esc_html__('User ID is required','doctreat_api')
			);

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;
				return new WP_REST_Response($json, 203);
			   }
			}
			
			$post_id  		= doctreat_get_linked_profile_id($user_id);

			if( !empty($user_id) && !empty($post_id) ){
				$post_meta		        = doctreat_get_post_meta( $post_id);
				$post_type		        = get_post_type($post_id);
				$display_name 	        = !empty($request['display_name']) ? sanitize_text_field($request['display_name']) : '';
				$am_first_name 	        = !empty($request['am_first_name']) ? sanitize_text_field($request['am_first_name']) : '';
				$am_last_name  	        = !empty($request['am_last_name'] ) ? sanitize_text_field($request['am_last_name']) : '';
				$am_name_base  	        = !empty($request['am_name_base'] ) ? sanitize_text_field($request['am_name_base']) : '';
				$am_sub_heading  		= !empty($request['am_sub_heading'] ) ? sanitize_text_field($request['am_sub_heading']) : '';
				$am_starting_price  	= !empty($request['am_starting_price'] ) ? sanitize_text_field($request['am_starting_price']) : '';
				$am_short_description  	= !empty($request['am_short_description'] ) ? sanitize_textarea_field($request['am_short_description']) : '';
				$am_memberships_name  	= !empty($request['am_memberships_name'] ) ? json_decode($request['am_memberships_name'],true) : array();
				$am_phone_numbers  		= !empty($request['am_phone_numbers'] ) ? json_decode($request['am_phone_numbers'], true) : array();
				$am_mobile_number 		= !empty($request['am_mobile_number']) ? $request['am_mobile_number'] : '';
				$content				= !empty( $request['content'] ) ? $request['content'] : '';
                $languages				= !empty( $request['am_languages'] ) ? json_decode($request['am_languages'], true) : array();

				$user_type	= apply_filters('doctreat_get_user_type', $user_id );
				
				if($user_type === 'hospitals') {
					$am_week_days			= !empty($request['am_week_days']) ? json_decode($request['am_week_days'], true) : array();
					$am_availability		= !empty($request['am_availability']) ? $request['am_availability'] : '';
					$am_other_time			= !empty($request['am_other_time']) ? $request['am_other_time'] : '';
					$am_web_url			    = !empty($request['am_web_url']) ? $request['am_web_url'] : '';

					$post_meta['am_other_time']			= $am_other_time;
					$post_meta['am_availability']		= $am_availability;
					$post_meta['am_week_days']			= $am_week_days;
					$post_meta['am_web_url']			= $am_web_url;
				}

				/* languages */
                if(!empty($languages) && is_array($languages)){
                    wp_set_post_terms($post_id, $languages, 'languages');
                }

				//Update user meta
				update_user_meta($user_id, 'first_name', $am_first_name);
				update_user_meta($user_id, 'last_name', $am_last_name);
				update_user_meta($user_id, 'mobile_number', $am_mobile_number);

				$post_meta['am_mobile_number']		= $am_mobile_number; 
				$post_meta['am_phone_numbers']		= $am_phone_numbers;
				$post_meta['am_first_name']			= $am_first_name;
				$post_meta['am_last_name']			= $am_last_name;
				$post_meta['am_name_base']			= $am_name_base;
				$post_meta['am_starting_price']		= $am_starting_price;
				$post_meta['am_sub_heading']		= $am_sub_heading;
				$post_meta['am_short_description']	= $am_short_description;
				$post_meta['am_memberships_name']	= $am_memberships_name;
				
				update_post_meta($post_id, 'am_' . $post_type . '_data', $post_meta);

				//Update Doctor Post        
				$doctor_user = array(
					'ID'           => $post_id,
					'post_title'   => $display_name,
					'post_content' => $content,
				);
				
				wp_update_post( $doctor_user );

				//Profile avatar
				$profile_avatar = array();
	
				//Resgistration attachment
				if( !empty( $_FILES ) ){
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once( ABSPATH . 'wp-includes/pluggable.php' );

					$submitted_files = $_FILES['am_avatar'];
					$uploaded_image  = wp_handle_upload($submitted_files, array('test_form' => false));
					$file_name		 = basename($submitted_files['name']);
					$file_type 		 = wp_check_filetype($uploaded_image['file']);

					// Prepare an array of post data for the attachment.
					$attachment_details = array(
						'guid' => $uploaded_image['url'],
						'post_mime_type' => $file_type['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
						'post_content' => '',
						'post_status' => 'inherit'
					);

					$attach_id 		= wp_insert_attachment($attachment_details, $uploaded_image['file']);
					$attach_data 	= wp_generate_attachment_metadata($attach_id, $uploaded_image['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);

					if( !empty($attach_id) ){
						$thumnail_id	= get_post_thumbnail_id($post_id);
						if(!empty($thumnail_id)) {
							wp_delete_attachment($thumnail_id);
						}
						set_post_thumbnail($post_id, $attach_id);
					}
				}

				$json['type']    = 'success';
				$json['message'] = esc_html__('Settings Updated.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			} else {
				$json['type']    = 'error';
				$json['message'] = esc_html__('Post ID is required', 'doctreat_api'); 
				return new WP_REST_Response($json, 203);
			}
		}
		
		/**
         * upload media from base64
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function upload_media($basestring){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$item	= array();
			$items	= array();
			
			$upload_dir       = wp_upload_dir();
			$upload_path      = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

			$img 			  = $basestring['base64_string'];
			$decoded          = base64_decode( $img ) ;
			$filename         = $basestring['name'];
			$hashed_filename  = rand(1,9999) . '_' . $filename;

			$image_upload     = file_put_contents( $upload_path . $hashed_filename, $decoded );

			if( !function_exists( 'wp_handle_sideload' ) ) {
			  require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}

			if( !function_exists( 'wp_get_current_user' ) ) {
			  require_once( ABSPATH . 'wp-includes/pluggable.php' );
			}

			$file             = array();
			$file['error']    = '';
			$file['tmp_name'] = $upload_path . $hashed_filename;
			$file['name']     = $hashed_filename;
			$file['type']     = $basestring['type'];
			$file['size']     = filesize( $upload_path . $hashed_filename );

			$file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );

			$filename = $file_return['file'];
			$attachment = array(
				 'post_mime_type' => $file_return['type'],
				 'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				 'post_content' => '',
				 'post_status' => 'inherit',
				 'guid' => $wp_upload_dir['url'] . '/' . basename($filename)
			);
			
			$attach_id = wp_insert_attachment( $attachment, $filename, 0 );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
			return $attach_id;
		}
		
    }
}

add_action('rest_api_init',
function () {
    $controller = new DoctreatAppProfileSettingRoutes;
    $controller->register_routes();
});
