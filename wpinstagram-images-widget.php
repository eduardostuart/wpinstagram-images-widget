<?php
/**
 * Plugin Name: WP Instagram Images Widget
 * Plugin URI: http://eduardostuart.com.br/
 * Description: Instagram Images Widget get your most recent activity at Instagram and display them in a Widget.
 * Version: 2.0.3
 * Author: Eduardo Stuart
 * Author URI: http://eduardostuart.com.br
 * Tested up to: 3.5
 *
 * Text Domain: wpinstagramimageswidget
 * Domain Path: /languages/
 */


define('WPINSTAGRAM_TXT_DOMAIN'     , 'wpinstagramimageswidget');
define('WPINSTAGRAM_PATH_BASE'      , dirname(__FILE__) . DIRECTORY_SEPARATOR );
define('WPINSTAGRAM_PATH_TEMPLATE'  , WPINSTAGRAM_PATH_BASE . 'templates/');
define('WPINSTAGRAM_PATH_CLASS'     , WPINSTAGRAM_PATH_BASE . 'class/');
define('WPINSTAGRAM_PATH_INC'       , WPINSTAGRAM_PATH_BASE . 'inc/');
define('WPINSTAGRAM_WP_VERSION'     , get_bloginfo('version'));
define('WPINSTAGRAM_WP_MIN_VERSION' , 3.5);
define('WPINSTAGRAM_CACHE_ENABLED'  , true);
define('WPINSTAGRAM_CACHE_TIME'     , 10); //minutes
define('WPINSTAGRAM_MAX_IMAGES'     , 10);
define('WPINSTAGRAM_VERSION'        , '2.0.3');

$upload_dir = wp_upload_dir();
define('WPINSTAGRAM_PATH_CACHE'     , $upload_dir['basedir'] . '/wp-instagram/');
define('WPINSTAGRAM_URL_CACHE'      , $upload_dir['baseurl'] . '/wp-instagram/');



add_filter( 'wp_loaded', function()
{
	load_plugin_textdomain( WPINSTAGRAM_TXT_DOMAIN , false , basename( WPINSTAGRAM_PATH_BASE ) . '/' . 'languages' );
});


function _wpinstagram_template( $template , array $params = array() )
{

	$filename = WPINSTAGRAM_PATH_TEMPLATE . $template . '.php';

	if(file_exists( $filename ))
	{

		foreach( $params as $k => $v ){
			$$k = $v;
		}

		include $filename;

	}else
	{
		_e( sprintf('Template not found<br>%s' , $filename), WPINSTAGRAM_TXT_DOMAIN );
	}
}

if( !function_exists('file_get_html') )
{
	require_once WPINSTAGRAM_PATH_INC   . 'simple_html_dom.php';
}

require_once WPINSTAGRAM_PATH_CLASS . 'WPIExceptions.php';
require_once WPINSTAGRAM_PATH_CLASS . 'WPIImageDownload.php';
require_once WPINSTAGRAM_PATH_CLASS . 'WPICache.php';
require_once WPINSTAGRAM_PATH_CLASS . 'InstagramCrawler.php';
require_once WPINSTAGRAM_PATH_INC   . 'functions.php';
require_once WPINSTAGRAM_PATH_CLASS . 'WPInstagramImagesWidget.php';
require_once WPINSTAGRAM_PATH_INC   . 'shortcode.php';


add_action( 'wp_enqueue_scripts', function()
{
	wp_enqueue_style( 'wpinstagram', plugins_url('assets/css/wpinstagram.css', __FILE__ ) , array() , WPINSTAGRAM_VERSION  );
});


add_action( 'widgets_init', function()
{
     register_widget( 'WPInstagramImagesWidget' );
});