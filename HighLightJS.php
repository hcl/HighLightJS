<?php
/*
Plugin Name: HighLightJS
Plugin URI:  https://th0.me
Description: Import highlight.js to the WordPress.
Version:     0.2
Author:      hcl
Author URI:  https://th0.me
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hljs
Domain Path: /languages
*/

if (!function_exists('add_action')){
    exit;
}

define('HLJS_PLUGIN_URL',plugins_url(__FILE__));

require_once('HighLightJS-settings.php');

function hljs_init(){
    $style_name=get_option('hljs-settings')['hljs-settings-style-choose'];
    if ($style_name=='') {
        $style_name='default';
    }
    wp_enqueue_style('hljs_css', plugins_url('/styles/'.$style_name.'.css',__FILE__));
    wp_enqueue_script('hljs_script', plugins_url('/js/highlight.pack.js',__FILE__));
}

function hljs_load(){
    //echo("<script>hljs.initHighlightingOnLoad();</script>");
    wp_enqueue_script('hljs_render', plugins_url('/js/highlight.load.js',__FILE__));
}

function hljs_register_admin_menu(){
    //add_submenu_page('options-general.php','HighLightJS Settings','HighLightJS','manage_options','hljs','hljs_option_page');
    add_options_page('HighLightJS Settings','HighLightJS','manage_options','hljs-settings','hljs_settings_page');
}

function hljs_activate(){
    register_uninstall_hook(__FILE__,'hljs_uninstall');
}

function hljs_uninstall(){
    unregister_setting('hljs-settings', 'hljs-settings');
    $option_name = 'hljs-settings';
    delete_option($option_name);
    delete_site_option($option_name);
}

register_activation_hook(__FILE__,'hljs_activate');

add_action('wp_head','hljs_init');
add_action('wp_head','hljs_load');
add_action('admin_menu','hljs_register_admin_menu');