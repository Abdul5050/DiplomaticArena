<?php
/**
 *Plugin Name: Hide Wp Admin Bar
 * Plugin URI: http://webkindreds.com/
 *Description:  Hide the front end admin bar in WordPress .
 *Version: 1.0
 *Author: Rahul kumar Singh
 *Author URI: http://webkindreds.com/
 *Text Domain: hide-wp-admin-bar
**/ 

add_filter( 'show_admin_bar', '__return_false' );
?>