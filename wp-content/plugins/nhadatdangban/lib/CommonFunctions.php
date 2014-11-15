<?php
/*
 * Common Functions
 * Author: Quang Do (quangdh81@gmail.com) 
*/

/* function get datetime by timezone */
function getDateTime($format, $timezone = 7) {
	return date($format, time() + 3600*($timezone+date("0")));
}

/* function check user is admin */
function isUserAdmin() {
	global $current_user;
	get_currentuserinfo();
	return ($current_user->ID == 1);
}

/* function export data from db to csv */
function exportCSVFromDB($table, $fileName, $map_fields=null, $append=false) {
    global $wpdb;

    if($file = fopen($fileName, ($append)?'ab+':'wb+')){
        //exec lock file
        if (!flock($file, LOCK_EX|LOCK_NB, $blocked)) {
            if ($blocked) {
                //blocked by other
                return -2;
            } else {
                // couldn't lock
                return -3;
            }
        } else {
            $fields = array();
            $new_fields = array();
            if ($map_fields) {
                foreach ($map_fields as $key => $val) {
                    $fields[] = $key;
                    $new_fields[] = $val;
                }
            } else {
                $fields = array('*');
            }
            
            //export data from db
            $results = exportFromDB($table, $fields);
            
            if (!count($new_fields)) {
                $new_fields = array_keys(reset($results));
            }
            
            //write fields
            _fputcsv($file, $new_fields, ',', '"', false, false);
            
            //write data
            $lineCnt = 0;
            foreach ($results as $result) {
                $lineCnt += 1;
                $content = '';
                _fputcsv($file, $result, ',', '"', true, false);
            }
            
            flock($file, LOCK_UN);
            return $lineCnt;
        }
        fclose($file);
    } else {
        return -1;
    }
}

/* function to import employee to db from CSV file */
function importDBFromCSV($fileName, $table, $map_fields=null, $empty_table_before=false) {
    global $wpdb;
    if(file_exists($fileName)) {
        $file = fopen($fileName, 'r');
        
        //exec lock file
        if (!flock($file, LOCK_EX|LOCK_NB, $blocked)) {
            if ($blocked) {
                //blocked by other
                return -2;
            } else {
                // couldn't lock
                return -3;
            }
        } else {
            //after lock, import to db
            $lineCnt = 0;
            $wpdb->query('START TRANSACTION');

            while (($cells = fgetcsv($file, 1000, ",", '"')) !== FALSE) {
                $lineCnt += 1;
                if ($lineCnt == 1) {
                    $fields = $cells;
                    if ($map_fields) {
                        if (count($fields) != count($map_fields)) {
                            //can't map fields
                            return -4;
                        }
                        for ($i=0;$i<count($fields);$i++ ) {
                            if (isset($map_fields[$fields[$i]])) {
                                $fields[$i] = $map_fields[$fields[$i]];
                            } else {
                                $wpdb->query('ROLLBACK');
                                //can't map fields
                                return -4;
                            }
                        }
                        if ($empty_table_before) $wpdb->query('DELETE FROM ' . $table);
                    }
                } else {
                    if (importToDB($table, $fields, $cells) === FALSE) {
                        $wpdb->query('ROLLBACK');
                        //can't import to db
                        return -5;
                    }
                }
            }
            $wpdb->query('COMMIT'); // if you come here then well done
            flock($file, LOCK_UN);
            return $lineCnt-1;
        }
        fclose($file);
    } else {
        //file not exists
        return -1;
    }
}

/* function export from db */
function exportFromDB($table, $fields, $where=1) {
    global $wpdb;
    
    $sql = "SELECT " . join(',', $fields) . " FROM " . $table . " WHERE " . $where;
    $results = $wpdb->get_results($sql, ARRAY_A) or die(mysql_error());
    
    return $results;
}

/* function import to db */
function importToDB($table, $fields, $data) {
    global $wpdb;
    
    $arr_data = array_combine($fields, $data);

    if ($wpdb->insert($table, $arr_data) === FALSE) {
        return false;
    }
    return true;
}

/* rewrite fputcsv */
function _fputcsv($handle, $fields, $delimiter=',', $enclosure='"', $break_line_before=false, $break_line_after=true) {
    $str='';
    foreach ($fields as $cell) {
        $cell = str_replace($enclosure, $enclosure.$enclosure, $cell);
        if (strchr($cell, $delimiter) !== FALSE || strchr($cell, $enclosure) !== FALSE || strchr($cell, "\n") !== FALSE) {
            $str .= $enclosure . $cell . $enclosure . $delimiter;
        } else {
            $str .= $cell . $delimiter;
        }
    }
    fputs($handle, ($break_line_before?"\r\n":"") . substr($str, 0, -1) . ($break_line_after?"\r\n":""));
    return strlen($str);
}