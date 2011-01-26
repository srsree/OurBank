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
class Commonviewuser_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='User details';
        $sessionName = new Zend_Session_Namespace('ourbank');
	$userid=$this->view->createdby = $sessionName->primaryuserid;
	$login=new App_Model_Users();
	$loginname=$login->username($userid);
	foreach($loginname as $loginname) {
	$this->view->username=$loginname['username'];
}
    }

    public function indexAction() {
$addForm = new Commonviewuser_Form_Feedetails();
                        $this->view->form=$addForm;
$user = new Commonviewuser_Model_User();
        $office = $user->getOffice();
        foreach($office as $office) {
		$addForm->officebranch->addMultiOption($office['Institute_bank_id'],$office['Institute_bank_name']);
	}
  $gender = $user->getGender();
        foreach($gender as $gender) {
		$addForm->gender->addMultiOption($gender->gender_id,$gender->sex);
        }
	$noOfroles= $user->noGrants();
        foreach($noOfroles as $noOfroles1) {
             $addForm->grant_id->addMultiOption($noOfroles1['grant_id'],$noOfroles1['grantname']);
		}
	$designation = $user->getDesignation();
        	foreach($designation as $designation) {
		$addForm->designation->addMultiOption($designation->designation_id,$designation->designation_name);
        }
	if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
 //$uptodate=$this->_getParam('holidayupto');echo "<h1>".$uptodate."</h1>";
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                
                if ($addForm->isValid($formData)) {     
$username= new Commonviewuser_Model_User();
$dbAdapter = Zend_Db_Table::getDefaultAdapter();
				$data['user_id']='';
				$dbAdapter->insert('ob_users', $data);
				$user_id = Zend_Db_Table::getDefaultAdapter()->lastInsertId('ob_users','user_id');

		$username->insertUser($addForm->getValues(),$user_id);
		 $grant_id = $this->_request->getParam('grant_id');
                $user = new Commonviewuser_Model_UserGrants();
		$result = $user->grantsInsert($grant_id,$user_id);

            $this->_redirect('/user');
}}}
 		
}
}
