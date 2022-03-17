<?php
/**
 * APP API to manage taxonomies
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat App
 *
 */
if (!class_exists('DoctreatApp_Taxonomies_Route')) {

    class DoctreatApp_Taxonomies_Route extends WP_REST_Controller{

        /**
         * Register the routes for the user.
         */
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'taxonomies';
			
			//get taxnomy
			register_rest_route($namespace, '/' . $base . '/get_taxonomy',
                array(
                    array(
                        'methods' => WP_REST_Server::READABLE,
                        'callback' => array(&$this, 'get_taxonomy'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get posts
			register_rest_route($namespace, '/' . $base . '/get_posts_by_post_type',
                array(
                    array(
                        'methods' => WP_REST_Server::READABLE,
                        'callback' => array(&$this, 'get_posts_by_post_type'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get list
			register_rest_route($namespace, '/' . $base . '/get_list',
                array(
                    array(
                        'methods' => WP_REST_Server::READABLE,
                        'callback' => array(&$this, 'get_list'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get sepecilities taxnomy
			register_rest_route($namespace, '/' . $base . '/get-specilities',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_specilities'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get Services taxnomy
			register_rest_route($namespace, '/' . $base . '/get_servicess',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_servicess'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
        }
		
		/**
         * Get taxonomy
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_taxonomy($request) {
			$taxonomy			= !empty( $request['taxonomy'] ) ?  $request['taxonomy'] : '';
			
			if( !empty($taxonomy) ) {
				$terms		= doctreat_get_taxonomy_array($taxonomy);
				$terms_data	= array();
				
				if( !empty($terms) ) {
					foreach ($terms as $key => $term) {
						$terms_data[$term->term_id]['id'] = $term->term_id;
						$terms_data[$term->term_id]['name'] = $term->name;
						$terms_data[$term->term_id]['slug'] = $term->slug;
					}
				}
				
				$item		= array_values($terms_data);
				return new WP_REST_Response($item, 200);
			} else {
				$json['type'] 		= "error";
				$json['message'] 	= esc_html__("No taxonomies are found.", 'doctreat_api');
				return new WP_REST_Response($json, 203);	
			}
		}

		/**
         * Get post type
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_posts_by_post_type($request) {
			global $theme_settings;

			$json	= array();
			$item	= array();
			$items	= array();
			$posts_data	= array();
			
			$post_type			= !empty( $request['post_type'] ) ?  $request['post_type'] : '';
			$profile_id			= !empty( $request['profile_id'] ) ?  $request['profile_id'] : '';

			if(!empty($post_type) && $post_type === 'hospitals' && !empty($profile_id)){
				$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';
				
				if(!empty($doctor_location) && $doctor_location === 'clinic'){
					$hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
					if(!empty($hospital_id)){
						$post   = get_post( $hospital_id );
						$posts_data[$hospital_id]['id'] 	= !empty($hospital_id) ? intval($hospital_id) : 0;;
						$posts_data[$hospital_id]['name'] 	= $post->post_title;
						$posts_data[$hospital_id]['slug'] 	= $post->post_name;
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
								$posts_data[$hospital_id]['id'] 	= intval( $hospital_id );
								$posts_data[$hospital_id]['name'] 	= get_the_title($hospital_id);
								$posts_data[$hospital_id]['slug'] 	= $dir->post_name;
							}
						}
					}
				}
				
				if(!empty($doctor_location) && $doctor_location === 'both'){
					$hospital_id	= get_post_meta( $profile_id, '_doctor_location', true );
					
					$post   = get_post( $hospital_id );
					$posts_data[$hospital_id]['id'] 	= !empty($hospital_id) ? intval($hospital_id) : 0;;
					$posts_data[$hospital_id]['name'] 	= $post->post_title;
					$posts_data[$hospital_id]['slug'] 	= $post->post_name;
				}
				
				if(empty($posts_data)){
					$posts_data[0]['id'] 	= 0;
					$posts_data[0]['name'] 	= esc_html__('No location has added yet','doctreat_api');
					$posts_data[0]['slug'] 	= '';
				}

				$item		= array_values($posts_data);

				return new WP_REST_Response($item, 200);
				
			} else{
				if( !empty($post_type) ) {
					$posts	= get_posts(
										array('numberposts'	=> -1,
										'post_type'			=> $post_type)
									);
					

					if( !empty($posts) ) {
						foreach ($posts as $post) {
							$posts_data[$post->ID]['id'] 	= intval( $post->ID );
							$posts_data[$post->ID]['name'] 	= $post->post_title;
							$posts_data[$post->ID]['slug'] 	= $post->post_name;
						}
					}

					$item		= array_values($posts_data);

					return new WP_REST_Response($item, 200);
				} else {
					$json['type'] 		= "error";
					$json['message'] 	= esc_html__("there are no taxonomies are found.", 'doctreat_api');
					return new WP_REST_Response($json, 203);	
				}
			}
			
			
		}
		
		/**
         * Get list
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_list($request) {
			$json	= array();
			$item	= array();
			$items	= array();
			
			$list			= !empty( $request['list'] ) ?  $request['list'] : '';
			if( !empty($list) ) {
				if($list === 'bas_name') {
					$array_data			= array();
					$name_bases			= array();
					
					if( function_exists( 'doctreat_get_name_bases' ) ) {
						$name_bases	= doctreat_get_name_bases();
					}
					
					if( !empty($name_bases) ) {
						$count = 0;
						foreach($name_bases as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'week_days') {
					$array_data			= array();
					$name_bases			= array();
					
					if( function_exists( 'doctreat_get_week_array' ) ) {
						$name_bases	= doctreat_get_week_array();
					}
					
					if( !empty($name_bases) ) {
						$count = 0;
						foreach($name_bases as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'time') {
					$array_data			= array();
					$timelist			= array();
					
					if( function_exists( 'doctreat_get_time' ) ) {
						$timelist	= doctreat_get_time();
					}
					
					if( !empty($timelist) ) {
						$count = 0;
						foreach($timelist as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'relationship') {
					$array_data			= array();
					$relationship			= array();
					
					if( function_exists( 'doctreat_patient_relationship' ) ) {
						$relationship	= doctreat_patient_relationship();
					}
					
					if( !empty($relationship) ) {
						$count = 0;
						foreach($relationship as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'intervals') {
					$array_data			= array();
					$intervals			= array();
					
					if( function_exists( 'doctreat_get_padding_time' ) ) {
						$intervals		= doctreat_get_padding_time();
					}
					
					if( !empty($intervals) ) {
						$count = 0;
						foreach($intervals as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'durations') {
					$array_data			= array();
					$durations			= array();
					
					if( function_exists( 'doctreat_get_meeting_time' ) ) {
						$durations		= doctreat_get_meeting_time();
					}
					
					if( !empty($durations) ) {
						$count = 0;
						foreach($durations as $key =>$v ){
							$count++;
							$array_data[$count]['key'] = strval( $key );
							$array_data[$count]['val'] = $v;
						}
					}
					
					$item	= array_values($array_data);
					return new WP_REST_Response($item, 200);
				} else if($list === 'services') {
					$services			= array();
					
					$profile_id			= !empty( $request['profile_id'] ) ?  $request['profile_id'] : '';
					if( function_exists( 'doctreat_list_services_with_specility' ) && !empty($profile_id) ) {
						$services		= doctreat_list_services_with_specility($profile_id);
					}
					
					$item	= array_values($services);
					return new WP_REST_Response($item, 200);
				}
				
			} else {
				$json['type'] 		= "error";
				$json['message'] 	= esc_html__("There are no taxonomies found.", 'doctreat_api');
				return new WP_REST_Response($json, 203);	
			}
		}
		
		/**
         * Get specialties
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_specilities() {
			$json	= array();
			$item	= array();
			$items	= array();
			
			$terms		= doctreat_get_taxonomy_array('specialities');
			$terms_data	= array();

			if( !empty($terms) ) {
				foreach ($terms as $key => $term) {

					$terms_data[$term->term_id]['id'] 	= $term->term_id;
					$terms_data[$term->term_id]['name'] = $term->name;
					$terms_data[$term->term_id]['slug'] = $term->slug;

					$logo 	= get_term_meta( $term->term_id, 'logo', true );
					$color 	= get_term_meta( $term->term_id, 'color', true );

					$terms_data[$term->term_id]['url'] = !empty( $logo['url'] ) ? esc_url( $logo['url'] ) : '';
					$terms_data[$term->term_id]['color'] = !empty( $color ) ? esc_attr( $color ) : '';
				}
			}

			$item		= array_values($terms_data);

			return new WP_REST_Response($item, 200);
		}
		
		/**
         * Get Service
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
		public function get_servicess($request) {
			$json	= array();
			$item	= array();
			$items	= array();
			
			$speciality			= !empty( $request['speciality'] ) ?  $request['speciality'] : '';

			if( !empty( $speciality ) ){
				$terms				= doctreat_list_service_by_specialities($speciality);
			} else {
				$terms		= doctreat_get_taxonomy_array('services');
			}

			$terms_data	= array();

			if( !empty($terms) ) {
				foreach ($terms as $key => $term) {

					$terms_data[$term->term_id]['id'] 	= $term->term_id;
					$terms_data[$term->term_id]['name'] = $term->name;
					$terms_data[$term->term_id]['slug'] = $term->slug;

					$logo 	= get_term_meta( $term->term_id, 'logo', true );

					$terms_data[$term->term_id]['url'] = !empty( $logo['url'] ) ? esc_url( $logo['url'] ) : '';
				}
			}

			$item		= array_values($terms_data);

			return new WP_REST_Response($item, 200);
		}
		
    }
}

add_action('rest_api_init',
function () {
    $controller = new DoctreatApp_Taxonomies_Route;
    $controller->register_routes();
});
