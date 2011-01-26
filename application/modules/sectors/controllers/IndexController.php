<?php
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
class Sectors_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle=$this->view->translate('Sectors');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->username = $this->view->globalvalue[0]['username'];
        $this->view->createdby = $this->view->globalvalue[0]['id'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//                 $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {

         //  when delete particular Sector we should check that particular Sector is used by other one or not according to result we should delete that record if that Sector is used by some one then we should display message
        if($this->_helper->flashMessenger->getMessages()){
        $messages = $this->_helper->flashMessenger->getMessages();
            foreach($messages as $errormsg){
                echo "<script> alert('$errormsg');</script>";
           }
        }
       // Translate the given string to selected language
        $this->view->title = $this->view->translate('Sectors');
        $searchForm = new Sectors_Form_Search();
        $this->view->form = $searchForm;
        $page = $this->_getParam('page',1); 
            $dbobj = new Sectors_Model_Sectors();
        if ($this->_request->isPost() && $this->_request->getPost('Search')) { 
            $formData = $this->_request->getPost('Sector');
            if ($this->_request->isPost()) {
                    $result = $dbobj->SearchSectors($formData); // search criteria values 
                    $paginator = Zend_Paginator::factory($result); // set paginator for selected values
                    $this->view->search = true;
            }
        } else {
            $result = $this->view->adm->viewRecord("ob_sector","id","DESC"); // get default sector details
            $paginator = Zend_Paginator::factory($result); // set paginator for default sector details
        }
        $paginator->setItemCountPerPage($this->view->adm->paginator());
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function sectorsaddAction() 
    {  
        // Translate the given string to selected language
        $this->view->title = $this->view->translate('New Sector');
// // //         //Acl
// // //         $access = new App_Model_Access();
// // //         $checkaccess = $access->accessRights('Sector',$this->view->globalvalue[0]['name'],'sectorsaddAction');
// // //         if (($checkaccess != NULL)) {
            $form = new Sectors_Form_Sectors($this->view->createdby);
            $this->view->form = $form;
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) { 
                    $formData = $this->_request->getPost();
                    if ($form->isValid($formData)) { 
            $result = $this->view->adm->addRecord("ob_sector",$form->getValues()); // Insert sector details into sector table
                            $this->_redirect('sectors/index');
                    }
            }
// // // //             } else {
// // // //                 $this->_redirect('index/error');
// // // //             }
    }

    public function sectoreditAction() 
    {
        // Translate the given string to selected language
        $this->view->title = $this->view->translate('Edit Sector');
// // // //             //Acl
// // // //         $access = new App_Model_Access();
// // // //         $checkaccess = $access->accessRights('Sector',$this->view->globalvalue[0]['name'],'sectoreditAction');
// // // //         if (($checkaccess != NULL)) {
            $id = $this->_getParam('id');
            $this->view->id = $id;
            $editForm = new Sectors_Form_Sectors($this->view->createdby);
            $this->view->form = $editForm;
            $sectordetails = $this->view->adm->editRecord("ob_sector",$id); // get sector details for that particular sector id
            $editForm->populate($sectordetails[0]); // set all values on edit page form fields
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {  
                $id = $this->_getParam('id');
                $formData = $this->_request->getPost();
                    if ($editForm->isValid($formData)) { 
                        $previousdata = $this->view->adm->editRecord("ob_sector",$id); // retrieve the previous data of sector
                        $this->view->adm->updateLog("ob_sector_log",$previousdata[0],$this->view->createdby);// sent all values to log table
                        //update the new sector details					
                        $this->view->adm->updateRecord("ob_sector",$id,$editForm->getValues()); 
                        $this->_redirect('sectors/index/');
                    }
            }
// // // //         } else {
// // // //             $this->_redirect('index/index');
// // // //             }
    }

    public function sectorviewAction()
    { 
        // Translate the given string to selected language
        $this->view->title = $this->view->translate('View Sector');
// // //             //Acl
// // //         $access = new App_Model_Access();
// // //         $checkaccess = $access->accessRights('Sector',$this->view->globalvalue[0]['name'],'sectorviewAction');
// // //         if (($checkaccess != NULL)) {
            $SectForm = new Sectors_Form_Search();
            $this->view->form = $SectForm;
            $id = (int)$this->_getParam('id');
            $this->view->id = $id;
            $this->view->sector = $this->view->adm->editRecord("ob_sector",$id); // get sector details for that particular sector id 
// // //         } else {
// // //             $this->_redirect('index/error');
// // //         }
    }

    public function sectordeleteAction()
    {       
         // Translate the given string to selected language
         $this->view->title = $this->view->translate('Delete Sector');
// // //     //Acl
// // //         $access = new App_Model_Access();
// // //         $checkaccess = $access->accessRights('Sector',$this->view->globalvalue[0]['name'],'sectorviewAction');
// // //         if (($checkaccess != NULL)) {
            $delform = new Sectors_Form_Delete();
            $this->view->form = $delform;
            $id = $this->_getParam('id');
            $this->view->id = $id;
            $sectordetail=$this->view->adm->editRecord("ob_sector",$id); // get sector details for particular sector id
            foreach($sectordetail as $Sectordetails){ 
                    $this->view->sectorname =  $Sectordetails['name'];
            }
            $dbobj = new Sectors_Model_Sectors();
            $sectorstatus = $dbobj->getSectorstatus($id);

                // if that Sector id is not used by anyone we can delete that record
            if(!$sectorstatus){ 
                if($this->_request->isPost() && $this->_request->getPost('Submit')) {
                $formdata = $this->_request->getPost();
                    if ($delform->isValid($formdata)) { 
                        $previousdata = $this->view->adm->editRecord("ob_sector",$id); //get sector details for that sector id
                        $this->view->adm->addRecord("ob_sector_log",$sectordetail[0]); // add previous data into 
                        //update sector details					
                        $this->view->adm->deleteRecord("ob_sector",$id);
                        $this->_redirect('sectors/index/');
                        }
                }
            }  // if that sector id is used by someone then we should assign message 
            else {
                $this->_helper->flashMessenger->addMessage('You cannot delete this Sector, its in usage');
                $this->_helper->redirector('index');
            }
// //             } else {
// //                 $this->_redirect('index/index');
// //         }
    }
}
