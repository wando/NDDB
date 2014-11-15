<?php
/*
 * Backend Menu
 * Author: Quang Do (quangdh81@gmail.com) 
*/
require_once(ABSPATH . WPINC . '/pluggable.php');
global $current_user;
get_currentuserinfo();
$positions = array();

$positions = array(
            'dashboard' => 0,
            'lookups' => 1,
        );

if ($current_user->ID == 1) {
    $positions['users'] = 2;
}
        
//config menu
MvcConfiguration::append(array(
    'AdminPages' => array(
        'positions' => $positions,
        'icons' => array(
            'lookups' => plugins_url(nhadatdangban_PLUGIN_NAME . '/app/public/images/lookups.png'),
        ),
    )
));


//customize menus admin
function customize_menus() {
    $tmp_menu = array();
    global $menu;
    global $submenu;
    $admin_pages = MvcConfiguration::get('AdminPages');        
    foreach ($menu as $key => $menu_item) {
        if (isset($admin_pages["icons"][strtolower($menu_item[0])])) {
            $menu_item[4] = str_replace(" menu-icon-generic", "", $menu[$key][4]);
            $menu_item[6] = $admin_pages["icons"][strtolower($menu[$key][0])];
        }
        if (isset($admin_pages["positions"][strtolower($menu_item[0])])) {
            $menu_obj = strtolower($menu_item[0]);
            $position = $admin_pages["positions"][strtolower($menu_item[0])];
            if (isset($admin_pages["titles"][strtolower($menu_item[0])])) {
                $title = $admin_pages["titles"][strtolower($menu[$key][0])];
                $menu_item[0] = $title;
                $submenu['mvc_' . $menu_obj][0][0] = $title;
                if (isset($admin_pages['add_new_title'])) $submenu['mvc_' . $menu_obj][1][0] = $admin_pages['add_new_title'];
            }
            $tmp_menu[$position] = $menu_item;
        }
    }
    $menu = $tmp_menu;
    
    remove_submenu_page('themes.php', 'widgets.php');
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('index.php', 'update-core.php');
    remove_submenu_page('options-general.php','options-writing.php');
    remove_submenu_page('options-general.php','options-reading.php');
    remove_submenu_page('options-general.php','options-discussion.php');
    remove_submenu_page('options-general.php','options-permalink.php');
}

add_action('admin_menu', 'customize_menus', 999);