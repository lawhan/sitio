<?php
/*
Plugin Name: Should I Turn it On
Plugin URI: 
Description: A brief description of the Plugin.
Version: The Plugin's Version Number, e.g.: 1.0
Author: Lawrence Han
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'SITIO_PLUGIN_DIR' ) )
	define( 'SITIO_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
	
if ( !is_admin() ){
	add_action( 'plugins_loaded', 'sitio_add_shortcodes', 1 );
	function sitio_add_shortcodes()
	{
		add_shortcode( 'sitio', 'sitio_init' );
		add_shortcode( 'sitiopost', 'sitio_post' );
	}
}
		
require_once SITIO_PLUGIN_DIR . '/sitio-init.php';
require_once SITIO_PLUGIN_DIR . '/processor.php';
?>