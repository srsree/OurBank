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

class Activity_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
    $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/activity/controllers/');
    $this->view->pageTitle=$this->view->translate('Activities');
    $globalsession = new App_Model_Users();
    // get session values
    $this->view->globalvalue = $globalsession->getSession();
    $this->view->createdby = $this->view->globalvalue[0]['id'];
    $this->view->username = $this->view->globalvalue[0]['username'];
    //     if (($this->view->globalvalue[0]['id'] == 0)) {
    //             $this->_redirect('index/logout');
    //     }
    // create instance for common model page of adm
    $this->view->adm = new App_Model_Adm();
    // create instance for activity model 
    $this->view->activity = new Activity_Model_Activity();
    $module = $test->getControllerClassNames();
    $modulename = explode("_", $module[0]);
    $this->view->modulename = strtolower($modulename[0]);
    }

    public function indexAction() 
    { 

        //  when delete particular Activity we should check that particular Activity is used by other one or not according to we should delete that record if that Activity is used by some one then we should display message
        if($this->_helper->flashMessenger->getMessages()){
        $messages = $this->_helper->flashMessenger->getMessages();
            foreach($messages as $error){
                echo "<script> alert('$error');</script>";
           }
        }

        // translate this given string according to chosen language
        $this->view->title = $this->view->translate('Activities');
        // create instance for activity form 
        $searchForm = new Activity_Form_Search();
        $this->view->form = $searchForm;
        $page = $this->_getParam('page',1);
        // create instance for activity model 
        $dbobj = new Activity_Model_Activity();
        if($this->_request->isPost() && $this->_request->getPost('Search')){ 
            $formdata = $this->_request->getPost(); 
        if ($this->_request->isPost()) {
            $result = $dbobj->SearchActivity($formdata);
            // assign searched values into paginator
            $paginator = Zend_Paginator::factory($result);
            $sector = $this->view->adm->viewRecord("ob_sector","id","DESC");
                foreach($sector as $sector){
                $searchForm->sector->addMultiOption($sector['id'],$sector['name']);
            }
                $this->view->search = true;
            }
            }
        else {
            $sector = $this->view->adm->viewRecord("ob_sector","id","DESC");
                foreach($sector as $sector){
                $searchForm->sector->addMultiOption($sector['id'],$sector['name']);
            }
            $result = $dbobj->IndexActivity();
            // assign default values into paginator
            $paginator = Zend_Paginator::factory($result);
        }
        // set pagination control
        $paginator->setItemCountPerPage($this->view->adm->paginator());
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    } 
    public function activityaddAction() 
    { 
        // translate this given string according to chosen language
        $this->view->title = $this->view->translate('New Activity');
        //         //Acl
        //         $access = new App_Model_Access();
        //         $checkaccess = $access->accessRights('Activity',$this->view->globalvalue[0]['name'],'activityaddAction');
        //         if (($checkaccess != NULL)) {
                        //Add Action
            // send login id as a constructor value
            $form = new Activity_Form_Activity($this->view->createdby);
            $this->view->form = $form;
            $sector = $this->view->adm->viewRecord("ob_sector","id","DESC");
            foreach($sector as $sector){
                $form->sector_id->addMultiOption($sector['id'],$sector['name']);
            }
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) { 
                $formData = $this->_request->getPost();
                if ($form->isValid($formData)) { 
                        $id = $this->view->adm->addRecord("ob_activity",$form->getValues()); // insert activity details to activity table
                        $this->_redirect("/".$this->view->modulename);
    
                }
            }
            //         } else {
            //             $this->_redirect('index/error');
            //                 }
    }
	public function activityeditAction() 
	{
            $this->view->title =$this->view->translate('Edit Activity'); 
            //             //Acl
            //             $access = new App_Model_Access();
            //             $checkaccess = $access->accessRights('Activity',$this->view->globalvalue[0]['name'],'activityeditAction');
            //             if (($checkaccess != NULL)) {
		//Edit Action
                $id = $this->_getParam('id');
                $this->view->id = $id;
            // send login id as a constructor value
                $form = new Activity_Form_Activity($this->view->createdby);
                $this->view->form = $form;
                $sector = $this->view->adm->viewRecord("ob_sector","id","DESC");
                 foreach($sector as $sector){
                        $form->sector_id->addMultiOption($sector['id'],$sector['name']);
                }
                $dbobj = new Activity_Model_Activity();
                $activitydetails=$dbobj->viewActivity($id);
                $form->populate($activitydetails[0]);
                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {  
                    $id = $this->_getParam('id');
                    $formData = $this->_request->getPost();
                    if ($form->isValid($formData)) { 
                        //insert the previous record of activity into log table after getting value from activity table
                        $previousdata = $this->view->adm->editRecord("ob_activity",$id);
                        $this->view->adm->updateLog("ob_activity_log",$previousdata[0],$this->view->createdby);
                        //update recent values to activity table				
                        $this->view->adm->updateRecord("ob_activity",$id,$form->getValues());
                        $this->_redirect("/".$this->view->modulename);
                    }
 			}
                // 	   } else {
                //                 $this->_redirect('index/error');
                // 		}
	}

	public function activityviewAction()
	{
                // 		//Acl
                //             $access = new App_Model_Access();
                //             $checkaccess = $access->accessRights('Activity',$this->view->globalvalue[0]['name'],'activityaddAction');
                //             if (($checkaccess != NULL)) {
                // send login id as a constructor value
                $form = new Activity_Form_Activity($this->view->createdby);
                $this->view->form = $form;
                $this->view->id = (int)$this->_getParam('id');
                $dbobj = new Activity_Model_Activity();
                // get activity details to display into view page
                $activitydetails=$dbobj->viewActivity($this->view->id);
                $this->view->activity = $activitydetails;
                //             } else {
                //             $this->_redirect('index/error');
                //                     }
	}

	public function activitydeleteAction(){
            // create instance for form page
            $delform = new Activity_Form_Delete();
            $this->view->form = $delform;
            $dbobj = new Activity_Model_Activity();
            //             //Acl
            //             $access = new App_Model_Access();
            //             $checkaccess = $access->accessRights('Activity',$this->view->globalvalue[0]['name'],'activitydeleteAction');
            //             if (($checkaccess != NULL)) {
                $this->view->id = $this->_getParam('id');
                $activitydetail=$this->view->adm->editRecord("ob_activity",$this->view->id);
                foreach($activitydetail as $activitydetails){ 
                    $this->view->activityname =  $activitydetails['name'];
                }
                $activitystatus = $dbobj->getActivitystatus($this->view->id);

                // if that grant id is not used by anyone we can delete that record
                if(!$activitystatus){
                    if($this->_request->isPost() && $this->_request->getPost('Submit')) {
                        $formdata = $this->_request->getPost();
                        if($delform->isValid($formdata)) {
                            $redirect = $this->view->adm->deleteAction("ob_activity",$this->view->modulename,$this->view->id);
                            $this->_redirect("/".$redirect);
        
                            }
                    }	
                }	
//                 // if that activity id is used by someone then we should assign message 
                else {

                    $this->_helper->flashMessenger->addMessage('You cannot delete this Activity, its in usage');
                    $this->_helper->redirector('index');
                }
            //                     } else {
            //                             $this->_redirect('index/error');
            //                 }
	}
}
