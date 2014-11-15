<?php
/*
 * Bootstrap
 * Author: Quang Do (quangdh81@gmail.com) 
*/
require_once "contants.php";
require_once nhadatdangban_LIB_PATH . "CommonFunctions.php";
require_once nhadatdangban_LIB_PATH . "nhadatdangbanModel.class.php";
require_once nhadatdangban_LIB_PATH . "Validation.class.php";
require_once nhadatdangban_LIB_PATH . "ValidateRule.class.php";

// $tmpl = new patTemplate();
// $tmpl->setRoot(nhadatdangban_PLUGIN_PATH . '/app/views/templates/');

//for customize left menu for backend
require_once "backend_menu.php";

//for hack layout backend only show menus need
require_once "customize_backend.php";


//set debug or not
MvcConfiguration::set(array(
    'Debug' => false
));

//require js for backend
function my_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', mvc_js_url(nhadatdangban_PLUGIN_NAME, 'admin_custom.js'), array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
}

function my_admin_styles() {
    wp_enqueue_style('thickbox');
}

if ($GLOBALS['pagenow'] == 'wp-login.php') {
    add_action( 'login_enqueue_scripts', 'my_admin_scripts' );
}

if (is_admin()) {
    add_action('admin_print_scripts', 'my_admin_scripts');
    add_action('admin_print_styles', 'my_admin_styles');
}
//end: require js for backend

add_action('admin_enqueue_scripts', 'add_stylesheet_to_admin');
function add_stylesheet_to_admin() {
    wp_enqueue_style( 'prefix-style', mvc_css_url(nhadatdangban_PLUGIN_NAME, 'admin_custom.css') );
    if (in_array($GLOBALS['pagenow'], array('user-edit.php', 'user-new.php', 'users.php', 'profile.php'))) {
        wp_enqueue_style( 'user-style', mvc_css_url(nhadatdangban_PLUGIN_NAME, 'style-' . str_replace('.php', '.css', $GLOBALS['pagenow'])) );
    }
}

//require css for backend
function prefix_hide_personal_options() {
    add_editor_style('admin_custom.css');
}
add_action('personal_options', 'prefix_hide_personal_options');
//end: require css for backend

//set path for upload media
update_option('upload_url_path', '/wp-content/uploads');

//remove roles not need
remove_role('subscriber');
remove_role('editor');
remove_role('author');
remove_role('contributor');

//hide some columns in users list
function remove_user_columns($column_headers) {
    unset($column_headers['cb']);
    unset($column_headers['posts']);
    unset($column_headers['role']);
    $column_headers['created_date'] = __('Created Date', 'user-column');
    return $column_headers;
}
add_action('manage_users_columns','remove_user_columns');

// set sortable for custom column
function status_column_sortable($columns) {
    $custom = array(
        'created_date'    => 'created_date',
    );
    return wp_parse_args($custom, $columns);
}
add_filter( 'manage_users_sortable_columns', 'status_column_sortable' );


// new custom column
add_action('manage_users_custom_column',  'add_created_date_column', 10, 3);
function add_created_date_column($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
	if ( 'created_date' == $column_name )
		return $user->user_registered;
    return $value;
}

/* Change mail and name of wp_mail*/
function change_wp_mail_from($email){
    return "support@" . str_replace(array('https://', 'http://', 'www.'),array('','',''), get_bloginfo('url'));
}
add_filter("wp_mail_from", "change_wp_mail_from");

function change_wp_mail_from_name($from_name){
    return "nhadatdangban System";
}
add_filter("wp_mail_from_name", "change_wp_mail_from_name");