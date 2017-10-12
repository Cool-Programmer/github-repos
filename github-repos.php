<?php
/*
*	Plugin name: Github Repos
*	Plugin URI: http://www.iodevllc.com
*	Description: A WordPress plugin widget for fetching github repos
* 	Version: 0.1 beta
*	Author:	Mher Margaryan
*	Author URI: iodevllc.com
*/

// Exit if direct
if (!defined('ABSPATH')) {
	exit("You are not allowed to be here!");
}

// Load scripts
require_once(plugin_dir_path(__FILE__) . '/includes/github-repos-scripts.php');

// Load the class file
require_once(plugin_dir_path(__FILE__) . '/includes/github-repos-class.php');

// Register Widget
function gr_register_widget()
{
	register_widget('GR_Widget');
}
add_action('widgets_init', 'gr_register_widget');