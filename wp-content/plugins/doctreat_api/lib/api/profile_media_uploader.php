<?php
/**
 * APP API to upload media
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat
 *
 */
if (!class_exists('DoctreatApp_uploadmedia')) {

    class DoctreatApp_uploadmedia extends WP_REST_Controller{

        /**
         * Register the routes for the objects of the controller.
         */
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'media';

            register_rest_route($namespace, '/' . $base . '/upload_avatar',
                array(
                    array(
                        'methods' => WP_REST_Server::CREATABLE,
                        'callback' => array($this, 'upload_avatar'),
                        'args' => array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
        }

		/**
         * upload avatar from base64
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function upload_avatar($request){
			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$user_id			= !empty( $request['id'] ) ? intval( $request['id'] ) : '';
			$profile_base64		= !empty( $request['profile_base64'] ) ?  $request['profile_base64'] : '';
			$json = array();
			
			//upload avatar
			if( !empty( $user_id ) && !empty($profile_base64) ){
				
				$profile_id	= doctreat_get_linked_profile_id($user_id);
				$avatar_id = $this->upload_media($profile_base64);

				if( !empty($avatar_id) ){
					$thumnail_id	= get_post_thumbnail_id($profile_id);
					wp_delete_attachment($thumnail_id);
					set_post_thumbnail($profile_id,$avatar_id);

					$json['type']       = 'success';
					$json['message']    = esc_html__('profile image updated', 'doctreat_api');
					return new WP_REST_Response($json, 200); 
				} else {
					$json['type']		= 'error';
					$json['message']	= esc_html__('Some error occur, please try again later.','doctreat_api');
					return new WP_REST_Response($json, 203);
				}
			} else{
				$json['type']		= 'error';
				$json['message']	= esc_html__('user id and image is required fields.','doctreat_api');
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

			// upload file to server
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
	$controller = new DoctreatApp_uploadmedia;
	$controller->register_routes();
});
