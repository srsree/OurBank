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
 *  bank controller for add, view,update,delete
 */

class Bank_IndexController extends Zend_Controller_Action 
{
    public function init()
    {
        $this->view->pageTitle=$this->view->translate('Bank');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
            $this->view->createdby = $this->view->globalvalue[0]['id'];

            $this->view->username = $this->view->globalvalue[0]['username'];

//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
            $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    { 
	//instance for form
        $searchForm = new Management_Form_Search();
        $this->view->form = $searchForm;
	//form data poster
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
            $bank = new Bank_Model_Bank();
            $page = $this->_getParam('page',1);
                $paginator = Zend_Paginator::factory($bank->search($this->_request->getPost('field2')));
        } else {
            $this->view->title=$this->view->translate('Bank');
	    //session
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data)
            {
                $this->_redirect('index/login');
            }
            $bank = new Bank_Model_Bank();
            $page = $this->_getParam('page',1);
                $paginator = Zend_Paginator::factory($this->view->adm->viewRecord("ob_bank","id","DESC"));

        }
                //paginator
            $paginator->setItemCountPerPage($this->view->adm->paginator());
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
    }
    
    public function addbankAction() 
    {
                //Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Bank',$this->view->globalvalue[0]['name'],'addbankAction');
//         if (($checkaccess != NULL)) {
                        // add bank
            $this->view->title=$this->view->translate('Add Bank');
            $form = new Bank_Form_Bank();
            $this->view->form = $form;
	    //new bank form instance
            $this->view->submitform = new Bank_Form_Submit();	
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                if ($this->_request->isPost()) {
                    $formData = $this->_request->getPost();
                    if ($form->isValid($formData)) { 
                        // bank Insert
                        $id = $this->view->adm->addRecord("ob_bank",$form->getValues());
                        $this->_redirect('/bankcommonview/index/commonview/id/'.$id);
                    }
                }
            }
//         } else {
//         $this->_redirect('index/error');
//             }
    }
    
    public function editbankAction() 
    {
                //Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Bank',$this->view->globalvalue[0]['name'],'editbankAction');
//         if (($checkaccess != NULL)) {
                // edit bank   
            $form = new Bank_Form_Bank();
            $this->view->form = $form;
            $this->view->submitform = new Bank_Form_Submit();
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                if ($this->_request->isPost()) {
                    $formData = $this->_request->getPost();
                    if ($form->isValid($formData)) { 
                        $bank = new Bank_Model_Bank();
                    //Update the previous record
                        $id = intval($this->_request->getPost('id'));
                        $editinstitution = $this->view->adm->editRecord("ob_bank",$id);
                        $this->view->adm->updateLog("ob_bank_log",$editinstitution[0],$this->view->createdby);
                        //update 					
                        $this->view->adm->updateRecord("ob_bank",$id,$form->getValues());
                        $this->_redirect("/bank");
                    }
                }
            } else {
                $this->view->title=$this->view->translate('Edit Bank');
                $this->view->id = intval($this->_request->getParam("id"));
                $editBank = $this->view->adm->editRecord("ob_bank",$this->view->id);
                $form->populate($editBank[0]);
            }
//         } else {
//             $this->_redirect('index/error');
//         }
    }
    
    public function viewbankAction () 
    {
    }
    
    public function deletebankAction() 
    {
                //Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Bank',$this->view->globalvalue[0]['name'],'deletebankAction');
//         if (($checkaccess != NULL)) {
            $this->view->title=$this->view->translate('Delete Bank');
            $this->view->id = $this->_request->getParam("id");
            $form = new Institution_Form_Delete();
            $this->view->form = $form;
            $this->view->submitform = new Bank_Form_Submit();
	    //form poster data
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                $id=$this->_request->getParam("id");
		//adm delete instance
                $this->view->adm->deleteAction("ob_bank","bank",$id);
                $this->view->adm->deleteSubmodule("contact",$id,2);
                $this->view->adm->deleteSubmodule("address",$id,2);
                $this->_redirect("/bank");
            }
//         } else {
//             $this->_redirect('index/error');
//         }
    }
}

