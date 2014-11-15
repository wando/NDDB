<?php
class FormExHelper extends MvcFormHelper {
    public function edit_link($controller, $object) {
        return '<a href="'.MvcRouter::admin_url(array('object' => $object, 'action' => 'edit')).'" title="Edit">Edit</a>'; 
				//'<a href="' . mvc_public_url(array('object' => $object)) . '" title="View">View</a>';
    }
	
	public function edit_delete_link($controller, $object) {
        return '<a href="'.MvcRouter::admin_url(array('object' => $object, 'action' => 'edit')).'" title="Edit">Edit</a> | '. 
				'<!--a href="' . mvc_public_url(array('object' => $object)) . '" title="View">View</a> | -->' .
				'<a href="'.MvcRouter::admin_url(array('object' => $object, 'action' => 'delete')).'" title="Delete" class="action-delete">Delete</a>';
    }
    
    public function getQueryVars() {
        parse_str($_SERVER['QUERY_STRING'], $get_array);
        return $get_array;
    }
    
    public function getURLWithQueryVars($query_arr) {
        parse_str($_SERVER['QUERY_STRING'], $get_array);
        foreach ($query_arr as $key => $val) {
            $get_array[$key] = $val;
        }
        return http_build_query($get_array);
    }
}
