<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    DoctreatApp
 * @subpackage DoctreatApp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DoctreatApp
 * @subpackage DoctreatApp/public
 * @author     Amento Tech <theamentotech@gmail.com>
 */
class DoctreatApp_Public {

    public function __construct() {

        $this->plugin_name = DoctreatAppGlobalSettings::get_plugin_name();
        $this->version = DoctreatAppGlobalSettings::get_plugin_verion();
        $this->plugin_path = DoctreatAppGlobalSettings::get_plugin_path();
        $this->plugin_url = DoctreatAppGlobalSettings::get_plugin_url();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in DoctreatApp_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The DoctreatApp_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in DoctreatApp_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The DoctreatApp_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
    }

}
