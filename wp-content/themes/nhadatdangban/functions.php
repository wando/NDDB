<?php
/**
 * Bodog functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 * @package WordPress
 * @subpackage nhadatdangban
 * @since Bao Uyen Shop
 */
require_once get_template_directory() . "/config/contants.php";
require_once get_template_directory() . "/config/routes.php";
require_once get_template_directory() . "/inc/common.php";
 
//update_option('siteurl', WP_SITEURL);
//update_option('home', WP_HOME);


/**
 * Tell WordPress to run freshzone_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'nhadatdangban_setup' );

if ( ! function_exists( 'nhadatdangban_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override freshzone_setup() in a child theme, add your own freshzone_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 * 	and backgrounds, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Bao Uyen Shop
 */
function nhadatdangban_setup() {

	/* Make Bodog available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Bodog, use a find and replace
	 * to change 'freshzone' to the name of your theme in all the template files.
	 */
	//load_theme_textdomain( 'freshzone', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	// add_editor_style();

	// Load up our theme options page and related code.
	//require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Bodog's Ephemera widget.
	//require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	//add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	//register_nav_menu( 'primary'		, __( 'Primary Menu', 'main_menu' ) );
	

	// Add support for a variety of post formats
	//add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

}
endif;

function disableAutoSave(){
    wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disableAutoSave' );
update_option('upload_url_path', '/wp-content/uploads');

add_filter('show_admin_bar', '__return_false');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wp_generator');

function bp_remove_gravatar ($image, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir) {

	$default = get_stylesheet_directory_uri() .'/images/avatar.png';

	if( $image && strpos( $image, "gravatar.com" ) ){ 

		return '<img src="' . $default . '" alt="avatar" class="avatar" ' . $html_width . $html_height . ' />';
	} else {
		return $image;

	}

}
add_filter('bp_core_fetch_avatar', 'bp_remove_gravatar', 1, 9 );

function remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {

	$default = get_stylesheet_directory_uri() .'/images/avatar.png';
	return ""; //"<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}

add_filter('get_avatar', 'remove_gravatar', 1, 5);

function bp_remove_signup_gravatar ($image) {

	$default = get_stylesheet_directory_uri() .'/images/avatar.png';

	if( $image && strpos( $image, "gravatar.com" ) ){ 

		return '<img src="' . $default . '" alt="avatar" class="avatar" width="60" height="60" />';
	} else {
		return $image;
	}

}
add_filter('bp_get_signup_avatar', 'bp_remove_signup_gravatar', 1, 1 );