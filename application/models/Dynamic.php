<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class App_Model_Dynamic extends Zend_Db_Table
 {
    protected $_name="ob_gender";

    public function dynamicaction() {
        $act = new App_Model_Users();
        $module = array('institution',
                        'bank',
                        'roles',
                        'user',
                        'funderdetails',
                        'fundings',
                        'fee',
                        'sectors',
                        'activity');
        $m=0;$j=0;
        $lableName = array( "Index","Add Institution","Edit Institution","View Institution","Delete Institution",
                            "Index","Add Bank","Edit Bank","View Bank","Delete Bank",
                            "Index","Add Roles","Edit Roles","View Roles","Delete Roles",
                            "Index","Add User","Edit User","View User","Delete user",
                            "Index","Add Funder","Edit Funder","View Funder","Delete Funder",
                            "Index","Add Fundings","Edit Fundings","View Fundings","Delete Fundings",
                            "Index","Add Fee","Edit Fee","View Fee","Delete Fee",
                            "Index","Add Sector","Edit Sector","View Sector","Delete Sector",
                            "Index","Add Activity","Edit Activity","View Activity","Delete Activity");

        $act = new App_Model_Users();

        $acivitycount = count($act->getActivity());
        if ($acivitycount!=36) {
            foreach($module as $module) {
                $m++;
                $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/'.$module.'/controllers/');

                $ActionNames = $test->getActionNames();
                foreach ($ActionNames as $key => $value) {

                    if ($key!= $module."_IndexController") {
                        $i=0; 
                        foreach($value as $name) {
                            
                            if ($i!=0) {

//                                 substr($name, 0, -6)
                                $n2 = $act->insertAct(array('activity_name' => $lableName[$j],
                                                            'activity_description' => $name,
                                                            'recordstatus_id' => 3,
                                                            'module_id' => 1,
                                                            'submodule_id' => $m));
                            }
                            $i++; $j++;
                        }
                    }
	        }
            } 
        } 

  
 }
}


