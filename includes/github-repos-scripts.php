<?php
	// Enqueue scripts for both (front-end & back end)
	function gr_scripts_enqueue()
	{
		wp_enqueue_style('gr-stylesheet', plugins_url() . '/github-repos/css/styles.css');
		wp_enqueue_script('gr-javascript', plugins_url() . '/github-repos/js/main.js');
	}
	add_action('wp_enqueue_scripts', 'gr_scripts_enqueue');