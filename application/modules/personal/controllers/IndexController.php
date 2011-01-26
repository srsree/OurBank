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
class Personal_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='Personal Details';
        $sessionName = new Zend_Session_Namespace('Personal Details');
        $this->view->createdby = $sessionName->primaryuserid;
    }

    public function indexAction() {
        $personal=new Personal_Form_personal();
        $this->view->form=$personal;
            $model=new Personal_Model_personal();
            $maritalStatus = $model->getMaritalStatus();
            foreach($maritalStatus as $maritalStatus) {
                    $personal->membermaritalstatus_id->addMultiOption($maritalStatus->membermaritalstatus_id,$maritalStatus->membermaritalstatusdescription);
            }
    
            $physicalStatus = $model->getPhysicalStatus();
            foreach($physicalStatus as $physicalStatus) {
                $personal->physicalstatus_id->addMultiOption($physicalStatus->memberphysicalstatus_id,$physicalStatus->memberphysicalstatusdescription);
            }
	
    }



}
