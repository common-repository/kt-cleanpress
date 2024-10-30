<?php

/*
Plugin Name: kt-cleanpress
Plugin URI: https://wordpress.org/extend/plugins/kt-cleanpress/
Description: Clean and Optimize wordpress
Version: 1.1
Author: MWK
Author URI: http://keefthis.info
License: GPLv2
*/

function kt_init_display() {
	load_plugin_textdomain('kt-cleanpress',false,'kt-cleanpress/includes/lang');
	include ( plugin_dir_path(__FILE__) . 'includes/kt-initdisplay.php' );
}

function ktclean_style() {
	wp_enqueue_style( 'ktcleancss', plugins_url( 'includes/css/ktclean.css' , __FILE__));
}


function ktclean_menu() {
	$handle = add_menu_page( 'kt cleanpress', 'kt cleanpress',
			'manage_options', __FILE__, 'kt_init_display' );
	add_action( 'admin_print_styles-' . $handle, 'ktclean_style' );
}



add_action( 'admin_menu', 'ktclean_menu' );

?>