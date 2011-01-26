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
class Creditline_IndexController extends Zend_Controller_Action
{
	public function init() 
        {
		$this->view->pageTitle=$this->view->translate("Credit line");

		$globalsession = new App_Model_Users();
		$this->view->globalvalue = $globalsession->getSession();
			$this->view->username = $this->view->globalvalue[0]['username'];
			$this->view->createdby = $this->view->globalvalue[0]['id'];
		
// 		if (($this->view->globalvalue[0]['id'] == 0)) {
// 			$this->_redirect('index/logout');
// 		}
		$this->view->adm = new App_Model_Adm();
		$this->view->dateconvert = new Creditline_Model_dateConvertor();
		
		$test = new DH_ClassInfo(APPLICATION_PATH . '/modules/creditlineindex/controllers/');
		$module = $test->getControllerClassNames();
		$modulename = explode("_", $module[0]);
 		$this->view->modulename = strtolower($modulename[0]);
	}

	public function indexAction() 
        {
		$this->view->pageTitle=$this->view->translate("Creditline");
	}
	public function creditlineaddAction() 
        {
		$this->view->title=$this->view->translate("Add creditline");
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Creditline',$this->view->globalvalue[0]['name'],'creditlineaddAction');
// 		if (($checkaccess != NULL)) {
		$form = new Creditline_Form_Creditline();
		$this->view->form = $form;
        	if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
			if ($this->_request->isPost()) {
			$formData = $this->_request->getPost();
				if ($form->isValid($formData)) { 
                unset($formData['Submit']);
                $formData["start_date"]=$this->view->dateconvert->phpmysqlformat($formData['start_date']);
                $formData["end_date"]=$this->view->dateconvert->phpmysqlformat($formData['end_date']);
                $formData["created_by"]=$this->view->createdby;

                        $id = $this->view->adm->addRecord("ob_creditline",$formData);
                        $this->_redirect('/creditlineindex/index');
				}
			}
		}

// 		} else {
//              $this->_redirect('index/error');
// 		}
	}
	public function creditlineeditAction() 
        {
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Creditline',$this->view->globalvalue[0]['name'],'creditlineeditAction');
// 		if (($checkaccess != NULL)) {
		

		$form = new Creditline_Form_Creditline();
		$this->view->form = $form;
		$id = $this->_getParam('id');
		$this->view->id = $id;
		$creditlinedetails1 = $this->view->adm->editRecord("ob_creditline",$id);

		$form->populate($creditlinedetails1[0]);
		foreach($creditlinedetails1 as $creditlinedetails){
			$this->view->form->start_date->setValue($this->view->dateconvert->phpnormalformat($creditlinedetails['start_date']));
			$this->view->form->end_date->setValue($this->view->dateconvert->phpnormalformat($creditlinedetails['end_date']));
	
			$formdata2=array('id'=>$creditlinedetails['id'],'name'=>$creditlinedetails['name'],'portfolio'=>$creditlinedetails['portfolio'],'start_date'=>$creditlinedetails['start_date'],'end_date'=>$creditlinedetails['end_date'],'status'=>$creditlinedetails['status'],'created_by'=>$creditlinedetails['created_by'],'created_date'=>$creditlinedetails['created_date']);

		}

		if ($this->_request->isPost() && $this->_request->getPost('Update')) {
			$id = $this->_getParam('id');
			$formData = $this->_request->getPost();
			if ($form->isValid($formData)) {
				//Update the previous record
				$formdata1=array('name'=>$formData['name'],'portfolio'=>$formData['portfolio'],'start_date'=>($this->view->dateconvert->phpmysqlformat($formData['start_date'])),'end_date'=>($this->view->dateconvert->phpmysqlformat($formData['end_date'])),'status'=>$formData['status'],'created_by'=>$this->view->createdby);

				$this->view->adm->updateLog("ob_creditline_log",$formdata2,$this->view->createdby);
				//update 					
				$this->view->adm->updateRecord("ob_creditline",$id,$formdata1);
				$this->_redirect("/creditlineindex");
			}
		}



// 		} else {
//              $this->_redirect('index/error');
// 		}
	}

	public function creditlineviewAction() 
        {
	}

	public function creditlinedeleteAction() 
        {
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Creditline',$this->view->globalvalue[0]['name'],'creditlinedeleteAction');
// 		if (($checkaccess != NULL)) {
			$form = new Creditline_Form_Delete();
			$this->view->form = $form;
			$this->view->id = $this->_getParam('creditline_id');
			if($this->_request->isPost() && $this->_request->getPost('Delete')) {
				$formdata = $this->_request->getPost();
				if($form->isValid($formdata)) {
					$redirect = $this->view->adm->deleteAction("ob_creditline",$this->view->modulename,$this->view->id);
					$this->_redirect("/".$redirect);
	
				}
			}


// 		} else {
//              $this->_redirect('index/error');
// 		}
	}

}
