<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    DoctreatApp
 * @subpackage DoctreatApp/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    DoctreatApp
 * @subpackage DoctreatApp/includes
 * @author     Amento Tech <theamentotech@gmail.com>
 */
if (!class_exists('DoctreatApp_Core')) {

    class DoctreatApp_Core {

        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the admin area and
         * the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function __construct() {
            $this->load_dependencies();
            $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - DoctreatApp_Loader. Orchestrates the hooks of the plugin.
         * - DoctreatApp_i18n. Defines internationalization functionality.
         * - DoctreatApp_Admin. Defines all hooks for the admin area.
         * - DoctreatApp_Public. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function load_dependencies() {

            /**
             * The class responsible for orchestrating the actions and filters of the
             * core plugin.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-system-loader.php';

            /**
             * The class responsible for defining internationalization functionality
             * of the plugin.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-system-i18n.php';

            /**
             * The class responsible for defining all actions that occur in the admin area.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-system-admin.php';

            /**
             * The class responsible for defining all functions that occur in the admin area.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/functions.php';

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-system-public.php';


            $this->loader = new DoctreatApp_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the DoctreatApp_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function set_locale() {

            $plugin_i18n = new DoctreatApp_i18n();

            $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
        }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_public_hooks() {
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
        public function run() {
            $this->loader->run();
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @since     1.0.0
         * @return    DoctreatApp_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader() {
            return $this->loader;
        }

    }

}