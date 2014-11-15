<?PHP
/* ValidateRule
 * @version: 1.0
 * @create: 2012/06/28
 * @author: Quang Do (quangdh81@gmail.com) 
 */

class ValidateRule {

    /**
     * Return array messages will show for errors from validate
     */
    public static function getDefaultErrorMessage() {
        $errorMessages = array();
        $errorMessages["required"] = defined("VALIDATE_MSG_REQUIRED") ? VALIDATE_MSG_REQUIRED : "%s must not be left blank";
        $errorMessages["email"] = defined("VALIDATE_MSG_EMAIL") ? VALIDATE_MSG_EMAIL : "%s is not valid";
        $errorMessages["url"] = defined("VALIDATE_MSG_URL") ? VALIDATE_MSG_EMAIL : "%s not is a valid URL";
        $errorMessages["alphanumeric"] = defined("VALIDATE_MSG_ALPHANUMERIC") ? VALIDATE_MSG_ALPHANUMERIC : "%s must is alpha numeric";
        $errorMessages["number_chars"] = defined("VALIDATE_MSG_NUMBER_CHARS") ? VALIDATE_MSG_NUMBER_CHARS : "%s must is numeric characters";
        $errorMessages["numeric"] = defined("VALIDATE_MSG_NUMERIC") ? VALIDATE_MSG_NUMERIC : "%s must is numeric";
        $errorMessages["max_lenght"] = defined("VALIDATE_MSG_MAX_LENGHT") ? VALIDATE_MSG_MAX_LENGHT : "%s must have max lenght is %1";
        $errorMessages["min_lenght"] = defined("VALIDATE_MSG_MIN_LENGHT") ? VALIDATE_MSG_MIN_LENGHT : "%s must have min lenght is %1";
        $errorMessages["exact_lenght"] = defined("VALIDATE_MSG_EXACT_LENGHT") ? VALIDATE_MSG_EXACT_LENGHT : "%s must have exactly lenght is %1";
        $errorMessages["inspace"] = defined("VALIDATE_MSG_INSPACE") ? VALIDATE_MSG_INSPACE : "%s must have minlenght is %1 and maxlenght is %2";
        $errorMessages["less_than"] = defined("VALIDATE_MSG_LESS_THAN") ? VALIDATE_MSG_LESS_THAN : "%s must less than %1";
        $errorMessages["greater_than"] = defined("VALIDATE_MSG_GREATER_THAN") ? VALIDATE_MSG_GREATER_THAN : "%s must greater than %1";
        $errorMessages["matches"] = defined("VALIDATE_MSG_MATCHES") ? VALIDATE_MSG_MATCHES : "%s not matches";
        $errorMessages["integer"] = defined("VALIDATE_MSG_INTEGER") ? VALIDATE_MSG_INTEGER : "%s must be integer";
        $errorMessages["decimal"] = defined("VALIDATE_MSG_DECIMAL") ? VALIDATE_MSG_DECIMAL : "%s must be decimal";
        $errorMessages["match_extensions"] = defined("VALIDATE_MSG_MATCH_EXTENSIONS") ? VALIDATE_MSG_MATCH_EXTENSIONS : "%s must have extension match with (%1)";
        $errorMessages["match_size_img"] = defined("VALIDATE_MSG_MATCH_SIZE_IMG") ? VALIDATE_MSG_MATCH_SIZE_IMG : "%s must have size match with (%1 x %2)";        
        
        return $errorMessages;
    }

    /**
     * Check field must not blank
     * @param string $value
     * @return boolean
     */
    public static function checkRequired($value) {
        return !(trim($value) == "");
    }

    /**
     * Check input must is email format
     * @param string $email
     * @return boolean
     */
    public static function checkEmail($email) {
        if (empty($email)) return true;
        if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Check input must is URL format
     * @param string $url
     * @return boolean
     */
    public static function checkURL($url) {
        if (empty($url)) return true;
        if (!preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $url)) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Check input field must alpha or numeric
     * @param string $value
     * @return boolean
     */
    public static function checkAlphanumeric($value) {
        if(empty($value)) return true;
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }
    
    /**
     * Check input field must alpha or numeric
     * @param string $value
     * @return boolean
     */
    public static function checkNumber_chars($value) {
        if(empty($value)) return true;
        return preg_match("/^[0-9]+$/", $value);
    }

    /**
     * Check field must is numeric
     * @param $value
     * @return boolean
     */
    public static function checkNumeric($value) {
        if(empty($value)) return true;
        return (is_numeric($value));
    }

    /**
     * Check max lenght for input field
     * @param string $value
     * @param int $maxlenght
     * @return boolean
     */
    public static function checkMax_lenght($value, $maxlenght) {
        if(empty($value)) return true;
        return strlen($value) <= $maxlenght;
    }

    /**
     * Check min lenght for input field
     * @param string $value
     * @param int $minlenght
     * @return boolean
     */
    public static function checkMin_lenght($value, $minlenght) {
        if(empty($value)) return true;
        return strlen($value) >= $minlenght;
    }

    /**
     * Check exact lenght for input field
     * @param string $value
     * @param int $lenght
     * @return boolean
     */
    public static function checkExact_lenght($value, $lenght) {
        if(empty($value)) return true;
        return strlen($value) == $lenght;
    }

    /**
     * Check min lenght & maxlenght for input field
     * @param string $value
     * @param int $minlenght
     * @param int $maxlenght
     * @return boolean
     */
    public static function checkInSpace($value, $minlenght, $maxlenght) {
        if(empty($value)) return true;
        return (strlen($value) > $minlenght && strlen($value) < $maxlenght);
    }

    /**
     * Check less than for input field
     * @param string $value
     * @param int $maxlenght
     * @return boolean
     */
    public static function checkLess_than($value, $maxvalue) {
        if(empty($value)) return true;
        return ($value < $maxvalue);
    }

    /**
     * Check greater than for input field
     * @param string $value
     * @param int $minvalue
     * @return boolean
     */
    public static function checkGreater_than($value, $minvalue) {
        if(empty($value)) return true;
        return ($value > $minvalue);
    }

    /**
     * Check input field matches with other value
     * @param string $value1
     * @param string $value2
     * @return boolean
     */
    public static function checkMatches($value1, $value2) {
        if(empty($value1) || empty($value2)) return true;
        return ($value1 == $value2);
    }
    
    public static function checkDatevalid($year, $month,$day) {    
         if (empty($month)||empty($year)||empty($day) ) {
             return true;
         }        
         return (checkdate($month, $day, $year)!==false);              
    }

    /**
     * Check input field must integer
     * @param int $value
     * @return boolean
     */
    public static function checkInteger($value) {
        if(empty($value)) return true;
        return is_int($value);
    }

    /**
     * Check input field must decimal
     * @param $value
     * @return boolean
     */
    public static function checkDecimal($value) {
        if(empty($value)) return true;
        return is_float($value);
    }

    /**
     * Check input field must have extension valid
     * @param string $value
     * @param string $exts (split by ;)
     * @return boolean
     */
    public static function checkMatch_Extensions($value, $exts) {
        if(empty($value)) return true;
        foreach (explode(";", str_replace("*.", "", $exts)) as $ext) {
            if (strtolower(substr($value, strlen($value) - strlen($ext) - 1)) == "." . strtolower($ext)) {
                return true;
            }
        }
        return empty($value);
    }

    public static function checkMatch_Size_Img($value, $width, $height) {
        if(empty($value)) return true;
        $size = getimagesize($value);
        if ($size[0] == intval($width) && $size[1] == intval($height))
            return true;
    }

}
