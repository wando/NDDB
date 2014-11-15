<?php
/*
 * Customize Backend
 * Author: Quang Do (quangdh81@gmail.com) 
*/
define('INSTALL_THEME_TAB', 'install_themes');

//remove admin bar buttons
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-media');
    $wp_admin_bar->remove_menu('new-link');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('site-name');
    $wp_admin_bar->add_menu(array(
        'parent' => false,
        'title' => get_bloginfo('name'),
        'href' => get_bloginfo('url'),
        'meta' => "")
    );
}

add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');

//Change footer content
function wpse_edit_footer() {
    add_filter('admin_footer_text', 'wpse_edit_text', 11);
    add_filter('update_footer', 'change_footer_version', 9999);
}

function change_footer_version() {
    return ' ';
}

function wpse_edit_text($content) {
    return ' ';
}

add_action('admin_init', 'wpse_edit_footer');

//remove contextual help tab
function remove_contextual_help() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
    //$screen->render_screen_options(false);
}

add_action('admin_head', 'remove_contextual_help');

//change admin title of site
add_filter('admin_title', 'my_admin_title', 10, 2);

function my_admin_title($admin_title, $title) {
    return $title . ' &lsaquo; ' . get_bloginfo('name');
}

// hide 'Screen Options' tab
function remove_screen_options() {
    return false;
}

add_filter('screen_options_show_screen', 'remove_screen_options');

// list active dashboard widgets
function list_active_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

add_action('wp_dashboard_setup', 'list_active_dashboard_widgets');

//dismiss welcome on dashboard
add_action('load-index.php', 'hide_welcome_panel');

function hide_welcome_panel() {
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'show_welcome_panel', 0);
}

//set default page for admin
function admin_default_page() {
    return 'wp-admin';
}

add_filter('login_redirect', 'admin_default_page');

//dashboard
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', get_bloginfo('name'), 'custom_dashboard_help');
}

function custom_dashboard_help() {
	$dashboard_text = str_replace(	array('{SITE_NAME}', '{SITE_URL}', '{SUPPORT_EMAIL}'), 
									array(get_bloginfo('name'), get_bloginfo('url'), SUPPORT_EMAIL),
									DASHBOARD_TEXT);
    echo $dashboard_text;
}

//remove widgets
function my_widgets_init() {
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Search');
}

add_action('widgets_init', 'my_widgets_init');

//disable install themes tab
function block_caps($caps, $cap) {
    if ($cap === INSTALL_THEME_TAB)
        $caps[] = 'do_not_allow';
    return $caps;
}
add_filter('map_meta_cap', 'block_caps', 10, 2);

//remove personal options in profile
remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');