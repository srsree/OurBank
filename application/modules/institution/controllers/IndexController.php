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
/*
 *  create an institution controller view, add,edit and delete
 */
class Institution_IndexController extends Zend_Controller_Action 
{
    public function init()
    {
        $this->view->pageTitle=$this->view->translate('Institution');

        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->username = $this->view->globalvalue[0]['username'];
		$this->view->creadtedby = $this->view->globalvalue[0]['id'];

//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm();
	}
	//view action
    public function indexAction() 
    { 
        $searchForm = new Management_Form_Search();
		$this->view->form = $searchForm; 
		//poster validation
		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
                    $institution = new Institution_Model_Institution();
                    $page = $this->_getParam('page',1);
                    $paginator = Zend_Paginator::factory($institution->searchRecord($this->_request->getPost('field2')));
                    $this->view->errormsg="Record not found";
                    } else {
            $this->view->title=$this->view->translate('Institution');
	    //session
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if (!$data) {
                $this->_redirect('index/login');
            }
            $institution = new Institution_Model_Institution();
            $page = $this->_getParam('page',1);
	    	$paginator = Zend_Paginator::factory($this->view->adm->viewRecord("ob_institution","id","DESC"));
                if(!$paginator){
                $this->view->errormsg="Record not found";
        }

    }
		//paginator
	    $paginator->setItemCountPerPage($this->view->adm->paginator());
	    $paginator->setCurrentPageNumber($page);
	    $this->view->paginator = $paginator;

    }
    //add action
    public function addinstitutionAction() 
    {   
        $this->view->title=$this->view->translate('Add Institution');
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
//        	if (($checkaccess != NULL)) {
			$form = new Institution_Form_Institution();
			$this->view->form = $form;
			$this->view->submitform = new Bank_Form_Submit();
        	if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				if ($this->_request->isPost()) {
				$formData = $this->_request->getPost();
					if ($form->isValid($formData)) { 
						$id = $this->view->adm->addRecord("ob_institution",$form->getValues());
						$this->_redirect('/institutioncommonview/index/commonview/id/'.$id);
					}
				}
			}
// 		} else {
//              $this->_redirect('index/error');
// 		}
    }
    //edit action
    public function editinstitutionAction() 
    {   
        $this->view->title=$this->view->translate('Edit Institution');
		//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'editinstitutionAction');
//        	if (($checkaccess != NULL)) {
			//form instance
			$form = new Institution_Form_Institution(1);
			$this->view->form = $form;
			$this->view->submitform = new Bank_Form_Submit();
			if ($this->_request->isPost() && $this->_request->getPost('Update')) {
				$formData = $this->_request->getPost();
				if ($form->isValid($formData)) { 
					//Update the previous record
					$id = intval($this->_request->getPost('id'));
					$editinstitution = $this->view->adm->editRecord("ob_institution",$id);

					$this->view->adm->updateLog("ob_institution_log",$editinstitution[0],$this->view->creadtedby);
					//update 					
					$this->view->adm->updateRecord("ob_institution",$id,$form->getValues());
					$this->_redirect("/institution");
				}
			} else {
				$this->view->id=intval ($this->_request->getParam("id"));
				$editinstitution = $this->view->adm->editRecord("ob_institution",$this->view->id);
				$form->populate($editinstitution[0]);
			} 
// 		} else {
//           $this->_redirect('index/error');
//     	}
    }

    public function viewinstitutionAction () 
    {
    
    }

	//delete action
    public function deleteinstitutionAction() 
	{
		//Acl
//         $access = new App_Model_Access();
 		$this->view->submitform = new Bank_Form_Submit();
//         $checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'deleteinstitutionAction');
//        	if (($checkaccess != NULL)) {    
			$this->view->title=$this->view->translate('Delete Institution');
			
			$id=$this->_request->getParam("id");
			$this->view->id = $id;
			
			$form = new Institution_Form_Delete();
			$this->view->form = $form;
			
			//get poster data and validate
			if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				$id=$this->_request->getParam("id");
				$redirect = $this->view->adm->deleteAction("ob_institution","institution",$id);
				$this->_redirect("/".$redirect);
			}
//     	} else {
//         	$this->_redirect('index/error');
// 	    }
	}
}
