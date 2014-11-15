<?php
//add rules
add_action('init', 'add_my_rule');
function add_my_rule() {
	global $wp;
	$wp->add_query_var('args');
    //add_rewrite_rule('action\/([^/]*)', 'index.php?pagename=action&action_name=$matches[1]', 'top');
}

