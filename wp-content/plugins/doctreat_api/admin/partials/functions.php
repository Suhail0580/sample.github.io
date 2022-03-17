<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    DoctreatApp
 * @subpackage DoctreatApp/admin
 */


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    AndroidApp
 * @subpackage AndroidApp/admin
 */
if( !class_exists('Doctreat_Plugin_AutoUpdate') ){
	class Doctreat_Plugin_AutoUpdate {
		private $current_version;
		private $update_path;
		private $plugin_slug;
		private $slug;
		private $license_user;
		private $license_key;

		public function __construct( $current_version, $update_path, $plugin_slug, $license_user = '', $license_key = '' ) {
			$this->current_version 	= $current_version;
			$this->update_path 		= $update_path;

			// Set the License
			$this->license_user 	= $license_user;
			$this->license_key 		= $license_key;

			// Set the Plugin Slug	
			$this->plugin_slug 	= $plugin_slug;
			list ($t1, $t2) 	= explode( '/', $plugin_slug );
			$this->slug 		= str_replace( '.php', '', $t1 );

			// define the alternative API for updating checking
			add_filter( 'pre_set_site_transient_update_plugins', array( &$this, 'doctreat_check_update' ) );
			add_filter( 'plugins_api', array( &$this, 'doctreat_check_info' ), 10, 3 );
		}
		
		//Check if update is available
		public function doctreat_check_update( $transient ) {
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			// Get the remote version
			$remote_version = $this->doctreat_getRemote('version');
			
			// If a newer version is available, add the update
			if ( version_compare( $this->current_version, $remote_version->new_version, '<' ) ) {
				$obj 					= new stdClass();
				$obj->slug 				= $this->slug;
				$obj->new_version 		= $remote_version->new_version;
				$obj->url 				= $remote_version->url;
				$obj->plugin 			= $this->plugin_slug;
				$obj->package 			= $remote_version->package;
				$transient->response[$this->plugin_slug] = $obj;
			}
			return $transient;
		}
		
		//Check plugin version info
		public function doctreat_check_info($obj, $action, $arg) {
			if (($action=='query_plugins' || $action=='plugin_information') && 
				isset($arg->slug) && $arg->slug === $this->slug) {
				return $this->doctreat_getRemote('info');
			}

			return $obj;
		}
		
		//Get plugin remotly
		public function doctreat_getRemote( $action = '' ) {
			$params = array(
				'body' => array(
					'action'       => $action,
					'license_user' => $this->license_user,
					'license_key'  => $this->license_key,
				),
			);

			// Make the POST request
			$request = wp_remote_post($this->update_path, $params );

			// Check if response is valid
			if ( !is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
				return @unserialize( $request['body'] );
			}

			return false;
		}
	}
}

/**
 * Auto update api init
 *
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0
 * @package           Android App API
 */
if( !function_exists('doctreat_api_autoupdate') ){
	add_action( 'init', 'doctreat_api_autoupdate' );
	function doctreat_api_autoupdate() {
		$protocol = is_ssl() ? 'https' : 'http';
		$host						= $protocol.'://amentotech.com/autoupdate/doctreat/';
		$plugin_current_version 	= 2.2;
		$plugin_remote_path 		= $host.'doctreat_api.php';
		$plugin_slug 				= 'doctreat_api/init.php';
		$license_user 				= 'anonymous';
		$license_key 				= 'google';
		new Doctreat_Plugin_AutoUpdate( $plugin_current_version, $plugin_remote_path, $plugin_slug, $license_user, $license_key );
	}
}


/**
 * Gte post author
 *
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0
 * @package           Android App API
 */
if( !function_exists('doctreat_get_post_author') ){
	function doctreat_get_post_author($post_id) {
		$post = get_post( $post_id );
     	return $post->post_author;
	}
}
