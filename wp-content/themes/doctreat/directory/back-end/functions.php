<?php
/**
 *
 * Functions
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */


/**
 * @get settings
 * @return {}
 */
if (!function_exists('doctreat_profile_backend_settings')) {
	function  doctreat_profile_backend_settings(){
		if(current_user_can('administrator')) {
			$list	= array(
				'payments'	 	=> 'payments',
			);
			return $list;
		}
		
		return array();
	}
}

/**
 * @Admin notices
 * @return {}
 */
if(!function_exists('doctreat_admin_notices_list')){
	function doctreat_admin_notices_list() {
		if(!is_plugin_active('wp-guppy/wp-guppy.php')){?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'WP Guppy - A live chat plugin is compatible with Doctreat - Doctors and Hospitals Directory WordPress Theme', 'doctreat' ); ?></strong></p>
				<p><a class="button button-primary" target="_blank" href="https://codecanyon.net/item/wpguppy-a-live-chat-plugin-for-wordpress/34619534?s_rank=1"><?php esc_html_e( 'Install WP Guppy', 'doctreat' ); ?></a></p>
			</div>
			<?php
		}
	}
	add_action( 'admin_notices', 'doctreat_admin_notices_list' );
}