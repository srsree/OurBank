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
class Userdetails_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='User';
        $sessionName = new Zend_Session_Namespace('ourbank');
	$userid=$this->view->createdby = $sessionName->primaryuserid;
	$login=new App_Model_Users();
	$loginname=$login->username($userid);
	foreach($loginname as $loginname) {
	$this->view->username=$loginname['username'];
}
    }
 public function indexAction() {

    }

    public function edituserdetailAction() {
		$addForm = new Commonviewuser_Form_Userdetails();
		$this->view->form=$addForm;

		$user_id=$this->_getParam('id');
	    	$this->view->user_id=$user_id;

		$userdetail= new Userdetails_Model_Userdetails();
		$office = $userdetail->getOffice();
        	foreach($office as $office) {
		$addForm->officebranch->addMultiOption($office['Institute_bank_id'],$office['Institute_bank_name']);
	}
 $userdetail = new Userdetails_Model_Userdetails();
        $noOfroles= $userdetail->noGrants();
        foreach($noOfroles as $noOfroles1) {
        $addForm->grant_id->addMultiOption($noOfroles1['grant_id'],$noOfroles1['grantname']);
	}
 		$gender = $userdetail->getGender();
        	foreach($gender as $gender) {
		$addForm->gender->addMultiOption($gender->gender_id,$gender->sex);
        }
		$designation = $userdetail->getDesignation();
        	foreach($designation as $designation) {
		$addForm->designation->addMultiOption($designation->designation_id,$designation->designation_name);
        }
		$edit_user=$userdetail->edituserdetails($user_id);

		foreach($edit_user as $edit_user)
{                             $this->view->form->user_id->setValue($edit_user['user_id']);
                             $this->view->form->grant_id->setValue($edit_user['grant_id']);

                            $this->view->form->username->setValue($edit_user['firstname']);
                            $this->view->form->gender->setValue($edit_user['gender']);
                            $this->view->form->designation->setValue($edit_user['designation']);
                            $this->view->form->officebranch->setValue($edit_user['office_id']);

                        }
if ($this->_request->isPost() && $this->_request->getPost('Update')) 
          { 
		
	 $user_id= $this->_request->getParam('id');
		$firstname = $this->_request->getParam('username');
		$gender = $this->_request->getParam('gender');
		$designation = $this->_request->getParam('designation');
		 $office_id = $this->_request->getParam('officebranch');
		 $grant_id = $this->_request->getParam('grant_id');

		$userdetail= new Userdetails_Model_Userdetails();

	    $data = array('recordstatus_id' => 2);
            $userdetail->userEdit($user_id,$data);

            $uInsert = $userdetail->addusername(array('user_id'=> $user_id,
                                                      'firstname' =>$firstname,
                                                      'gender' => $gender,
                                                      'designation' => $designation,
                                                      'office_id' => $office_id,
							'recordstatus_id' => 3));        
            $this->_redirect('/usercommonview/index/commonview/id/'.$user_id);
       }


    }
public function deleteAction() {
 		$id=$this->_request->getParam('id');
		$modId=$this->_request->getParam('mod_id');
		$subId=$this->_request->getParam('sub_id');
            	echo $this->view->user_id=$id;
	    	$this->view->mod_id=$modId;
            	$this->view->sub_id=$subId;
$usercommon=new Userdetails_Model_Userdetails();
            $userdetails=$usercommon->getuser($id);
            $this->view->user=$userdetails;
 $delform=new Userdetails_Form_Delete();
		$this->view->delete=$delform;
if ($this->_request->isPost() && $this->_request->getPost('Submit'))
	    {
		$formdata = $this->_request->getPost();
		//print_r($formdata);
			if($delform->isValid($formdata)) 
	         { 
		echo  $id=$this->_request->getParam('id');
            $this->_redirect('/user');

// 		 $user= new Userdetails_Model_Userdetails();
// 	       	 $data = array('recordstatus_id' => 5);
//                  $user->userEdit($id,$data);
// 		  $id=$this->_request->getParam('id');
// 	         $modId=$this->_request->getParam('modId');
//                  $subId=$this->_request->getParam('subId');
// 		 $user->deleteRemark($id,$remarks,$modId,$subId);
		 //$this->_redirect('/user');
		}
           }
    }
}
