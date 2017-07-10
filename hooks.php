<?php
/*=======================================================\
|                        FrontHrm                        |
|--------------------------------------------------------| 
|   Creator: Phương                                      |
|   Date :   09-07-2017                                  |
|   Description: Frontaccounting Payroll & Hrm Module    |
|   Free software under GNU GPL                          |
|                                                        |
\=======================================================*/ 
define ('SS_HRM', 251<<8);

class FrontHrm_app extends application {
	
    function FrontHrm_app() {
        global $path_to_root;
        
        $this->application("FrontHrm", _($this->help_context = "Human Resource"));
        
        $this->add_module(_("Transactions"));
   
        $this->add_module(_("Inquiries and Reports"));
        
        $this->add_module(_("Maintenance"));
		$this->add_lapp_function(2, 'Employees', $path_to_root.'/modules/FrontHrm/manage/employee.php', 'SA_EMPL', MENU_ENTRY);
        $this->add_lapp_function(2, 'Departments', $path_to_root.'/modules/FrontHrm/manage/department.php', 'SA_HRSETUP', MENU_MAINTENANCE);
        
        $this->add_extensions();
    }
}

class hooks_FrontHrm extends hooks {
    var $module_name = 'FrontHrm';
    
    function install_tabs($app) {
        $app->add_application(new FrontHrm_app);
    }
    
    function install_access() {
        $security_sections[SS_HRM] =  _("Human Resource");
        $security_areas['SA_EMPL'] = array(SS_HRM|1, _("Employee entry"));
        $security_areas['SA_HRSETUP'] = array(SS_HRM|1, _("Hrm setup"));
        return array($security_areas, $security_sections);
    }
    
    function activate_extension($company, $check_only=true) {
        global $db_connections;
        
        $updates = array( 'update.sql' => array(''));
 
        return $this->update_databases($company, $updates, $check_only);
    }
	
    function deactivate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array('remove.sql' => array(''));

        return $this->update_databases($company, $updates, $check_only);
    }
}
