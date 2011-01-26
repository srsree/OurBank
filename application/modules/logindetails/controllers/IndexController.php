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
class Logindetails_IndexController extends Zend_Controller_Action 
{
    public function init(){
        $this->view->pageTitle='User Login information';
        $this->view->myaccountmodule = "current";
    }
	public function indexAction() {
	}
    public function addAction() {
		$this->view->title = "Add address";
		$this->view->accountinfolink="newcurrent";
		$addForm = new Logindetails_Form_Login();
		$this->view->form=$addForm;
		$id=$this->_getParam('id');
		$mod_id=$this->_getParam('mod_id');
		$sub_id=$this->_getParam('sub_id');
		$path1=$this->_getParam('path');
		$path2=$this->_getParam('index');
		$this->view->path1=$path1;
		$this->view->path2=$path2;
		$this->view->mod_id=$mod_id;
		$this->view->sub_id=$sub_id;
		$this->view->id=$id;
     	if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
	 		$formData = $this->_request->getPost();
            if($addForm->isValid($formData)){
           		$username=$this->_request->getParam('username');
				$password=$this->_request->getParam('password');
            	$loginmodel=new Logindetails_Model_Logindetails();
            	$loginmodel->add_login(array('module_id' => $mod_id,
											'submodule_id'=>$sub_id,
											'id'=> $id,
											'username' =>$username,
											'password' => $password,
											'recordstatus_id' => 3));
				$path1=$this->_getParam('path');
				$path2=$this->_getParam('index');
				$this->_redirect('/usercommonview/index/commonview/id/'.$id);
/*	$this->_redirect('/'.$path1.'/index/'.$path2.'/id/'.$id);*/
			}
        }
	}
	public function editAction() {
		$this->view->title = "Edit login details";
		$addForm = new Logindetails_Form_Login();
		$this->view->form=$addForm;
		$id=$this->_getParam('id');
		$mod_id=$this->_getParam('mod_id');
		$sub_id=$this->_getParam('sub_id');
		$path1=$this->_getParam('path');
		$path2=$this->_getParam('index');
		$this->view->path1=$path1;
		$this->view->path2=$path2;
		$this->view->mod_id=$mod_id;
		$this->view->sub_id=$sub_id;
		$this->view->id=$id;
		$personalmodel=new Logindetails_Model_Logindetails();
		$address=$personalmodel->getlogin($id,$mod_id,$sub_id);
		foreach($address as $addressdetails) {
			$this->view->form->username->setValue($addressdetails['username']);
			$this->view->form->password->setValue($addressdetails['password']);
		}
     	if ($this->_request->isPost() && $this->_request->getPost('Update')) {
         	$username=$this->_request->getParam('username');
         	$password=$this->_request->getParam('password');
           	$data = array('recordstatus_id' => 2);
            $personalmodel->edit_login($id,$mod_id,$sub_id,$data);
			$personalmodel->add_login(array('module_id' => $mod_id,
											'submodule_id'=>$sub_id,
											'id'=> $id,
											'username' =>$username,
											'password' => $password,
											'recordstatus_id' => 3));
			$this->_redirect('/usercommonview/index/commonview/id/'.$id);
			$path1=$this->_getParam('path');
			$path2=$this->_getParam('index');
 		}
	}
}
