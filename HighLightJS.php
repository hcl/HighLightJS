<?php
/*
Plugin Name: HighLightJS
Plugin URI:  https://th0.me
Description: Import highlight.js to the WordPress.
Version:     0.1
Author:      hcl
Author URI:  https://th0.me
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: hlj
Domain Path: /languages
*/

function hljs_init(){
    wp_enqueue_style('hljs_css', plugins_url('/styles/tomorrow.css',__FILE__));
    wp_enqueue_script('hljs_script', plugins_url('/js/highlight.pack.js',__FILE__));
}

function hljs_load(){
    //echo("<script>hljs.initHighlightingOnLoad();</script>");
    wp_enqueue_script('hljs_render', plugins_url('/js/highlight.load.js',__FILE__));
}


add_action('wp_head','hljs_init');
add_action('wp_head','hljs_load');
