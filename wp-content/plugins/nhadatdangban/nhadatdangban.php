<?php
/*
Plugin Name: Trang rao vat nha dat www.nhadatdangban.com
Plugin URI: 
Description: 
Author: Quang Do (quangdh81@gmail.com)
Version: 
Author URI: 
*/

define('nhadatdangban_PLUGIN_NAME', 'nhadatdangban');

if (!defined('nhadatdangban_PLUGIN_PATH'))
    define('nhadatdangban_PLUGIN_PATH', dirname(__FILE__) . '/');

if (!defined('nhadatdangban_LIB_PATH'))
    define('nhadatdangban_LIB_PATH', nhadatdangban_PLUGIN_PATH . 'lib/');

register_activation_hook(__FILE__, 'nhadatdangban_activate');
register_deactivation_hook(__FILE__, 'nhadatdangban_deactivate');

function nhadatdangban_activate() {
	require_once dirname(__FILE__).'/nhadatdangban_loader.php';
	$loader = new nhadatdangbanLoader();
	$loader->activate();
}

function nhadatdangban_deactivate() {
	require_once dirname(__FILE__).'/nhadatdangban_loader.php';
	$loader = new nhadatdangbanLoader();
	$loader->deactivate();
}

?>