<?php
/**
 * Get Doctors listings
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatAppGetListingsRoutes')) {

    class DoctreatAppGetListingsRoutes extends WP_REST_Controller{

        /**
         * Register the routes for the objects of the controller.
         */
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'listing';

            register_rest_route($namespace, '/' . $base . '/get_doctors',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctors'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single doctor
			register_rest_route($namespace, '/' . $base . '/get_doctor',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctor'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Get hospital details
			register_rest_route($namespace, '/' . $base . '/get_hospital',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_hospital'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single doctor consultation
			register_rest_route($namespace, '/' . $base . '/get_consultation',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctor_consultation'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single doctor feedback
			register_rest_route($namespace, '/' . $base . '/get_feedback',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctor_feedback'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single doctor Locations
			register_rest_route($namespace, '/' . $base . '/get_location',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctor_locations'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single doctor Articles
			register_rest_route($namespace, '/' . $base . '/get_articles',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_doctor_articles'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single Articles
			register_rest_route($namespace, '/' . $base . '/get_sinle_article',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_article'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//single Hospital team
			register_rest_route($namespace, '/' . $base . '/get_hospital_team',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_hospital_team'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//update article
			register_rest_route($namespace, '/' . $base . '/update_article',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'update_article'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//Remove article
			register_rest_route($namespace, '/' . $base . '/remove_article',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'remove_article'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

            //invoices
            register_rest_route($namespace, '/' . $base . '/invoices',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'user_invoices'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );

            //invoice detail
            register_rest_route($namespace, '/' . $base . '/invoice_detail',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'invoice_detail'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );
        }

        /**
         * Invoice detail
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function invoice_detail($request){
            if( function_exists('doctreat_api_auth') ) {
                doctreat_api_auth($request) ;
            } //if demo site then prevent
            $invoice_array = $user_info = array();
            $invoice_id    = !empty( $request['invoice_id'] ) ? intval($request['invoice_id']) : '';

            $order_exist = get_post_type($invoice_id);
            if(empty($order_exist)){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Order not exist.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }


            if(!empty($invoice_id)){

                $order = wc_get_order( $invoice_id )->get_data();
                if(!empty($order) ) {
                    $order_array['id']                      = $order['id'];
                    $order_array['status']                  = $order['status'];
                    $order_array['currency']                = $order['currency'];
                    $order_array['total']                   = $order['total'];
                    $order_array['amount']                  = doctreat_price_format($order_array['total'],'return');
                    $order_array['payment_method']          = $order['payment_method'];
                    $order_array['payment_method_title']    = $order['payment_method_title'];
                    $order_array['shipping_total']          = $order['shipping_total'];
                    $order_array['order_created_on']        = $order['date_created']->date('Y-m-d H:i:s');

                    $user_info['first_name']    = !empty($order['billing']['first_name']) ? $order['billing']['first_name'] : '';
                    $user_info['last_name']     = !empty($order['billing']['last_name']) ? $order['billing']['last_name'] : '';
                    $user_info['company']       = !empty($order['billing']['company']) ? $order['billing']['company'] : '';
                    $user_info['address_1']     = !empty($order['billing']['address_1']) ? $order['billing']['address_1'] : '';
                    $user_info['address_2']     = !empty($order['billing']['address_2']) ? $order['billing']['address_2'] : '';
                    $user_info['email']         = !empty($order['billing']['email']) ? $order['billing']['email'] : '';
                    $user_info['city']          = !empty($order['billing']['city']) ? $order['billing']['city'] : '';
                    $user_info['state']         = !empty($order['billing']['state']) ? $order['billing']['state'] : '';
                    $user_info['country']       = !empty($order['billing']['country']) ? $order['billing']['country'] : '';
                    $user_info['phone']         = !empty($order['billing']['phone']) ? $order['billing']['phone'] : '';

                    $invoice_array['order'] = $order_array;
                    $invoice_array['user']  = $user_info;
                    return new WP_REST_Response($invoice_array, 200);
                }
            } else {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Something went wrong!', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }

        /**
         * Invoices list
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function user_invoices($request){
            if( function_exists('doctreat_api_auth') ) {
                doctreat_api_auth($request) ;
            } //if demo site then prevent
            $user_id        = !empty( $request['user_id'] ) ? intval($request['user_id']) : '';
            $page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
            $show_posts     = get_option('posts_per_page');
            $date_formate   = get_option('date_format');
            $price_symbol	= doctreat_get_current_currency();
            $invoice_data = $data_array = array();

            $user_role  = '';
            $userdata   = get_userdata($user_id);
            if (!empty($userdata->roles[0])) {
                $user_role = $userdata->roles[0];
            }

            if($user_role === 'hospitals') {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Something went wrong!', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if(!empty($user_id)){
                if (class_exists('WooCommerce')) {
                    $customer_orders = wc_get_orders(
                        array(
                            'customer' => $user_id,
                            'paged'     => $page_number,
                            'paginate'  => true,
                            'limit'     => $show_posts,
                        )
                    );
                    if ( !empty(  $customer_orders->orders ) ) {
                        foreach ( $customer_orders->orders as $customer_order ){
                            $order      	                = wc_get_order( $customer_order );
                            $data_created	                = $order->get_date_created();
                            $actions 		                = wc_get_account_orders_actions( $order );
                            $invoice_data[] = array(
                                'order_id'      => intval($order->get_id()),
                                'date_created'  => date($date_formate,strtotime($data_created)),
                                'symbol'        => $price_symbol,
                                'amount'        => esc_html($order->get_total()),
                            );
                        }
                        $data_array['invoice_data'] = $invoice_data;
                        $data_array['view_btn'] = esc_html__('View', 'doctreat_api');
                        return new WP_REST_Response($data_array, 200);
                    } else {
                        $json['type'] 		= 'error';
                        $json['message'] 	= esc_html__('No record found.', 'doctreat_api');
                        return new WP_REST_Response($json, 203);
                    }
                } else{
                    $json['type'] 		= 'error';
                    $json['message'] 	= esc_html__('Woocommerce not installed!', 'doctreat_api');
                    return new WP_REST_Response($json, 203);
                }
            } else {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Some error occur, please try again later', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }
		
		/**
         * Update article
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function remove_article($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			}; //if demo site then prevent

			$user_id		= !empty( $request['user_id'] ) ? intval($request['user_id']) : '';
			$article_id		= !empty( $request['id'] ) ? intval($request['id']) : '';
			$json			= array();
			
			if(!empty($user_id) && !empty($article_id)) {
				if( !empty($article_id) ) {
					$post_author	= get_post_field('post_author', $article_id);
					$post_author	= !empty( $post_author ) ? intval($post_author) : '';

					if( !empty( $post_author ) && $post_author === $user_id ) {
						wp_delete_post($article_id);
						$json['type']    = 'success';
						$json['message'] = esc_html__('You are successfully remove this article.', 'doctreat_api');  
						return new WP_REST_Response($json, 200);
					} else {
						$json['type'] 		= 'error';
						$json['message'] 	= esc_html__('You are not allowed to remove this article.', 'doctreat_api');
						return new WP_REST_Response($json, 203);
					}
				}
			} else {
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Some thing is missing for remove this article.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
		}
		
		/**
         * Update article
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function update_article($request){
			global $theme_settings;
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$post_title			= !empty( $request['post_title'] ) ? sanitize_text_field( $request['post_title']) : '';
			$post_content		= !empty( $request['post_content'] ) ?  $request['post_content'] : '';
			$post_tags			= !empty( $request['post_tags'] ) ?  $request['post_tags'] : array(0);
			$post_categories	= !empty( $request['post_categories'] ) ? $request['post_categories'] : array(0);
			$update_post_id		= !empty( $request['post_id'] ) ? sanitize_text_field( $request['post_id']) : '';
			$user_id			= !empty( $request['user_id'] ) ? sanitize_text_field( $request['user_id']) : '';
			$thumnail_base64	= !empty( $request['thumnail_base64'] ) ?  $request['thumnail_base64'] : '';
			$article_setting	= !empty( $theme_settings['article_option'] ) ? 'publish' : 'pending';
			$json				= array();
			
			if( empty( $user_id ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('User ID is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			}
			
			if( empty( $post_title ) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('Post title is required.', 'doctreat_api');
				return new WP_REST_Response($json, 203);
			} else {
				$post_array['post_title']		= wp_strip_all_tags( $post_title );
				$post_array['post_content']		= $post_content;
				$post_array['post_author']		= $user_id;
				$post_array['post_type']		= 'post';
				
				if( empty( $update_post_id ) ){

					$post_array['post_status']		= $article_setting;
					$post_id 						= wp_insert_post($post_array);

					if (class_exists('Doctreat_Email_helper') && !empty( $post_id )) {
						$emailData	= array();
						if (class_exists('DoctreatArticleNotify')) {

							$emailData['email']			= $current_user->user_email;
							$emailData['article_title']	= wp_strip_all_tags( $post_title );
							$emailData['doctor_name']	= doctreat_full_name( $profile_id );

							$email_helper = new DoctreatArticleNotify();

							if( $article_setting === 'publish' ) {
								$email_helper->send_article_publish_email($emailData);
							} else {
								$email_helper->send_article_pending_email($emailData);
								$email_helper->send_admin_pending_email($emailData);
							}
						}
					}
				} else{
					$post_array['ID']				= $update_post_id;
					$post_id 						= wp_update_post($post_array);
				}

				if( $post_id ) {
					
					if(!empty($thumnail_base64)) {
						$avatar_id 		= $this->upload_media_file($thumnail_base64);
						$thumnail_id	= get_post_thumbnail_id($post_id);
						if(!empty($thumnail_id)) {
							wp_delete_attachment($thumnail_id);
						}
					
						set_post_thumbnail($post_id, $avatar_id);
					} elseif(empty($request['attachment_id'])) {
						delete_post_thumbnail($post_id);
					}elseif(!empty($request['attachment_id'])) {
						delete_post_thumbnail($post_id);
						set_post_thumbnail($post_id, $request['attachment_id']);
					}
					
					wp_set_post_tags( $post_id, $post_tags );
					wp_set_post_categories( $post_id, $post_categories);
					$json['type']    = 'success';
					$json['message'] = esc_html__('Article is submitted successfully.', 'doctreat_api');    
				}
			}

			return new WP_REST_Response($json, 200);
			
		}
		
		/**
         * upload media from base64
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function upload_media_file($basestring){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
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
		
		/**
         * Get Single Doctor Articles
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_article($request){
			$item			= array();
			$items			= array();
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

				$thumbnail      = doctreat_prepare_thumbnail($post_id);
				$attachment_id	= get_post_thumbnail_id($post_id);
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
				$category_array			= array();
				if( !empty( $sp_terms ) ){
					foreach( $sp_terms as  $sp_term ){
						$category_vals['id']	= $sp_term->term_id;
						$category_vals['name']	= $sp_term->name;
						$category_vals['slug']	= $sp_term->slug;
						$category_array[]		= $category_vals;
					}
				}

				$item['categories']		= !empty( $category_array ) ? ($category_array) : array();
				$item['image_url']		= !empty( $thumbnail ) ? esc_url( $thumbnail ) : '';
				$item['attachment_id']	= !empty($attachment_id) ? $attachment_id : '';
				$title					= get_the_title($post_id);
				$item['title']			= !empty( $title ) ? esc_attr( $title ) : '';
				
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
		
		/**
         * Get Single Hospital teams
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_hospital_team($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			
			if(!empty( $profile_id ) ){
				$author_id 	= get_post_field ('post_author', $profile_id);
				$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
				$paged 			= $page_number;

				$order 			= 'DESC';
				$sorting 		= 'ID';

				$meta_query_args= array();
				$args 			= array(
									'posts_per_page' 	=> $show_posts,
									'post_type' 		=> 'hospitals_team',
									'orderby' 			=> $sorting,
									'order' 			=> $order,
									'post_status' 		=> array('publish'),
									'paged' 			=> $paged,
									'suppress_filters' 	=> false
								);

				$meta_query_args[] = array(
										'key' 		=> 'hospital_id',
										'value' 	=> $profile_id,
										'compare' 	=> '='
									);

				$query_relation 	= array('relation' => 'AND',);
				$args['meta_query'] = array_merge($query_relation, $meta_query_args);

				$query 				= new WP_Query($args);
				$count_post 		= $query->found_posts;
				$item				= array();
				$items				= array();
				
				if( $query->have_posts() ){
					while ($query->have_posts()) : $query->the_post();
						global $post;
						$doctors_id 	= get_post_field ('post_author', $post->ID);
						if( !empty( $doctors_id ) ){
							$doc_id		= doctreat_get_linked_profile_id($doctors_id);
							
							$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $doc_id), array('width' => 100, 'height' => 100)
							);
							$featured		= get_post_meta($doc_id,'is_featured',true);
							$display_name	= doctreat_full_name($doc_id);
							$sub_heading	= doctreat_get_post_meta( $doc_id ,'am_sub_heading');
							
							$sp_terms	= wp_get_post_terms( $doc_id, 'specialities');
								
							if( !empty( $sp_terms[0]->term_id ) ){
								$speciality_vals['id']		= $sp_terms[0]->term_id;
								$speciality_vals['name']	= $sp_terms[0]->name;
								$speciality_vals['slug']	= $sp_terms[0]->slug;
							} 
							
							$medilcal_verified	= doctreat_get_post_meta($doc_id,'am_is_verified');
							$_is_verified 		= get_post_meta($doc_id, '_is_verified', true);
							
							$feedback		= get_post_meta($doc_id,'review_data',true);
							$feedback		= !empty( $feedback ) ? $feedback : array();
							$item['ID']				= $doc_id;
							$item['total_rating']	= !empty( $feedback['dc_total_rating'] ) ? $feedback['dc_total_rating'] : '0' ;
							$item['average_rating']	= !empty( $feedback['dc_average_rating'] ) ? $feedback['dc_average_rating'] : '0' ;
							$item['percentage']		= !empty( $feedback['dc_total_percentage'] ) ? $feedback['dc_total_percentage'] : '0' ;
							
							$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
							$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
							$item['name']					= !empty( $display_name ) ? $display_name : '';
							$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';
							
							$item['specialities']	= !empty( $speciality_vals ) ? ($speciality_vals) : '';
							$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
							$item['featured']		= !empty( $featured ) ? 'yes' : '';
							
							$user_id				= doctreat_get_linked_profile_id($doc_id,'post');
							$bookig_days			= doctreat_get_booking_days( $user_id );
							$item['booking_days']	= !empty( $bookig_days ) ? array_values( $bookig_days ) : array();

							$item['current_day']	= strtolower(date('D'));
							$review_meta		= array(
													'_feedback_recommend' => 'yes'
													);

							$votes				= doctreat_get_total_posts_by_multiple_meta('reviews','publish',$review_meta,$user_id);
							$item['votes']		= !empty( $votes ) ? intval( $votes ) : '0' ;

							$am_starting_price			= doctreat_get_post_meta( $doc_id,'am_starting_price');
							$item['starting_price']		= !empty( $am_starting_price ) ? doctreat_price_format( $am_starting_price,'return') : '';
							$items[] = maybe_unserialize($item);		
						}
					
					endwhile;
					wp_reset_postdata();
					return new WP_REST_Response($items, 200);
				} else {
					$json['type']		= 'error';
					$json['message']	= esc_html__('No record found.','doctreat_api');
					$items[] 			= $json;
					return new WP_REST_Response($items, 203);
				}
			} else {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','doctreat_api');
				$items[] 			= $json;
				return new WP_REST_Response($items, 203);
			}
			
		}
		
		/**
         * Get Single Hospital
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_hospital($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$item	= array();
			$items	= array();
			
			if(!empty( $profile_id ) ){
				$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $profile_id), array('width' => 100, 'height' => 100)
							);
				$featured		= get_post_meta($profile_id,'is_featured',true);
				$display_name	= doctreat_full_name($profile_id);
				$sub_heading	= doctreat_get_post_meta( $profile_id ,'am_sub_heading');

				$sp_terms	= wp_get_post_terms( $profile_id, 'specialities');
				if( !empty( $sp_terms[0]->term_id ) ){
					$speciality_vals['id']		= $sp_terms[0]->term_id;
					$speciality_vals['name']	= $sp_terms[0]->name;
					$speciality_vals['slug']	= $sp_terms[0]->slug;
				} 

				$medilcal_verified	= doctreat_get_post_meta($profile_id,'am_is_verified');
				$_is_verified 		= get_post_meta($profile_id, '_is_verified', true);

				$feedback		= get_post_meta($profile_id,'review_data',true);
				$feedback		= !empty( $feedback ) ? $feedback : array();
				
				$am_specialities	= doctreat_get_post_meta( $profile_id,'am_specialities');
				$specilities_array	= array();
				
				if( !empty( $am_specialities ) ){
					foreach ( $am_specialities as $key => $specialities) { 
						$specilities_value	= array();
						$services_array		= array();
						$specialities_title	= doctreat_get_term_name($key ,'specialities');
						$logo 				= get_term_meta( $key, 'logo', true );
						$logo				= !empty( $logo['url'] ) ? $logo['url'] : '';
						$services			= !empty( $specialities ) ? $specialities : '';
						
						$specilities_value['name']	= !empty( $specialities_title ) ? esc_attr( $specialities_title ) : '';
						$specilities_value['logo']	= !empty( $logo ) ? esc_url( $logo ) : '';
						
						if( !empty( $services ) ){
							foreach ( $services as $key => $service ) {
								$services_value	= array();
								$service_title	= doctreat_get_term_name($key ,'services');
								
								$services_value['title']	= !empty( $service_title ) ? $service_title : '';
								$services_value['price']	= !empty( $service['price'] ) ? doctreat_price_format( $service['price'],'return') : '';
								
								$services_value['description']	= !empty( $service['description'] ) ? $service['description'] : '';
								$services_array[]	= $services_value;
							}
						} else {
							$services_array	= array();
						}
						$specilities_value['services']	=	$services_array;
						
						$specilities_array[]			= $specilities_value;
					}
				}
				
				$item['specialities_data']	= $specilities_array;
				$item['ID']				= $profile_id;
				
				$contents				= get_post_field('post_content', $profile_id);
				$item['contents']		= !empty( $contents ) ? $contents : '';
				
				$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
				$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
				$item['name']					= !empty( $display_name ) ? $display_name : '';
				$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';

				$item['specialities']	= !empty( $speciality_vals ) ? ($speciality_vals) : '';
				$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
				$item['featured']		= !empty( $featured ) ? 'yes' : '';
				$items[] 				= maybe_unserialize($item);
				return new WP_REST_Response($items, 200);
			} else {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','doctreat_api');
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
        public function get_doctor_articles($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$limit			= !empty( $request['limit'] ) ? intval( $request['limit'] ) : 10;
			$offset 		= ($page_number - 1) * $limit;

			$json			= array();
			
			if( isset( $profile_id ) ){
				$date_formate		= get_option('date_format');
				$paged 				= $page_number;
				$order 	 			= 'DESC';
				$sorting 			= 'ID';
				
				if(!empty( $profile_id )) {
					$name		= doctreat_full_name( $profile_id );
					$name		= !empty( $name ) ? $name : ''; 
					$user_identity  	= doctreat_get_linked_profile_id( $profile_id,'post' );
					
					$args = array(
						'posts_per_page' 	=> $limit,
						'post_type' 		=> 'post',
						'orderby' 			=> $sorting,
						'order' 			=> $order,
						'post_status' 		=> array('publish'),
						'author' 			=> $user_identity,
						'paged' 			=> $page_number,
						'suppress_filters'  => false
					);
				} else {
					$args = array(
						'posts_per_page' 	=> $limit,
						'post_type' 		=> 'post',
						'orderby' 			=> $sorting,
						'order' 			=> $order,
						'post_status' 		=> array('publish'),
						'paged' 			=> $page_number,
						'suppress_filters'  => false
					);
				}
				
				$query 		= new WP_Query($args);
				$count_post = $query->found_posts;

				$width	= 271;
				$height	= 194;
				$item	= array();
				$items	= array();
				$category_vals		= array();
				
				if( $query->have_posts() ){
					while ($query->have_posts()) : $query->the_post(); 
						global $post;
						$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);
						$post_likes		= get_post_meta($post->ID,'post_likes',true);
						$item['likes']	= !empty( $post_likes ) ? $post_likes : 0 ;
					
						$post_views		= get_post_meta($post->ID,'post_views',true);
						$item['views']	= !empty( $post_views ) ? $post_views : 0 ;
						$sp_terms	= wp_get_post_terms( $post->ID, 'category');
						
						$post_date					= !empty($post->ID) ? get_post_field('post_date',$post->ID) : "";
						$item['posted_date']		= !empty( $post_date ) ? date($date_formate,strtotime($post_date)) : '';
						$item['ID']					= !empty($post->ID) ? intval($post->ID) : '';
						if( !empty( $sp_terms[0]->term_id ) ){
							$category_vals['id']		= $sp_terms[0]->term_id;
							$category_vals['name']	= $sp_terms[0]->name;
							$category_vals['slug']	= $sp_terms[0]->slug;
						}
					
						$item['categories']	= !empty( $category_vals ) ? ($category_vals) : array();
						$item['image_url']	= !empty( $thumbnail ) ? esc_url( $thumbnail ) : '';
						$title			= get_the_title($post->ID);
						$item['title']	= !empty( $title ) ? esc_attr( $title ) : '';
					
						$post_url			= get_the_permalink($post->ID);
						$item['post_url']	= !empty( $post_url ) ? esc_url( $post_url ) : '';
						$item['totals']		= !empty( $count_post ) ? esc_html( $count_post ) : '';
					
						$items[] = maybe_unserialize($item);
					endwhile;
					wp_reset_postdata();
					return new WP_REST_Response($items, 200);	
				} else {
					return new WP_REST_Response($json, 200);	
				}
			}
		}
		
		/**
         * Get Single Doctor Locations
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_doctor_locations($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$json			= array();
			$item	= array();
			$items	= array();
			
			if( !empty( $profile_id ) ){
				$name		= doctreat_full_name( $profile_id );
				$name		= !empty( $name ) ? $name : ''; 
				$author_id 	= doctreat_get_linked_profile_id($profile_id,'post');

				$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
				
				$paged 			= $page_number;
				$order 			= 'DESC';
				$sorting 		= 'ID';

				$args 			= array(
									'posts_per_page' 	=> $show_posts,
									'post_type' 		=> 'hospitals_team',
									'orderby' 			=> $sorting,
									'order' 			=> $order,
									'post_status' 		=> array('publish'),
									'author' 			=> $author_id,
									'paged' 			=> $paged,
									'suppress_filters' 	=> false
								);
				$query 				= new WP_Query($args);
				$count_post 		= $query->found_posts;
				$item				= array();
				
				if( $query->have_posts() ){ 
					while ($query->have_posts()) : $query->the_post();
						global $post;
						$hospital_id	= get_post_meta($post->ID,'hospital_id',true);
	
						if( !empty( $hospital_id ) ){
							$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 350, 'height' => 250), $hospital_id), array('width' => 350, 'height' => 250)
							);
							$featured		= get_post_meta($hospital_id,'is_featured',true);
							$display_name	= doctreat_full_name($hospital_id);
							$sub_heading	= doctreat_get_post_meta( $hospital_id ,'am_sub_heading');
							
							$sp_terms	= wp_get_post_terms( $hospital_id, 'specialities');
							if(!empty($sp_terms)){
								foreach($sp_terms as $sp_term ){
									$speciality_val			= array();
									$speciality_val['id']	= $sp_term->term_id;
									$speciality_val['name']	= $sp_term->name;
									$speciality_val['slug']	= $sp_term->slug;
									$speciality_vals[]		= $speciality_val;
								}
							}							
							
							$medilcal_verified	= doctreat_get_post_meta($hospital_id,'am_is_verified');
							$_is_verified 		= get_post_meta($hospital_id, '_is_verified', true);
							
							$item['ID']				= $hospital_id;
							$location				= doctreat_get_location($hospital_id);
							$item['location']		= !empty( $location['_country'] ) ? $location['_country'] : '';	
							
							$booking_val				= array();
							$bookig_days				= doctreat_get_post_meta( $hospital_id,'am_week_days');
							if(!empty($bookig_days) ){
								foreach($bookig_days as $bookings) {
									$booking_val[]['name'] = $bookings;
									
								}
							}
							$item['bookings_days']		= $booking_val;
							
							$tem_members				= doctreat_get_total_posts_by_multiple_meta('hospitals_team','publish',array('hospital_id' => $hospital_id));
							$item['no_of_teams']		= !empty( $tem_members ) ? intval($tem_members) : 0 ;
							
							$am_availability	= doctreat_get_post_meta( $hospital_id,'am_availability');
							$am_availability	= !empty( $am_availability ) ? $am_availability : '';

							if( !empty( $am_availability ) && $am_availability === 'others' ) {
								$item['availability']	= doctreat_get_post_meta( $hospital_id,'am_other_time');
							} else if($am_availability === 'yes') {
								$item['availability']	= esc_html__('24/7 available','doctreat_api');
							}
							
							$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
							$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
							$item['name']					= !empty( $display_name ) ? $display_name : '';
							$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';
							
							$item['specialities']	= !empty( $speciality_vals ) ? ($speciality_vals) : array();
							$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
						}
					$items[] = maybe_unserialize($item);
					
					endwhile;
					wp_reset_postdata();
					return new WP_REST_Response($items, 200);
				} else {
					return new WP_REST_Response($json, 200);	
				}
				
			}
		}
		/**
         * Get Single Doctor feedback
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_doctor_feedback($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			if( !empty( $profile_id ) ){
				$user_id		= doctreat_get_linked_profile_id( $profile_id ,'post');
				$date_formate	= get_option('date_format');
				$show_posts 	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
				$paged 			= $page_number;
				$order 	 		= 'DESC';
				$sorting 		= 'ID';

				$args = array(
					'posts_per_page' 	=> $show_posts,
					'post_type' 		=> 'reviews',
					'orderby' 			=> $sorting,
					'order' 			=> $order,
					'post_status' 		=> array('publish','pending'),
					'author' 			=> $user_id,
					'paged' 			=> $paged,
					'suppress_filters'  => false
				);

				$query 		= new WP_Query($args);
				$count_post = $query->found_posts;

				$width	= 40;
				$height	= 40;
				$json	= array();
				$item	= array();
				$items	= array();
				$feeback_data	= array();
				
				if( $query->have_posts() ){
					while ($query->have_posts()) : $query->the_post(); 
						global $post;
						$user_id			= get_post_meta($post->ID, '_user_id', true);
						$recommend_class	= '';
						$recommend_text		= '';

						$recommend			= get_post_meta($post->ID, '_feedback_recommend', true);

						if( !empty( $recommend ) && $recommend === 'yes' ){
							$recommend_text		= esc_html__('I Recommend this doctor','doctreat_api');
						} elseif($recommend === 'no' ) {
							$recommend_text	= esc_html__('I don’t recommend','doctreat_api');
							$recommend_class	= 'no';
						}
					
						$feeback_array['recommend']			= $recommend;
						$feeback_array['recommend_text']	= $recommend_text;
					
						$user_profile_id	= doctreat_get_linked_profile_id( $user_id);
						$feedbackpublicly	= get_post_meta($post->ID, '_feedbackpublicly', true);
						$feedbackpublicly	= !empty( $feedbackpublicly ) ? $feedbackpublicly : '';

						$feeback_array['publicly']		= $feedbackpublicly;
						
						$is_verified 					= get_post_meta($user_profile_id, '_is_verified', true);
						$feeback_array['is_verified'] 	= !empty( $is_verified ) ? $is_verified : '';
					
						$name								= doctreat_full_name( $user_profile_id );
						$feeback_array['name'] 				= !empty( $name ) ? $name : ''; 
					
						$tag_line							= doctreat_get_tagline($user_profile_id);
						$feeback_array['tag_line'] 			= !empty( $tag_line ) ? $tag_line : '';
						
						if( !empty( $feedbackpublicly ) && $feedbackpublicly	=== 'yes' ){
							$feeback_array['image_url']	= esc_url( get_template_directory_uri().'/images/user.png' );
						} else {
							$feeback_array['image_url'] 	= apply_filters(
																'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => $width, 'height' => $height), $user_profile_id), array('width' => $width, 'height' => $height) 
															);
						}
					
						$post_date			= !empty($post->ID) ? get_post_field('post_date',$post->ID) : "";
						$feeback_array['date']		= date($date_formate,strtotime($post_date));
						$feeback_array['content']	= get_post_field('post_content', $post->ID);
						$feeback_data[]				= $feeback_array;
					endwhile;
					wp_reset_postdata();
					$items 				= maybe_unserialize($feeback_data);
					return new WP_REST_Response($items, 200);
				} else {
					
					return new WP_REST_Response($json, 200);
				}
			}
			
		}
		
		/**
         * Get Single Doctor
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_doctor($request){
			global $theme_settings;
			$profile_id			= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
            $doctor_id          = doctreat_get_linked_profile_id($profile_id, 'post');
			$user_id 			= !empty($request['user_id']) ? intval($request['user_id']) : '';
			$json	= array();
			$item	= array();
			$items	= array();
			$speciality_vals	= array();
			$booking_option		= array();
			
			if( function_exists('doctreat_theme_option') ){
				$booking_option		= doctreat_theme_option();
			}
			
			//on call options
			$payment_type				= doctreat_theme_option('payment_type');
			$oncall	= 'no';
			if(!empty($payment_type) && $payment_type === 'offline' ){
				$system_booking_oncall		= doctreat_theme_option('system_booking_oncall');
				if(!empty($system_booking_oncall) ){
					$oncall	= 'yes';
				}
			}

            $item['feedback']       = '0';
			if(!empty($profile_id) && !empty($user_id)){
                /* check this user can send feedback or not  */
                $user_reviews = array(
                    'posts_per_page'    => 1,
                    'post_type'         => 'reviews',
                    'author'            => $profile_id,
                    'meta_key'          => '_user_id',
                    'meta_value'        => $user_id,
                    'meta_compare'      => "=",
                    'orderby'           => 'meta_value',
                    'order'             => 'ASC',
                );

                $reviews_query = new WP_Query($user_reviews);
                $reviews_count = $reviews_query->post_count;

                if (isset($reviews_count) && $reviews_count > 0) {
                    $item['feedback']       = '1';
                }
            }

			if(!empty( $profile_id ) ){
				$linked_profile   	= doctreat_get_linked_profile_id($user_id);
				$post_type			= get_post_type($profile_id);
				$post_key			= '_saved_'.$post_type;
				$saved_posts 		= get_post_meta($linked_profile, $post_key, true);
				
				$json       = array();
				$wishlist   = array();
				$wishlist   = !empty($saved_posts) && is_array($saved_posts) ? $saved_posts : array();
				
				if (!empty($profile_id)) {
					$already_saved = 'no';
					if (in_array($profile_id, $wishlist)) {
						$already_saved = 'yes';
					}
				}

				$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $profile_id), array('width' => 100, 'height' => 100)
							);
				$featured		= get_post_meta($profile_id,'is_featured',true);
				$display_name	= doctreat_full_name($profile_id);
				$sub_heading	= doctreat_get_post_meta( $profile_id ,'am_sub_heading');
				$gallery_imgs	= doctreat_get_post_meta( $profile_id, 'am_gallery');

				$sp_terms	= wp_get_post_terms( $profile_id, 'specialities');
				if(!empty($sp_terms)){
					foreach($sp_terms as $sp_term ){
						$speciality_val			= array();
						$speciality_val['id']	= $sp_term->term_id;
						$speciality_val['name']	= $sp_term->name;
						$speciality_val['slug']	= $sp_term->slug;
						$speciality_vals[]		= $speciality_val;
					}
				}
				
				$medilcal_verified	= doctreat_get_post_meta($profile_id,'am_is_verified');
				$_is_verified 		= get_post_meta($profile_id, '_is_verified', true);

				$feedback		= get_post_meta($profile_id,'review_data',true);
				$feedback		= !empty( $feedback ) ? $feedback : array();

				$booking_settings	= array();
				$contact_array	= array();
				if( !empty($oncall) && $oncall === 'yes' ){
					$booking_settings['image']		= !empty( $theme_settings['booking_model_logo']['url'] ) ? $theme_settings['booking_model_logo']['url'] : '';
					$booking_settings['title']		= !empty( $theme_settings['booking_model_title'] ) ? $theme_settings['booking_model_title'] : '';
					
					$booking_system_contact			= doctreat_theme_option('booking_system_contact');
					if(!empty($booking_system_contact) && $booking_system_contact === 'doctor' ){
						$contact_numbers	= doctreat_get_post_meta( $profile_id,'am_booking_contact');
						$booking_detail		= doctreat_get_post_meta( $profile_id,'am_booking_detail');
					}else {
						$contact_numbers	= !empty( $theme_settings['booking_contact_numbers'] ) ? $theme_settings['booking_contact_numbers'] : array();
						$booking_detail		= !empty( $theme_settings['booking_contact_detail']) ? $theme_settings['booking_contact_detail'] : '';
					}

					if(!empty($contact_numbers)){
						foreach( $contact_numbers as $contact_number ){
							if(!empty($contact_number)){
								$contact_array[]['number']	= $contact_number;
							}
						}
					}
					
					$booking_settings['details']		= !empty($booking_detail) ? $booking_detail : '';		
					$booking_settings['phone_numbers']	= $contact_array;
				}

				/* languages */
                $term_lists     = !empty($profile_id) ? wp_get_post_terms( $profile_id, 'languages', array( 'fields' => 'ids' ) ) : array();
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
                $item['languages']    = $array_lang;
				
				$am_specialities	= doctreat_get_post_meta( $profile_id,'am_specialities');
				$specilities_array	= array();
				
				if( !empty( $am_specialities ) ){
					foreach ( $am_specialities as $key => $specialities) { 
						$specilities_value	= array();
						$services_array		= array();
						$specialities_title	= doctreat_get_term_name($key ,'specialities');
						$logo 				= get_term_meta( $key, 'logo', true );
						$logo				= !empty( $logo['url'] ) ? $logo['url'] : '';
						$services			= !empty( $specialities ) ? $specialities : '';
						
						$specilities_value['name']	= !empty( $specialities_title ) ? esc_attr( $specialities_title ) : '';
						$specilities_value['logo']	= !empty( $logo ) ? esc_url( $logo ) : '';
						
						if( !empty( $services ) ){
							foreach ( $services as $key => $service ) {
								$services_value	= array();
								$service_title	= doctreat_get_term_name($key ,'services');
								
								$services_value['title']	= !empty( $service_title ) ? $service_title : '';
								$services_value['price']	= !empty( $service['price'] ) ? doctreat_price_format( $service['price'],'return') : '';
								
								$services_value['description']	= !empty( $service['description'] ) ? $service['description'] : '';
								$services_array[]	= $services_value;
							}
						} else {
							$services_array	= array();
						}
						$specilities_value['services']	=	$services_array;
						
						$specilities_array[]			= $specilities_value;
					}
				}
				
				$item['specialities_data']	= $specilities_array;
				
				$am_experiences			= doctreat_get_post_meta( $profile_id,'am_experiences');
				$expriences	= array();
				if( !empty( $am_experiences ) ){
					foreach( $am_experiences as $exp ){
						$experiences_array		= array();
						$experiences_array['company_name']	= !empty( $exp['company_name'] ) ? $exp['company_name'] : '';
						$experiences_array['job_title']		= !empty( $exp['job_title'] ) ? $exp['job_title'] : '';
						$experiences_array['start']			= !empty( $exp['start_date'] ) ? date('Y', strtotime($exp['start_date'])) : '';
						$experiences_array['ending']			= !empty( $exp['ending_date'] ) ? date('Y', strtotime($exp['ending_date'])) : esc_html__('Present','doctreat_api');
						$expriences[]			= $experiences_array;
					}
				}
				
				$item['experiences']	= $expriences;
				
				$am_educations			= doctreat_get_post_meta( $profile_id,'am_education');
				$educations	= array();
				if( !empty( $am_educations ) ){
					foreach( $am_educations as $edu ){
						$educations_array		= array();
						$educations_array['degree_title']		= !empty( $edu['degree_title'] ) ? $edu['degree_title'] : '';
						$educations_array['institute_name']		= !empty( $edu['institute_name'] ) ? $edu['institute_name'] : '';
						$educations_array['start']				= !empty( $edu['start_date'] ) ? date('Y', strtotime($edu['start_date'])) : '';
						$educations_array['ending']				= !empty( $edu['ending_date'] ) ? date('Y', strtotime($edu['ending_date'])) : esc_html__('Present','doctreat_api');
						$educations[]					= $educations_array;
					}
				}
				$item['educations']	= $educations;
				
				$am_awards			= doctreat_get_post_meta( $profile_id,'am_award');
				
				$awards	= array();
				if( !empty( $am_awards ) ){
					foreach( $am_awards as $award ){
						$awards_array		= array();
						$awards_array['title']		= !empty( $award['title'] ) ? $award['title'] : '';
						$awards_array['year']		= !empty( $award['year'] ) ? $award['year'] : '';
						$awards[]					= $awards_array;
					}
				}
				
				$item['awards']	= $awards;
				
				$am_memberships			= array();
				$am_memberships 		= doctreat_get_post_meta( $profile_id,'am_memberships_name');

				$mberships		= array();
				if( !empty( $am_memberships ) ){
					foreach( $am_memberships as $key => $am_membership ) {
						$memberships_array		= array();
						$mberships[]['title']	= $am_membership;
						
					}
				}
				
				$item['memberships']	= $mberships;
				
				$am_is_verified					= doctreat_get_post_meta( $profile_id,'am_is_verified');
				$item['registration_number']	= !empty( $am_is_verified ) ? doctreat_get_post_meta( $profile_id,'am_registration_number') : '';
				
				$am_downloads				= doctreat_get_post_meta( $profile_id,'am_downloads');
				$item['defult_download']	= get_template_directory_uri().'/images/file-icon.png';
				$downloads					= array();
				
				if( !empty( $am_downloads ) ){
					foreach( $am_downloads as $key => $am_download ) {
						$downloads_array					= array();
						$image								= !empty( $am_download['media']) ?  $am_download['media'] : '';
						$attachment_id						= !empty($am_download['id']) ? $am_download['id'] : '';
						$file_size 							= !empty( $attachment_id) ? filesize(get_attached_file($attachment_id)) : '';	
						$downloads_array['download_name']  = !empty( $attachment_id ) ? get_the_title( $attachment_id ) : '';
						$filetype        					= !empty( $image ) ? wp_check_filetype( $image	 ) : '';
						$downloads_array['download_url']	= wp_get_attachment_url($attachment_id);
						$extension       					= !empty( $filetype['ext'] ) ? $filetype['ext'] : '';
						$downloads_array['download_size']	= size_format($file_size, 2);
						$downloads[]						= $downloads_array;
					}
				}
				
				$item['downloads']		= $downloads;		
				$item['ID']				= $profile_id;
				$item['url']			= get_the_permalink($profile_id);
				$item['user_id']		= doctreat_get_linked_profile_id($profile_id, 'post');
				$contents				= get_post_field('post_content', $profile_id);
				$item['contents']		= !empty( $contents ) ? $contents : '';
				
				$item['total_rating']	= !empty( $feedback['dc_total_rating'] ) ? $feedback['dc_total_rating'] : '0' ;
				$item['average_rating']	= !empty( $feedback['dc_average_rating'] ) ? $feedback['dc_average_rating'] : '0' ;
				$item['percentage']		= !empty( $feedback['dc_total_percentage'] ) ? $feedback['dc_total_percentage'] : '0' ;

				$item['user_type']				= !empty( $profile_id ) ? get_post_type($profile_id) : '';
				$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
				$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
				$item['name']					= !empty( $display_name ) ? $display_name : '';
				$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';

				$item['specialities']	= !empty( $speciality_vals ) ? $speciality_vals : array();
				$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
				$item['featured']		= !empty( $featured ) ? 'yes' : '';
				$item['already_saved']	= !empty( $already_saved ) ? $already_saved : '';
				$item['oncall']			= !empty( $oncall ) ? $oncall : 'no';
				$item['payment_type']		= !empty( $payment_type ) ? $payment_type : 'online';
				$item['booking_setting']	= !empty( $booking_settings ) ? $booking_settings : (object)[];


				if(!empty($gallery_imgs)) {
                    foreach ($gallery_imgs as $key => $gallery_image) {
						$gallery_thumnail_image_url 		= !empty( $gallery_image['attachment_id'] ) ? wp_get_attachment_image_url( $gallery_image['attachment_id'], array(255,200), false ) : '';
						$gallery_image_url 					= !empty( $gallery_image['url'] ) ? $gallery_image['url'] : '';
						$item['gallery_images'][]['url']	= esc_url($gallery_thumnail_image_url);
					}
				}
				
				$items[]	= maybe_unserialize($item);
				return new WP_REST_Response($items, 200);
			} else {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','doctreat_api');
				$items[] 			= $json;
				return new WP_REST_Response($items, 203);
			}
		}
		
		/**
         * Get Single Doctor consultation
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_doctor_consultation($request){
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$json			= array();
			if( !empty( $profile_id ) ){
				$link_id	= doctreat_get_linked_profile_id( $profile_id ,'post' );
				$number		= get_option('posts_per_page') ? get_option('posts_per_page') : 10;;
				$comments_args	= array(
									'author__in' 	=> $link_id,
									'post_type'		=> 'healthforum',
									'number'		=> $number,
									'paged'			=> $page_number
									);

				$comments		= get_comments($comments_args);
				$name			= doctreat_full_name( $profile_id );
				$name			= !empty( $name ) ? $name : ''; 
				
				$comments_data	= array();
				if( !empty( $comments ) ){
					foreach( $comments as $comment ){
						$profile_id			= doctreat_get_linked_profile_id($comment->user_id);
						
						$date_formate		= get_option('date_format');
						$db_specialities	= wp_get_post_terms($comment->comment_post_ID, 'specialities');
						$speciality_img		= !empty( $db_specialities[0] ) ? get_term_meta( $db_specialities[0]->term_id, 'logo', true ) : '';
						
						if( !empty( $speciality_img['attachment_id'] ) ){

							$thumbnail	= wp_get_attachment_image_src( $speciality_img['attachment_id'],	 'doctreat_artical_auther', true );
						}
						
						$comments_array['image_url']	= !empty( $thumbnail[0] ) ? $thumbnail[0] : '';
						$post_title						= get_the_title( $comment->comment_post_ID );
						$comments_array['title']		= !empty( $post_title ) ? $post_title : '';
						

						$post_date					= get_post_field('post_date',$comment->comment_post_ID);
						$comments_array['date']		= date($date_formate,strtotime($post_date));
						
						$comments_array['comment']	= $comment->comment_content;
						$comments_array['name']		= $name;
						$comments_data[]			= $comments_array;
					}
					
				}
				$items 				= maybe_unserialize($comments_data);
				return new WP_REST_Response($items, 200);
			} else {
				return new WP_REST_Response($json, 203);
			}
		}

        /**
         * Get Listings
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_doctors($request){
			$limit			= !empty( $request['show_users'] ) ? intval( $request['show_users'] ) : 10;
			$profile_id		= !empty( $request['profile_id'] ) ? intval( $request['profile_id'] ) : '';
			$page_number	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 1;
			$listing_type	= !empty( $request['listing_type'] ) ? esc_attr( $request['listing_type'] ) : '';

			$offset 		= ($page_number - 1) * $limit;
			
			$json	= array();
			$item	= array();
			$items	= array();
			$tax_query_args	= array();
			
			$speciality_vals	= array();
			$items_values		= array();
			$meta_query_args		= array();
			
			if( !empty($profile_id) ) {
				$saved_doctorss	= get_post_meta($profile_id,'_saved_doctors',true);
			}else {
				$saved_doctorss	= array();
			}
			
			if( !empty($listing_type) && $listing_type === 'featured' ){
				$order		 = 'DESC';
				$searchby	 = 'doctors';
				$query_args = array(
					'posts_per_page' 	  => $limit,
					'post_type' 	 	  => array('doctors'),
					'paged' 		 	  => $page_number,
					'post_status' 	 	  => 'publish',
					'ignore_sticky_posts' => 1
				);
				
				$meta_query_args[] = array(
					'key' 			=> 'is_featured',
					'value' 		=> 1,
					'compare' 		=> '='
				);
				
				//order by pro member
				$query_args['meta_key'] = 'is_featured';
				$query_args['orderby']	 = array( 
					'ID'      		=> 'DESC',
					'meta_value' 	=> 'DESC', 
				); 

				//Meta Query
				if (!empty($meta_query_args)) {
					$query_relation = array('relation' => 'AND',);
					$meta_query_args = array_merge($query_relation, $meta_query_args);
					$query_args['meta_query'] = $meta_query_args;
				}
				
				$query 			= new WP_Query($query_args);
				$count_post 	= $query->found_posts;
				$total_posts	= !empty( $count_post ) ? $count_post : '';

			} elseif( !empty($listing_type) && $listing_type === 'latest' ){
				$order		 	= 'DESC';
				$query_args 	= array(
									'posts_per_page' 	  	=> $limit,
									'post_type' 	 	  	=> array('doctors','hospitals'),
									'paged' 		 	  	=> $page_number,
									'post_status' 	 	  	=> 'publish',
									'order'					=> 'ID',
									'orderby'				=> $order,
								);
				$query 			= new WP_Query($query_args);
				$count_post 	= $query->found_posts;
				$total_posts	= !empty( $count_post ) ? $count_post : '';
			} elseif( !empty($listing_type) && $listing_type === 'favorite' ){
				$user_id			= !empty( $request['user_id'] ) ? intval( $request['user_id'] ) : '';
				$linked_profile   	= workreap_get_linked_profile_id($user_id);
				$wishlist 			= get_post_meta($linked_profile, '_saved_doctors',true);
				$wishlist			= !empty($wishlist) ? $wishlist : array();
				
				if( !empty($wishlist) ) {
					$order		 = 'DESC';
					$query_args = array(
						'posts_per_page' 	  	=> $limit,
						'post_type' 	 	  	=> array('doctors'),
						'post__in'				=> $wishlist,
						'paged' 		 	  	=> $page_number,
						'post_status' 	 	  	=> 'publish',
						'order'					=> 'ID',
						'orderby'				=> $order,
						'ignore_sticky_posts' 	=> 1
					);
					$query 			= new WP_Query($query_args);
					$count_post 	= $query->found_posts;
					$total_posts	= !empty( $count_post ) ? $count_post : '';
				} else {
					$json['type']		= 'error';
					$json['message']	= esc_html__('You have no doctors in your favorite list.','doctreat_api');
					$items[] 			= $json;
					return new WP_REST_Response($items, 203);
				}
				
			}elseif( !empty($listing_type) && $listing_type === 'search' ){
				$keyword 		= !empty( $request['keyword']) ? $request['keyword'] : '';
				$locations 	 	= !empty( $request['location']) ? $request['location'] : '';
				$specialities 	= !empty( $request['specialities']) ? $request['specialities'] : '';
				$services 	 	= !empty( $request['services']) ? $request['services'] : '';
				$orderby 		= !empty( $request['orderby']) ? $request['orderby'] : 'id';
				$searchby 		= !empty( $request['searchby']) ? $request['searchby'] : array('doctors','hospitals');
				$order 			= !empty( $request['order']) ? $request['order'] : 'ASC';

				//Locations
				if ( !empty($locations) ) {    
					$query_relation = array('relation' => 'OR',);
					$location_args 	= array(
						'taxonomy' => 'locations',
						'field'    => 'slug',
						'terms'    => $locations,
					);

					$tax_query_args[] = array_merge($query_relation, $location_args);
				}

				//Specialities
				if ( !empty($specialities) ) {    
					$query_relation = array('relation' => 'OR',);
					$location_args 	= array(
						'taxonomy' => 'specialities',
						'field'    => 'id',
						'terms'    => $specialities,
					);

					$tax_query_args[] = array_merge($query_relation, $location_args);
				}

				//services
				if ( !empty($services) ) {    
					$query_relation = array('relation' => 'OR',);
					$location_args 	= array(
						'taxonomy' => 'services',
						'field'    => 'id',
						'terms'    => $services,
					);

					$tax_query_args[] = array_merge($query_relation, $location_args);
				}

				$query_args = array(
					'posts_per_page'      => $limit,
					'paged'			      => $page_number,
					'post_type' 	      => $searchby,
					'post_status'	 	  => 'publish',
					'ignore_sticky_posts' => 1
				);

				if( !empty( $orderby ) ){
					$query_args['orderby']  	= $orderby;
				}

				//order by pro 
				$query_args['meta_key'] = 'is_featured';
				$query_args['orderby']	 = array( 
					'meta_value' 	=> 'DESC', 
					'ID'      		=> 'DESC',
				); 

				if( !empty( $order ) ){
					$query_args['order'] 		= $order;
					if( $order === 'DESC') {
						$slected_order	= 'selected="selected"';
					} else {
						$slected_order 	= '';
					}
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
				
				$query 			= new WP_Query($query_args); 
				$total_posts 	= $query->found_posts;	
				$total_posts	= !empty( $total_posts ) ? $total_posts : '';
				
			}else {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Please provide api type','doctreat_api');
				return new WP_REST_Response($json, 203);
			}

			if ($query->have_posts()) {
								
				while ($query->have_posts()) { 
					$query->the_post();
					global $post;
					$speciality_vals	= array();
					$post_type	= get_post_type($post->ID);
					if( !empty( $searchby ) ){
						if( ($searchby === 'doctors') || ($post_type === 'doctors') ){
							$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $post->ID), array('width' => 100, 'height' => 100)
							);
							$featured		= get_post_meta($post->ID,'is_featured',true);
							$display_name	= doctreat_full_name($post->ID);
							$sub_heading	= doctreat_get_post_meta( $post->ID ,'am_sub_heading');
							
							if( !empty( $specialities ) ){
								$speciality		 = get_term_by('id', $specialities, 'specialities');
								$specialit_link  = get_term_link( $speciality );
								$speciality_vals['id']	= $speciality->term_id;
								$speciality_vals['name']	= $speciality->name;
								$speciality_vals['slug']	= $speciality->slug;
							} else {
								$sp_terms	= wp_get_post_terms( $post->ID, 'specialities');
								
								if( !empty( $sp_terms[0]->term_id ) ){
									$speciality_vals['id']		= $sp_terms[0]->term_id;
									$speciality_vals['name']	= $sp_terms[0]->name;
									$speciality_vals['slug']	= $sp_terms[0]->slug;
								} 
								
							}
							
							$medilcal_verified	= doctreat_get_post_meta($post->ID,'am_is_verified');
							$_is_verified 		= get_post_meta($post->ID, '_is_verified', true);
							
							$feedback		= get_post_meta($post->ID,'review_data',true);
							$feedback		= !empty( $feedback ) ? $feedback : array();
							
							$item['ID']				= $post->ID;
							$item['total_rating']	= !empty( $feedback['dc_total_rating'] ) ? $feedback['dc_total_rating'] : '0' ;
							$item['percentage']		= !empty( $feedback['dc_total_percentage'] ) ? $feedback['dc_total_percentage'] : '0' ;
							$item['average_rating']		= !empty( $feedback['dc_average_rating'] ) ? $feedback['dc_average_rating'] : '0' ;
							
							$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
							$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
							$item['name']					= !empty( $display_name ) ? $display_name : '';
							$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';
							$item['role']					= get_post_type($post->ID);
							$item['specialities']	= !empty( $speciality_vals ) ? ($speciality_vals) : '';
							$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
							$item['featured']		= !empty( $featured ) ? 'yes' : '';
							$item['totals']			= $total_posts;
							
						} 
						
						if(( $searchby === 'hospitals') || ($post_type === 'hospitals') ){
							
							$avatar_url 	= apply_filters(
								'doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $post->ID), array('width' => 100, 'height' => 100)
							);
							$featured		= get_post_meta($post->ID,'is_featured',true);
							$display_name	= doctreat_full_name($post->ID);
							$sub_heading	= doctreat_get_post_meta( $post->ID ,'am_sub_heading');
							
							if( !empty( $specialities ) ){
								$speciality		 = doctreat_get_term_by_type('slug',$specialities,'specialities','all');
								$speciality		 = get_term_by('id', $speciality, 'specialities');
								$specialit_link  = get_term_link( $speciality );
								$speciality_vals['id']	= $speciality->term_id;
								$speciality_vals['name']	= $speciality->name;
								$speciality_vals['slug']	= $speciality->slug;
							} else {
								
								$sp_terms	= wp_get_post_terms( $post->ID, 'specialities');
								
								if( !empty( $sp_terms[0]->term_id ) ){
									$speciality_vals['id']		= $sp_terms[0]->term_id;
									$speciality_vals['name']	= $sp_terms[0]->name;
									$speciality_vals['slug']	= $sp_terms[0]->slug;
								} 
								
							}
							
							$medilcal_verified	= doctreat_get_post_meta($post->ID,'am_is_verified');
							$_is_verified 		= get_post_meta($post->ID, '_is_verified', true);
							
							$item['ID']				= $post->ID;
							$location				= doctreat_get_location($post->ID);
							$item['location']		= !empty( $location['_country'] ) ? $location['_country'] : '';	
							
							$bookig_days				= doctreat_get_post_meta( $post->ID,'am_week_days');
							$item['bookings_days']		= !empty( $bookig_days ) ? $bookig_days : array();
							
							$tem_members				= doctreat_get_total_posts_by_multiple_meta('hospitals_team','publish',array('hospital_id' => $post->ID));
							$item['no_of_teams']		= !empty( $tem_members ) ? intval($tem_members) : 0 ;
							
							$am_availability	= doctreat_get_post_meta( $post->ID,'am_availability');
							$am_availability	= !empty( $am_availability ) ? $am_availability : '';

							if( !empty( $am_availability ) && $am_availability === 'others' ) {
								$item['availability']	= doctreat_get_post_meta( $post->ID,'am_other_time');
							} else if($am_availability === 'yes') {
								$item['availability']	= esc_html__('24/7 availabe','doctreat_api');
							}
							
							$item['medilcal_verified']		= !empty( $medilcal_verified ) ? 'yes' : '';
							$item['is_verified']			= !empty( $_is_verified ) ? $_is_verified : '';
							$item['name']					= !empty( $display_name ) ? $display_name : '';
							$item['sub_heading']			= !empty( $sub_heading ) ? $sub_heading : '';
							
							$item['specialities']	= !empty( $speciality_vals ) ? ($speciality_vals) : '';
							$item['image']			= !empty( $avatar_url ) ? esc_url( $avatar_url ) : '';
							$item['totals']			= $total_posts;
						}
					}
					
					$items[] = maybe_unserialize($item);					
				}
				
				return new WP_REST_Response($items, 200);
			}else{
				$json['type']		= 'error';
				$json['message']	= esc_html__('No record found.','doctreat_api');
				$items[] = $json;
				return new WP_REST_Response($items, 203);
			} 
        }

    }
}

add_action('rest_api_init',
function () {
	$controller = new DoctreatAppGetListingsRoutes;
	$controller->register_routes();
});

