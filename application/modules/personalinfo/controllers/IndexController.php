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
class Personalinfo_IndexController extends Zend_Controller_Action 
{
    public function init() 
	{
        $this->view->pageTitle='User';
        $this->view->myaccountmodule = "current";
    }
	public function indexAction() 
	{
	}
    public function addAction() 
	{
		$this->view->title = "Add address";
		$this->view->accountinfolink="newcurrent";
		$addForm = new Personalinfo_Form_Personal();
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
           		$dateofbirth=$this->_request->getParam('dateofbirth');
				$dateofjoin=$this->_request->getParam('dateofjoin');
            	$email=$this->_request->getParam('email');
				$convertdate = new Creditline_Model_dateConvertor();
            	$personalmodel=new Personalinfo_Model_personalinfo();
            	$personalmodel->add_info(array('module_id' => $mod_id,
												'submodule_id'=>$sub_id,
												'id'=> $id,
												'date_of_birth' =>$convertdate->phpmysqlformat($dateofbirth),
												'date_of_join' =>$convertdate->phpmysqlformat($dateofjoin),
												'email' => $email,
												'recordstatus_id' => 3));
				$path1=$this->_getParam('path');
				$path2=$this->_getParam('index');
				$this->_redirect('/usercommonview/index/commonview/id/'.$id);
			}
        }
	}
	public function editAction() 
	{
		$this->view->title = "Edit address";
		$addForm = new Personalinfo_Form_Personal();
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
		$personalmodel=new Personalinfo_Model_personalinfo();
		$personal=$personalmodel->getpersonal($id,$mod_id,$sub_id);
		$convertdate = new Creditline_Model_dateConvertor();
		foreach($personal as $personaldetails){
			$this->view->form->dateofbirth->setvalue($convertdate->phpnormalformat($personaldetails['date_of_birth']));
			$this->view->form->dateofjoin->setvalue($convertdate->phpnormalformat($personaldetails['date_of_join']));
			$this->view->form->email->setValue($personaldetails['email']);
			$this->view->form->user_id->setValue($personaldetails['id']);
		}
		if ($this->_request->isPost() && $this->_request->getPost('Update')) {
            $dateofbirth=$this->_request->getParam('dateofbirth');
            $dateofjoin=$this->_request->getParam('dateofjoin');
            $email=$this->_request->getParam('email');
			$id=$this->_request->getParam('user_id');
           	$data = array('recordstatus_id' => 2);
            $personalmodel->edit_personal($id,$mod_id,$sub_id,$data);
			$personalmodel->add_info(array('module_id' => $mod_id,
											'submodule_id'=>$sub_id,
											'id'=> $id,
											'date_of_birth' =>$convertdate->phpmysqlformat($dateofbirth),
											'date_of_join' =>$convertdate->phpmysqlformat($dateofjoin),
											'email' => $email,
											'recordstatus_id' => 3));
			$path1=$this->_getParam('path');
			$path2=$this->_getParam('index');
			$this->_redirect('/usercommonview/index/commonview/id/'.$id);
		}
	}
}
