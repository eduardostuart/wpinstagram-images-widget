<?php
/**
 * Plugin Name: WP Instagram Images Widget
 * Plugin URI: http://eduardostuart.com.br/
 * Description: Instagram Images Widget get your most recent activity at Instagram and display them in a Widget.
 * Version: 1.0
 * Author: Eduardo Stuart
 * Author URI: http://eduardostuart.com.br
 * Tested up to: 3.5
 *
 * Text Domain: wpinstagramimageswidget
 * Domain Path: /i18n/languages/
 */


define('WPINSTAGRAM_TXT_DOMAIN'     , 'wpinstagramimageswidget');
define('WPINSTAGRAM_PATH_BASE'      , dirname(__FILE__) . DIRECTORY_SEPARATOR );
define('WPINSTAGRAM_PATH_TEMPLATE'  , WPINSTAGRAM_PATH_BASE . 'templates/');
define('WPINSTAGRAM_PATH_CLASS'     , WPINSTAGRAM_PATH_BASE . 'class/');
define('WPINSTAGRAM_PATH_INC'       , WPINSTAGRAM_PATH_BASE . 'inc/');
define('WPINSTAGRAM_WP_VERSION'     , get_bloginfo('version'));
define('WPINSTAGRAM_WP_MIN_VERSION' , 3.5);



load_plugin_textdomain(WPINSTAGRAM_TXT_DOMAIN, FALSE, 'i18n/languages');


function _wpinstagram_template( $template , $params = array() ){

	$filename = WPINSTAGRAM_PATH_TEMPLATE . $template . '.php';

	if(file_exists( $filename )){

		foreach( $params as $k=>$v ){
			$$k = $v;
		}

		include $filename;

	}else{
		echo __( sprintf('Template not found<br>%s' , $filename), WPINSTAGRAM_TXT_DOMAIN );
	}
}

require_once WPINSTAGRAM_PATH_INC   . 'simple_html_dom.php';
require_once WPINSTAGRAM_PATH_CLASS . 'InstagramCrawler.php';
require_once WPINSTAGRAM_PATH_INC   . 'functions.php';
require_once WPINSTAGRAM_PATH_CLASS . 'WPInstagramImagesWidget.php';




// intialize WPInstagramImagesWidget widget
add_action( 'widgets_init', function(){
     register_widget( 'WPInstagramImagesWidget' );
});