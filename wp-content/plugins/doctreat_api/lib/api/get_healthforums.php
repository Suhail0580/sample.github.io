<?php
/**
 * Manage Forums
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */

if (!class_exists('DoctreatAppGetForumsRoutes')) {

    class DoctreatAppGetForumsRoutes extends WP_REST_Controller{
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'forums';
			
			//Get listings
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
			
			//get basic
			register_rest_route($namespace, '/' . $base . '/basic',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_basic'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//get answers
			register_rest_route($namespace, '/' . $base . '/get_answer',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_answer'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Add question
			register_rest_route($namespace, '/' . $base . '/add_question',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'add_question'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Add answer
			register_rest_route($namespace, '/' . $base . '/update_answer',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_answer'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );		
			
        }
		
		public function add_question($request) {
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$post_title			= !empty( $request['title'] ) ? sanitize_text_field( $request['title']) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id']) : '';
			$post_content		= !empty( $request['description'] ) ?  $request['description'] : '';
			$speciality			= !empty( $request['speciality'] ) ? $request['speciality'] : array(0);
			$post_setting		=  'pending';
			
			$required_fields = array(
				'title'   		=> esc_html__('Title is required', 'doctreat_api'),
				'user_id'   	=> esc_html__('User ID is required', 'doctreat_api'),
				'description'  	=> esc_html__('Description is required', 'doctreat_api'),
				'speciality'	=> esc_html__('Speciality is required','doctreat_api')
			);

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
			
			if(! empty( $post_title ) ){
				$post_array['post_title']		= $post_title;
				$post_array['post_content']		= $post_content;
				$post_array['post_author']		= $user_id;
				$post_array['post_type']		= 'healthforum';
				$post_array['post_status']		= $post_setting;
				$post_id 						= wp_insert_post($post_array);

				if( $post_id ) {
					wp_set_object_terms($post_id,$speciality,'specialities');
					$json['type']    = 'success';
					$json['message'] = esc_html__('Question has been submitted successfully.', 'doctreat_api'); 
					return new WP_REST_Response($json, 200);
				}
			} else {
				$json['type']    = 'error';
				$json['message'] = esc_html__('Oops! something is going wrong.', 'doctreat_api'); 
				return new WP_REST_Response($json, 203);
			}

		}
		
		/**
         * Get Health forum single 
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_answer($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json	= array();
			$post_id		= !empty( $request['post_id'] ) ? intval( $request['post_id'] ) : '';
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$answer			= !empty( $request['answer'] )  ? ( $request['answer'] ) : '';
			
			$required_fields = array(
				'post_id'   	=> esc_html__('Post ID is required', 'doctreat_api'),
				'profile_id'  	=> esc_html__('Profile ID is required', 'doctreat_api'),
				'answer'		=> esc_html__('answer is required','doctreat_api')
			);

			foreach ($required_fields as $key => $value) {
			   if( empty( $request[$key] ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= $value;        
				return new WP_REST_Response($json, 203);
			   }
			}
			
			if( !empty($post_id) && !empty($profile_id) && !empty($answer) ){
				$user_id					= doctreat_get_linked_profile_id($profile_id,'post');
				$display_name				= doctreat_full_name($profile_id);
				$display_name				= !empty($display_name) ? $display_name : '';
				$user_info 					= get_userdata($user_id);
				$user_email					= !empty($user_info->user_email) ? $user_info->user_email : '';
				$time 						= current_time('mysql');
					$data = array(
						'comment_post_ID' 		=> $post_id,
						'comment_author' 		=> $display_name,
						'comment_author_email' 	=> $user_email,
						'comment_author_url' 	=> 'http://',
						'comment_content' 		=> $answer ,
						'comment_type' 			=> '',
						'comment_parent' 		=> 0,
						'comment_date' 			=> $time,
						'user_id'				=> $user_id,
						'comment_approved' 		=> 0,
					);

				wp_insert_comment($data);
				$json['type']    = 'success';
				$json['message'] = esc_html__('Please wait for admin approve.', 'doctreat_api'); 
				return new WP_REST_Response($json, 200);
			}
		}
		/**
         * Get Health forum single 
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_answer($request){
			$json	= array();
			$post_id		= !empty( $request['post_id'] ) ? intval( $request['post_id'] ) : '';
			$items			= array();
			$item			= array();
			if(!empty($post_id)) {
				$item['content']		= get_post_field('content',$post_id);
				$comments 				= get_comments(array('post_id' => $post_id,'orderby' => 'comment_ID','order' => 'DESC'));
				$comments_count  		= get_comments(array('post_id' => $post_id, 'count'   => true));
				$item['count_answers']	= !empty($comments_count) ? $comments_count : 0 ;
				$array_comments		= array();
				if(!empty($comments)) {
					foreach($comments as $comment) {
						$array_comments['answer']	= $comment->comment_content;
						$profile_id					= doctreat_get_linked_profile_id($comment->user_id );
						$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $profile_id), array('width' => 100, 'height' => 100)
							);
						$featured		= get_post_meta($profile_id,'is_featured',true);
						$display_name	= doctreat_full_name($profile_id);
						$sub_heading	= doctreat_get_post_meta( $profile_id ,'am_sub_heading');
						$_is_verified 	= get_post_meta($profile_id, '_is_verified', true);
						
						$array_comments['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
						$array_comments['name']					= !empty( $display_name ) ? $display_name : '';
						$array_comments['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';
						$array_comments['image']				= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
						$array_comments['featured']				= !empty( $featured ) ? 'yes' : '';
						
						$item['answers'][]						= $array_comments;
					}
				}
				
				$items[] = maybe_unserialize($item);
				return new WP_REST_Response($items, 200);
			}
		}
		
		/**
         * Get Health forum listings basic
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_basic($request){
			global $theme_settings;
			$items	= array();
			$item['hf_title']				= !empty( $theme_settings ['hf_title'] ) ? $theme_settings ['hf_title'] : '';
			$item['hf_sub_title']			= !empty( $theme_settings ['hf_sub_title'] ) ? $theme_settings ['hf_sub_title'] : '';
			$item['hf_description']			= !empty( $theme_settings ['hf_description'] ) ? $theme_settings ['hf_description'] : '';
			$item['hf_btn_text']			= !empty( $theme_settings ['hf_btn_text'] ) ? $theme_settings ['hf_btn_text'] : '';
			$item['hf_image']				= !empty( $theme_settings ['hf_image']['url'] ) ? $theme_settings ['hf_image']['url'] : '';
			$items[] = maybe_unserialize($item);
			return new WP_REST_Response($items, 200);
		}
		
		/**
         * Get Health forum listings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_listing($request){
			$items	= array();
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
			$order         	= !empty($request['order']) ? $request['order'] : 'DESC';
			$sorting       	= !empty($request['orderby']) ? $request['orderby'] : 'ID';
			$speciality 	= !empty( $request['specialities']) ? $request['specialities'] : '';

			$keyword 		= !empty( $request['search']) ? $request['search'] : '';

			$date_formate		= get_option('date_format');
			$paged 				= $page_number;
			$query_args = array(
					'posts_per_page' 	=> $show_posts,
					'post_type' 		=> 'healthforum',
					'post_status' 		=> array('publish'),
					'paged' 			=> $page_number,
					'suppress_filters'  => false
				);

			//Specialities
			if ( !empty($speciality) ) {    
				$query_relation = array('relation' => 'OR',);
				$location_args 	= array(
					'taxonomy' => 'specialities',
					'field'    => 'slug',
					'terms'    => $speciality,
				);

				$tax_query_args[] = array_merge($query_relation, $location_args);
			}

			if( !empty( $orderby ) ){
				$query_args['orderby']  	= $orderby;
			}

			if( !empty( $order ) ){
				$query_args['order'] 		= $order;
			}
			//keyword search
			if( !empty($keyword) ){
				$query_args['s']	=  $keyword;
			}

			//Taxonomy Query
			if ( !empty( $tax_query_args ) ) {
				$query_relation = array('relation' => 'AND',);
				$query_args['tax_query'] = array_merge($query_relation, $tax_query_args);    
			}

			$query      = new WP_Query($query_args);
			$count_post = $query->found_posts;
			$item				= array();
			$category_vals		= array();
			
			if( $query->have_posts() ){
				while ($query->have_posts()) : $query->the_post(); 
					global $post;
					$db_specialities	= wp_get_post_terms($post->ID, 'specialities');
					$speciality_img		= !empty( $db_specialities[0] ) ? get_term_meta( $db_specialities[0]->term_id, 'logo', true ) : '';
					if( !empty( $speciality_img['attachment_id'] ) ){
						$thumbnail	= wp_get_attachment_image_src( $speciality_img['attachment_id'],	 'doctreat_artical_auther', true );
					}

					$item['image']		= !empty( $thumbnail[0] ) ? $thumbnail[0] : '';
					$title				= get_the_title( $post->ID );
					$item['title']		= !empty( $title ) ? $title : '';
					$item['content']	= get_the_content($post->ID);
					$item['ID']			= $post->ID;

					$post_date			= get_post_field('post_date',$post->ID);
					$item['post_date']	= !empty($post_date) ? date($date_formate,strtotime($post_date)) : '';
					$answered			= get_comments_number($post->ID);
					$item['answers']	= !empty( $answered ) ? $answered : 0;

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
         * Get Single Doctor Articles
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_single($request){
			$items	= array();
			$post_id		= !empty( $request['post_id'] ) ? intval( $request['post_id'] ) : '';
			
			if( !empty( $post_id ) ){
				$post_author 	= get_post_field ('post_author', $post_id);
				$profile_id  	= doctreat_get_linked_profile_id( $post_author );
				$name			= doctreat_full_name( $profile_id );
				$user_link		= get_the_permalink($profile_id);
				$user_contents	= get_post_field('post_content', $profile_id);
				$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $profile_id), array('width' => 100, 'height' => 100)
							);

				$date_formate	= get_option('date_format');
				$post_date		= !empty($profile_id) ? get_post_field('post_date',$profile_id) : "";

				$item['user_name']			= !empty( $name ) ? $name : ''; 
				$item['user_link']			= !empty( $user_link ) ? esc_url( $user_link ) : ''; 
				$item['user_contents']		= !empty( $user_contents ) ? do_shortcode( $user_contents ) : ''; 
				$item['user_image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
				$item['user_date']			= !empty( $post_date ) ? date($date_formate,strtotime($post_date)) : '';

				$thumbnail      = doctreat_prepare_thumbnail($post_id, $width, $height);
				$post_likes		= get_post_meta($post_id,'post_likes',true);
				$item['likes']	= !empty( $post_likes ) ? $post_likes : 0 ;

				$post_views			= get_post_meta($post_id,'post_views',true);
				$item['views']		= !empty( $post_views ) ? $post_views : 0 ;
				
				$post_content				= get_post_field('post_content', $post_id);
				$item['post_content']		= !empty( $post_content ) ? do_shortcode( $post_content ) : '';
				
				$tags_terms			= wp_get_post_terms( $post_id, 'post_tag');
				$tags_array			= array();
				
				if( !empty( $tags_terms ) ){
					foreach( $tags_terms as  $tags ){
						$tag_vals			= array();
						$tag_vals['id']		= $tags->term_id;
						$tag_vals['name']	= $tags->name;
						$tag_vals['slug']	= $tags->slug;
						$tags_array[]		= $tag_vals;
					}
				}
				
				$item['post_tags']	= !empty( $tags_array ) ? $tags_array : '';
				
				$sp_terms			= wp_get_post_terms( $post_id, 'category');
				if( !empty( $sp_terms[0]->term_id ) ){
					$category_vals['id']	= $sp_terms[0]->term_id;
					$category_vals['name']	= $sp_terms[0]->name;
					$category_vals['slug']	= $sp_terms[0]->slug;
				}

				$item['categories']	= !empty( $category_vals ) ? ($category_vals) : array();
				$item['image_url']	= !empty( $thumbnail ) ? esc_url( $thumbnail ) : '';

				$title			= get_the_title($post_id);
				$item['title']	= !empty( $title ) ? esc_attr( $title ) : '';
				
				$post_url			= get_the_permalink($post_id);
				$item['post_url']	= !empty( $post_url ) ? esc_url( $post_url ) : '';
				$items[] = maybe_unserialize($item);
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
	$controller = new DoctreatAppGetForumsRoutes;
	$controller->register_routes();
});
