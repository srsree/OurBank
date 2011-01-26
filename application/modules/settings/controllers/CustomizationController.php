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
class settings_CustomizationController extends Zend_Controller_Action {

    function init()
    {		

    }


    function indexAction()
    { 
        if($this->_request->getPost('submit')) {
            $feild1 = $this->_request->getPost('feild1');
            $feild2 = $this->_request->getPost('feild2');
            $feild3 = $this->_request->getPost('feild3');
            $feild4 = $this->_request->getPost('feild4');
            $feild5 = $this->_request->getPost('feild5');
            $feild6 = $this->_request->getPost('feild6');
            $feild7 = $this->_request->getPost('feild7'); 
            $feild8 = $this->_request->getPost('feild8');
            $feild9 = $this->_request->getPost('feild9');

            $customization = new settings_Model_Customization();

            $tableName = $customization->getSubmodule($feild8);
            foreach ($tableName as $tableName1) {
                $tNmae = "ourbank_".$tableName1->submodule_description."_extended";
            }

             $form_id = $customization->insert(array('module_id' => $feild7,
                                          'submodule_id' => $feild8,
                                          'feild_name' => $feild1,
                                          'display_name' => $feild2,
                                          'legend_id' => 1,
                                          'feild_type' => $feild3,
                                          'table_name' => $feild9,
                                          'data_type' => $feild4,
                                          'mandatory' => $feild5,
                                          'display' => $feild5),"ourbank_customizingform");

            $feildDetails = $customization->gettableDetails($form_id);

            foreach($feildDetails as $feildDetails) {
                $feild_name = $feildDetails->feild_name;
                $data_type = $feildDetails->data_type;
            }
            foreach ($tableName as $tableName1) {
                $customization->createTable($tNmae,$feild_name,$data_type,$tableName1->submodule_description."_extended");
            }

            $this->_redirect('settings/customization'); 
        }

    } 
}


