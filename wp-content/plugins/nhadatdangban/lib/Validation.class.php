<?PHP

/**
 * @version: 1.0
 * @create: 2012/06/28
 * @author: Quang Do (quangdh81@gmail.com) 
 */
class Validation {

    var $arrayRules = array();
    var $errorMessages = array();
    var $errorsMsg = array();
    var $ruleclass = "ValidateRule";
	
    /**
     * Construction for Validation class
     */
    public function Validation() {
        $this->errorMessages = ValidateRule::getDefaultErrorMessage();
    }

    /**
     * Set instance class rule for validate
     * @param string $classname
     */
    public function setRuleClassInstance($classname) {
        $this->ruleclass = $classname;
    }

    /**
     * Define custom error message
     * @param string $rulename
     * @param string $message
     */
    public function defineErrorMessage($rulename, $message) {
        $this->errorMessages[$rulename] = $message;
    }

    /**
     * Get error messages after validate
     * @return array errors
     */
    public function getErrorMessages() {
        return $this->errorsMsg;
    }

    /**
     * Set rule validate for input field
     * @param string $valFormObj
     * @param string $nameFormObj
     * @param string $rules (split by |)
     */
    public function setRules($valFormObj, $nameFormObj, $rules, $divclass = '', $fieldName = '') {
        $this->arrayRules[] = array("value" => $valFormObj, "name" => $nameFormObj, "rules" => $rules, "divclass" => $divclass, "fieldName" => $fieldName);
    }

    /**
     * Get Function proccess validate for rule
     * @param string $rule
     * @return string name of function
     */
    private function getFunctionName($rule) {
        $s_tmp = strstr($rule, "[", true);
        return ($s_tmp == "") ? $rule : $s_tmp;
    }

    /**
     * Get parameters for rule
     * @param string $rule
     * @return array prarameters
     */
    private function getParameters($rule) {
        $s_tmp = strstr($rule, "[");
        return ($s_tmp != "") ? explode(",", substr($s_tmp, 1, strlen($s_tmp) - 2)) : null;
    }

    /**
     * Check validate
     * @return boolean result validate
     */
    public function checkValidate() {
        $return = false;
        $result = true;

        foreach ($this->arrayRules as $ruleObj) {
            $arr_rule = @explode("|", $ruleObj["rules"]);
            //  print_r($ruleObj);
            for ($i = 0; $i < count($arr_rule); $i++) {
                $rule_func_name = ucwords($this->getFunctionName($arr_rule[$i]));
                $rule_func_params = $this->getParameters($arr_rule[$i]);

                if (method_exists($this->ruleclass, "check" . $rule_func_name)) {
                    $callback_params = array($ruleObj['value']);
                    if ($rule_func_params != null) {
                        $callback_params = array_merge($callback_params, $rule_func_params);
                    }

                    $return = call_user_func_array($this->ruleclass . "::check" . $rule_func_name, $callback_params);
                    if ($return == false) {
                        $strerr = str_replace("%s", $ruleObj['name'], $this->errorMessages[$this->getFunctionName($arr_rule[$i])]);
                        for ($paramCnt = 0; $paramCnt < count($rule_func_params); $paramCnt++) {
                            $strerr = str_replace("%" . ($paramCnt + 1), $rule_func_params[$paramCnt], $strerr);
                        }
                        //check if have divclass set in rules - Khuong Dang
                        if ($ruleObj['divclass'] && $ruleObj["fieldName"]=='') {
                            //add rule after name
                            $this->errorsMsg[$ruleObj['name'] . '|' . $ruleObj['divclass']] = $strerr;
                        } else {
                            $this->errorsMsg[$ruleObj['name']] = $strerr;
                        }
                        
                        // show field  name in errors message - DatNguyen
                        if ($ruleObj["fieldName"] !='' && $ruleObj['divclass']=='') {
                            $this->errorsMsg[$ruleObj['fieldName']] = $strerr;
                        } else {
                            $this->errorsMsg[$ruleObj['name']] = $strerr;
                        }
                        
                        $result = false;
                        break;
                    }
                } else {
                    $this->errorsMsg = array("Internal error! Please check again!");
                    return false;
                }
            }
        }

        return $result;
    }

}
