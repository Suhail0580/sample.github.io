<?php
/**
 * Templater
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if( !class_exists('_PageTemplaterLoader')){
	
	class _PageTemplaterLoader {

		private static $instance;
		protected $templates;

		//get class instance
		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new _PageTemplaterLoader();
			} 

			return self::$instance;

		} 

		//Constructor
		private function __construct() {
			$this->templates = array();

			if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
				add_filter('page_attributes_dropdown_pages_args',array( $this, 'register_custom_templates' ));
			} else {
				add_filter('theme_page_templates', array( $this, 'add_new_template' ));
			}

			add_filter('wp_insert_post_data', array( $this, 'register_custom_templates' ) );
			add_filter('template_include', array( $this, 'view_custom_templates') );

			// Add your templates to this array.
			$this->templates = array(
				'mobile-checkout.php' => esc_html__('Mobile Checkout','doctreat_api'),
				'prescription.php' => esc_html__('Download Prescription For Mobile APP','doctreat_api'),
			);

		} 

		//Add new templates
		public function add_new_template( $posts_templates ) {
			$posts_templates = array_merge( $posts_templates, $this->templates );
			return $posts_templates;
		}

		//Register Templates
		public function register_custom_templates( $atts ) {
			$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

			$templates = wp_get_theme()->get_page_templates();
			if ( empty( $templates ) ) {
				$templates = array();
			} 

			wp_cache_delete( $cache_key , 'themes');
			$templates = array_merge( $templates, $this->templates );
			wp_cache_add( $cache_key, $templates, 'themes', 1800 );

			return $atts;

		} 

		//Embed into dropdown
		public function view_custom_templates( $template ) {
			global $post;
			if ( ! $post ) {return $template;}

			if ( ! isset( $this->templates[get_post_meta( $post->ID, '_wp_page_template', true )] ) ) {
				return $template;
			} 

			$file = plugin_dir_path( __FILE__ ). get_post_meta($post->ID, '_wp_page_template', true);

			if ( file_exists( $file ) ) {
				return $file;
			} else {
				echo $file;
			}

			return $template;

		}

	} 
	add_action( 'plugins_loaded', array( '_PageTemplaterLoader', 'get_instance' ) );
}

if( !function_exists('doctreat_app_checkout_css') ){
	function doctreat_app_checkout_css() {
		if( isset( $_GET['platform'] ) 
		   || isset( $_GET['download_prescription_id'] ) 
		   || ( wp_is_mobile() && function_exists('is_wc_endpoint_url') && is_wc_endpoint_url( 'order-received' ) ) 
		){?>
			<style type="text/css">
				.dc-appavailable,
				.wt-innerbannerholder,
				.wt-demo-sidebar,
				#dc-header,
				.dc-innerbanner-holder,
				#dc-footer,
				.dc-breadcrumbarea,
				header,
				footer{
					display: none !important;
				}
				#dc-main{
					padding: 0px 0 !important;
				}
				.wc-credit-card-form.wc-payment-form{
					clear:both !important;
				}
				.wc-stripe-elements-field, .wc-stripe-iban-element-field {
					min-height: 40px;
					line-height: 40px;
				}
			</style>
		<?php
		}
	}
	add_action('wp_head', 'doctreat_app_checkout_css');
}