<?php
/* ExecutesController class
 * Controller for module Projects
*/
class ExecuteController extends MvcPublicController {
    
    public function importCSV() {
        //importDBFromCSV($fileName, $table, $map_fields=null, $empty_table_before=false)
        echo 'Import employees: ' . importDBFromCSV(   "/var/www/html/ocs/csv_files/exportEmployees.csv", 
                                'employees', 
                                array(  'EmployeeID'=>'employee_id',
                                        'EmployeeName'=>'employee_name',
                                        'PIN'=>'pin'
                                    ),
                                true
                            );
                            
        echo "\n<BR />Import buildings: " . importDBFromCSV(   "/var/www/html/ocs/csv_files/exportBuildings.csv", 
                                'buildings', 
                                array(  'Contract No.'=>'contract_no',
                                        'Contract Name'=>'contract_name',
                                        'Number'=>'number'
                                    ),
                                true
                            );
        $this->render_view('execute', array('layout' => 'ajax_layout'));
    }
    
    public function exportCSV() {
        //exportCSVFromDB($table, $fileName, $map_fields=null, $append=false)
        echo 'Export Employees: ' . exportCSVFromDB(   'employees',
                                '/var/www/html/ocs/csv_files/exportEmployees.csv',
                                array(  'employee_id'=>'EmployeeID',
                                        'employee_name'=>'EmployeeName',
                                        'pin'=>'PIN'));

        echo "\n<br />Export Buildings: " . exportCSVFromDB(   'buildings',
                                '/var/www/html/ocs/csv_files/exportBuildings.csv',
                                array(  'contract_no'=>'Contract No.',
                                        'contract_name'=>'Contract Name',
                                        'number'=>'Number'));
                                        
        $this->render_view('execute', array('layout' => 'ajax_layout'));
    }
    
    public function exportCallLog() {
        echo 'Export Call Log: ' . exportCSVFromDB(   'call_logs',
                                '/var/www/html/ocs/csv_files/exportCallLog.csv',
                                array(  'employee_id'=>'Employee ID',
                                        'calldate'=>'Call Date',
                                        'src'=>'Source',
                                        'dst'=>'Destination',
                                        'request'=>'Request',
                                        'disposition'=>'Disposition',
                                        'uniqueid'=>'Unique ID',
                                        'contract_id'=>'Contract No.',
                                        'number'=>'Number'));

        $this->render_view('execute', array('layout' => 'ajax_layout'));
    }
}