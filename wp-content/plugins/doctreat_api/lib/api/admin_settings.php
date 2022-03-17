<?php
/**
 * APP API to get admin settings
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatAppAdminSettingRoutes')) {

    class DoctreatAppAdminSettingRoutes extends WP_REST_Controller{
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'admin';

            register_rest_route($namespace, '/' . $base . '/get_auth_key',
                array(
					array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'get_auth_key'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
        }
        
		/**
         * Get Auth key
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_auth_key() {
            global $theme_settings;
            $json           = array();
            $doctreat_api    = !empty($theme_settings['doctreat_api']) ? $theme_settings['doctreat_api'] : '';
            if( empty($doctreat_api) ){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Empty API key found.','doctreat_api');
                return new WP_REST_Response($json, 203);
            } else {
                $json['key']    = $doctreat_api;
                $json['type'] 	= 'success';
                return new WP_REST_Response($json, 200);
            }
			
		}
    }
}

add_action('rest_api_init',
function () {
    $controller = new DoctreatAppAdminSettingRoutes;
    $controller->register_routes();
});
