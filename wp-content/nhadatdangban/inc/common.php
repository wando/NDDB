<?php
/**
 * Get variable from model
 * @param string $name
 * @return string value of variable by name
 */
function getVariable($name = '') {
    $model = new Variable();
    $variable = $model->find_one(array('conditions' => array('name' => $name)));
    return (!empty($variable)) ? $variable->value : "";
}

/**
 * Get short content
 * @param string $text
 * @param int $limit
 * @return string
 */
function getShortContent($str, $limit, $ending = "...") {
    if (strlen($str) <= $limit) {
        return $str;
    } else {
        if (strpos($str, " ", $limit) > $limit) {
            $new_limit = strpos($str, " ", $limit);
            $new_str = mb_substr($str, 0, $new_limit, 'UTF-8') . $ending;
            return $new_str;
        }
        $new_str = mb_substr($str, 0, $limit, 'UTF-8') . "...";
        return $new_str;
    }
}

function objectToArray($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}