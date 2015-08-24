<?php
/*
Plugin Name: Trusted
Description: Provides a Trusted.ro widget.
Version: 1.0
Author: Florin Buga
License: GPL2
*/

define( 'TRUSTED__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TRUSTED__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( TRUSTED__PLUGIN_DIR . 'class.trusted-widget.php' );
