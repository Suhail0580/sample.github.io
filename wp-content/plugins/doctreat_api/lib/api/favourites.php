<?php
/**
 * Manage Favorites
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatAppAddToFavouriteRoutes')) {
    class DoctreatAppAddToFavouriteRoutes extends WP_REST_Controller
    {

        public function register_routes()
        {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'user';
            
            //add to favourites/wishlist
            register_rest_route(
                $namespace,
                '/' . $base . '/add_wishlist',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'add_to_fav'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
            
			//get list
            register_rest_route(
                $namespace,
                '/' . $base . '/get_wishlist',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_favourites'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

            //remove all to favourites
            register_rest_route(
                $namespace,
                '/' . $base . '/delete_wishlists',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::EDITABLE,
                        'callback' 	=> array(&$this, 'remove_all_to_fav'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );
        }

        /**
         * Delete all to favourite
         *
         * @param WP_REST_Request $request Delete about the favourites.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_all_to_fav($request)
        {
            if( function_exists('doctreat_is_demo_api') ) {
                doctreat_is_demo_api() ;
            } //if demo site then prevent

            if( function_exists('doctreat_api_auth') ) {
                doctreat_api_auth($request) ;
            } //if demo site then prevent

            $profile_id     = !empty($request['profile_id']) ? intval($request['profile_id']) : '';
            $type           = !empty($request['type']) ? $request['type'] : '';
            $json           = array();

            if (!empty($profile_id) && !empty($type)) {
                if($type == 'doctors'){
                    update_post_meta( $profile_id, '_saved_doctors', '' );
                    $json['type'] 		= 'success';
                    $json['message'] 	= esc_html__('Successfully! removed all wishlist', 'doctreat_api');
                    return new WP_REST_Response($json, 200);
                } elseif ($type == 'hospitals'){
                    update_post_meta( $profile_id, '_saved_hospitals', '' );
                    $json['type'] 		= 'success';
                    $json['message'] 	= esc_html__('Successfully! removed all wishlist', 'doctreat_api');
                    return new WP_REST_Response($json, 200);
                }
            } else{
                $json['type'] = 'error';
                $json['message'] = esc_html__('Oops! something is going wrong.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }



        /**
         * Add to favourite
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function add_to_fav($request)
        {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
            } //if demo site then prevent
            
			if( function_exists('doctreat_api_auth') ) { 
				doctreat_api_auth($request) ;
            } //if demo site then prevent
            
            $current_user_id = get_current_user_id();
            $post_id = !empty($request['id']) ? intval($request['id']) : '';
            $user_id = !empty($request['user_id']) ? intval($request['user_id']) : '';
            $json 	 = array();

            if (empty($user_id) && $user_id != $current_user->ID) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('You must login before add this to wishlist.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
            
            $linked_profile   	= doctreat_get_linked_profile_id($user_id);
            $post_type			= get_post_type($post_id);
            $post_key			= '_saved_'.$post_type;
            $saved_posts 		= get_post_meta($linked_profile, $post_key, true);
            
            $json       = array();
            $wishlist   = array();
            $wishlist   = !empty($saved_posts) && is_array($saved_posts) ? $saved_posts : array();

            if (!empty($post_id)) {
                if (in_array($post_id, $wishlist)) {
                    $json['type'] 		= 'error';
                    $json['message'] 	= esc_html__('This is already to your wishlist', 'doctreat_api');
                    return new WP_REST_Response($json, 203);
                } else {
                    $wishlist[] = $post_id;
                    $wishlist   = array_unique($wishlist);
                    update_post_meta($linked_profile, $post_key, $wishlist);

                    $json['type'] 		= 'success';
                    $json['message'] 	= esc_html__('Successfully! added to your wishlist', 'doctreat_api');
                    return new WP_REST_Response($json, 200);
                }
            }
            
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops! something is going wrong.', 'doctreat_api');
            return new WP_REST_Response($json, 203);
        }

        /**
         * Add to favourite
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_favourites($request)
        {
            if( function_exists('doctreat_api_auth') ) { 
				doctreat_api_auth($request) ;
            } //if demo site then prevent
            $profile_id		 = !empty($request['profile_id']) ? intval($request['profile_id']) : '';
            $type			 = !empty($request['type']) ? $request['type'] : '';
            $post_id 		 = $profile_id;
			
            if (!empty($profile_id)) {
                $show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
                $pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
                $pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
                $paged 			= max($pg_page, $pg_paged);
                $order 			= 'DESC';
                $sorting 		= 'ID';

				if ($type == 'doctors') {
					$saved_ids	= get_post_meta($post_id, '_saved_doctors', true);
				} elseif ($type == 'hospitals') {
					$saved_ids	= get_post_meta($post_id, '_saved_hospitals', true);
				}
				$post_array_ids		= !empty($saved_ids) ? $saved_ids : array(0);
				
                $args = array(
                    'posts_per_page' 	=> $show_posts,
                    'post_type' 		=> $type,
                    'orderby' 			=> $sorting,
                    'order' 			=> $order,
                    'paged' 			=> $paged,
                    'post__in' 			=> $post_array_ids,
                    'suppress_filters' 	=> false
                );
                $query 			= new WP_Query($args);
				$count_post		= $query->found_posts;
				$total_posts	= !empty( $count_post ) ? $count_post : '';
				
                if ($query->have_posts()) {
					while ($query->have_posts()) {
                        $query->the_post();
                        global $post;
                        $speciality_vals	= array();
						
                        if (!empty($type)) {
                            if ($type === 'doctors') {
                                $avatar_url 	= apply_filters(
                                    'doctreat_doctor_avatar_fallback',
                                    doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $post->ID),
                                    array('width' => 100, 'height' => 100)
                                );
								
                                $featured		= get_post_meta($post->ID, 'is_featured', true);
                                $display_name	= doctreat_full_name($post->ID);
                                $sub_heading	= doctreat_get_post_meta($post->ID, 'am_sub_heading');
                                
                                if (!empty($specialities)) {
                                    $speciality		 = doctreat_get_term_by_type('slug', $specialities, 'specialities', 'all');
                                    $speciality		 = get_term_by('id', $speciality, 'specialities');
                                    $specialit_link  = get_term_link($speciality);
                                    $speciality_vals['id']	= $speciality->term_id;
                                    $speciality_vals['name']	= $speciality->name;
                                    $speciality_vals['slug']	= $speciality->slug;
                                } else {
                                    $sp_terms	= wp_get_post_terms($post->ID, 'specialities');
                                    
                                    if (!empty($sp_terms[0]->term_id)) {
                                        $speciality_vals['id']		= $sp_terms[0]->term_id;
                                        $speciality_vals['name']	= $sp_terms[0]->name;
                                        $speciality_vals['slug']	= $sp_terms[0]->slug;
                                    }
                                }
                                
                                $medilcal_verified	= doctreat_get_post_meta($post->ID, 'am_is_verified');
                                $_is_verified 		= get_post_meta($post->ID, '_is_verified', true);
                                
                                $feedback		= get_post_meta($post->ID, 'review_data', true);
                                $feedback		= !empty($feedback) ? $feedback : array();
                                $item['ID']				= $post->ID;
                                $item['total_rating']	= !empty($feedback['dc_total_rating']) ? $feedback['dc_total_rating'] : '0' ;
                                $item['percentage']		= !empty($feedback['dc_total_percentage']) ? $feedback['dc_total_percentage'] : '0' ;
                                $item['average_rating']		= !empty($feedback['dc_average_rating']) ? $feedback['dc_average_rating'] : '0' ;
                                
                                $item['medilcal_verified']		= !empty($medilcal_verified) ? 'yes' : '';
                                $item['is_verified']			= !empty($_is_verified) ? $_is_verified : '';
                                $item['name']					= !empty($display_name) ? $display_name : '';
                                $item['sub_heading']			= !empty($sub_heading) ? $sub_heading : '';
                                $item['role']					= get_post_type($post->ID);
                                $item['specialities']	= !empty($speciality_vals) ? ($speciality_vals) : '';
                                $item['image']			= !empty($avatar_url) ? esc_url($avatar_url) : '';
                                $item['featured']		= !empty($featured) ? 'yes' : '';
                                $item['totals']			= $total_posts;
                            } elseif ($type === 'hospitals') {
                                $avatar_url 	= apply_filters(
                                    'doctreat_doctor_avatar_fallback',
                                    doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $post->ID),
                                    array('width' => 100, 'height' => 100)
                                );
                                $featured		= get_post_meta($post->ID, 'is_featured', true);
                                $display_name	= doctreat_full_name($post->ID);
                                $sub_heading	= doctreat_get_post_meta($post->ID, 'am_sub_heading');
                                
                                if (!empty($specialities)) {
                                    $speciality		 = doctreat_get_term_by_type('slug', $specialities, 'specialities', 'all');
                                    $speciality		 = get_term_by('id', $speciality, 'specialities');
                                    $specialit_link  = get_term_link($speciality);
                                    $speciality_vals['id']	= $speciality->term_id;
                                    $speciality_vals['name']	= $speciality->name;
                                    $speciality_vals['slug']	= $speciality->slug;
                                } else {
                                    $sp_terms	= wp_get_post_terms($post->ID, 'specialities');
                                    
                                    if (!empty($sp_terms[0]->term_id)) {
                                        $speciality_vals['id']		= $sp_terms[0]->term_id;
                                        $speciality_vals['name']	= $sp_terms[0]->name;
                                        $speciality_vals['slug']	= $sp_terms[0]->slug;
                                    }
                                }
                                
                                $medilcal_verified	= doctreat_get_post_meta($post->ID, 'am_is_verified');
                                $_is_verified 		= get_post_meta($post->ID, '_is_verified', true);
                                
                                $item['ID']				= $post->ID;
                                $location				= doctreat_get_location($post->ID);
                                $item['location']		= !empty($location['_country']) ? $location['_country'] : '';
                                
                                $bookig_days				= doctreat_get_post_meta($post->ID, 'am_week_days');
                                $item['bookings_days']		= !empty($bookig_days) ? $bookig_days : array();
                                
                                $tem_members				= doctreat_get_total_posts_by_multiple_meta('hospitals_team', 'publish', array('hospital_id' => $post->ID));
                                $item['no_of_teams']		= !empty($tem_members) ? intval($tem_members) : 0 ;
                                
                                $am_availability	= doctreat_get_post_meta($post->ID, 'am_availability');
                                $am_availability	= !empty($am_availability) ? $am_availability : '';
    
                                if (!empty($am_availability) && $am_availability === 'others') {
                                    $item['availability']	= doctreat_get_post_meta($post->ID, 'am_other_time');
                                } elseif ($am_availability === 'yes') {
                                    $item['availability']	= esc_html__('24/7 availabe', 'doctreat_api');
                                }
                                
                                $item['medilcal_verified']		= !empty($medilcal_verified) ? 'yes' : '';
                                $item['is_verified']			= !empty($_is_verified) ? $_is_verified : '';
                                $item['name']					= !empty($display_name) ? $display_name : '';
                                $item['sub_heading']			= !empty($sub_heading) ? $sub_heading : '';
                                
                                $item['specialities']	= !empty($speciality_vals) ? ($speciality_vals) : '';
                                $item['image']			= !empty($avatar_url) ? esc_url($avatar_url) : '';
                                $item['totals']			= $total_posts;
                            }
                        }
						$items[] = maybe_unserialize($item);
                    }
					return new WP_REST_Response($items, 200);
                    
                //end query
                } else {
                    $message = '';
                    if ($type == 'doctors') {
                        $message = esc_html__('No saved doctors yet', 'doctreat_api');
                    } elseif ($type == 'hospitals') {
                        $message = esc_html__('No saved hospitals yet', 'doctreat_api');
                    }
                    $json['type']		= 'error';
                    $json['message']	= $message;
                    $items[] = $json;
                    return new WP_REST_Response($items, 203);
                }
            }
        }
    }
}

add_action('rest_api_init',
function () {
	$controller = new DoctreatAppAddToFavouriteRoutes;
	$controller->register_routes();
});
