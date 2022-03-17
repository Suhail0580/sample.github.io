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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DoctreatApp
 * @subpackage DoctreatApp/admin
 * @author     Amento Tech <theamentotech@gmail.com>
 */
class DoctreatApp_Admin {

    public function __construct() {
        $this->plugin_name = DoctreatAppGlobalSettings::get_plugin_name();
        $this->version = DoctreatAppGlobalSettings::get_plugin_verion();
        $this->plugin_path = DoctreatAppGlobalSettings::get_plugin_path();
        $this->plugin_url = DoctreatAppGlobalSettings::get_plugin_url();        
    }

}
