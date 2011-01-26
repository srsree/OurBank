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
// class for roles grant which will store grant permission to user
class Roles_IndexController extends Zend_Controller_Action{
    public function init() {
        $this->view->pageTitle='Roles';
        $sessionName = new Zend_Session_Namespace('ourbank');
	$this->view->createdby = $sessionName->primaryuserid;
	
        //  $login=new App_Model_Users();
        //                 $loginname=$login->username($userid);
        //                 foreach($loginname as $loginname) {
        // 	           $this->view->primaryid=$loginname['user_id'];
        // 		   $this->view->id=$loginname['id'];
        //                    $this->view->username=$loginname['username'];
        // 		   $this->view->primaryrole=$loginname['grantname'];
        //                 }
        
        // 		$dynamic = new App_Model_Dynamic ();
        //        		$dynamic->dynamicaction();
        // create common object for adm model page
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
        //  when delete particular role grant we should check that particular role grant is used by other one or not according to we should delete that record  if that role grant is used by some one then we should display message
        if($this->_helper->flashMessenger->getMessages()){
        $messages = $this->_helper->flashMessenger->getMessages();
            foreach($messages as $error){
                echo "<script> alert('$error');</script>";
           }
        }
        // create instance for search form
        $searchForm = new Roles_Form_Search();
        // create instance for roles model 
        $roles = new Roles_Model_Roles();
        $this->view->form = $searchForm;
        $page = $this->_getParam('page',1);
        if ($this->_request->isPost() && $this->_request->getPost('Search')){ 
        // get search creteria details 
        $formdata = $this->_request->getPost();
        // send search creteria details to model page to retrieve roles grant values
        $result = $roles->searchRoles($formdata);	
        // assign the search result on paginator to show the result pagewise
        $paginator = Zend_Paginator::factory($result);
        $this->view->paginator = $paginator;
        $this->view->search = true;
	} else {
            $this->view->title='Roles';
            $this->view->title = "New Role";
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            // if session get expired sent to login page
            if (!$data) {
            $this->_redirect('index/login');
            }
            // get roles grant name and set into paginator  
                $paginator = Zend_Paginator::factory($roles->getRoles()); $paginator->setItemCountPerPage($this->view->adm->paginator());
                $paginator->setCurrentPageNumber($page);
                $this->view->paginator = $paginator;
	}
    }

    public function rolesaddAction() 
    {
        $this->view->title = "New Role";
        // create model instance for roles model page
        $activity = new Roles_Model_Roles();
        // create form instance for rolesadd page
        $form = new Roles_Form_Roles();
        $this->view->form = $form;
        // get available modules list from module table
        $module = $activity->getModule();
        $this->view->module = $module;
         if ($this->_request->isPost() && $this->_request->getPost('submit')) {
            $grantname = $this->_request->getParam('grantname'); //get grant name
            $formData = $this->_request->getPost(); //get formdata
            $moduleid = array();
            $moduleids = array();
            $mainmoduleid = array();
            $values = array();
            $arraykeys = (array_keys($formData)); //filter keyvalues
                foreach($arraykeys as $arraykey){
                    $values[] = explode('_',$arraykey); // get values in an array 
                }


                foreach($values as $valuesf){
                    if(count($valuesf) > 2)
                    {
                        $moduleid[] = $valuesf[1]; //filter Moduleids
                        $moduleids[] = $valuesf[2]; //filter Submodules
                        $activitylist[] = $valuesf[0]."_".$valuesf[1]."_".$valuesf[2];
                    }
                    else
                        {
                            $mainmoduleid[] = $valuesf[1]; //filter rest of Moduleids
                        }
                }
                $moduleid=array_values(array_unique(array_merge($moduleid,$mainmoduleid))); // get unique module id's
                $moduleids=array_values(array_unique($moduleids)); // get unique sub module id's
                $data=array('name' => $grantname,
                            'created_date'=>date("Y-m-d : H-i-s"),
                            'created_by'=>$this->view->createdby);
                $grantid = $this->view->adm->addRecord('ob_grant',$data); // inserting grant name details
                foreach($moduleids as $moduleids1){
                    $inputdata=array(
                                'grant_id' => intVal($grantid),
                                'module_id'=> intVal($moduleids1),
                                'add'=>0,
                                'edit'=>0,
                                'view'=>0,
                                'delete'=>0);
                    $this->view->adm->addRecord('ob_grantactivity',$inputdata); // set all permission as 0 before inserting exact value 
                } 
            foreach($moduleid as $moduleid1){
                    $inputdata=array(
                                'grant_id' => intVal($grantid),
                                'module_id'=> intVal($moduleid1),
                                'add'=>1,
                                'edit'=>1,
                                'view'=>1,
                                'delete'=>1);
                    $this->view->adm->addRecord('ob_grantactivity',$inputdata); // set all permission as 1 before inserting
                }
                // update all permission mode according to input data given
                foreach($moduleids as $moduleidinsert){
                    foreach($activitylist as $formData1){
                        if(strstr($formData1,$moduleidinsert)){
                            if(strstr($formData1,"add")){   
                                $data = array("add" => 1);
                                $activity->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"edit")){
                                $data = array("edit" => 1);
                                $activity->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"view")){
                                $data = array("view" => 1);
                                $activity->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"delete")){
                                $data = array("delete" => 1);
                                $activity->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            }
                    }
                
                }
        	$this->_redirect('roles/index');
       		}  
            }
    
   

    public function roleseditAction() {
        $this->view->title = 'Edit Roles';
        // create instance for roles edit form 
        $form = new Roles_Form_Roles();
        $this->view->form = $form;
        // receive the grantid 
        $grantid =  $this->_request->getParam('id');  
        $this->view->grantid = $grantid;
        // create instance for roles model 
        $grant = new Roles_Model_Roles();
        //  get grant name from grant table for respective grant id
        $grantdetails = $this->view->adm->editRecord('ob_grant',$grantid);
        // set grant name value 
        foreach($grantdetails as $grantdetails1){
            $form->grantname->setValue($grantdetails1['name']);
        }
        // get whole available modules from module table
        $this->view->module = $grant->getModule();
        // get selected modules for that particular grant id
        $this->view->availmodule = $grant->viewModuleid($grantid);
        // check if the page getting submit or not
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
        // receive input data values
        $grantid =  $this->_request->getParam('id');
        $grantname =  $this->_request->getParam('grantname'); 
        $formData = $this->_request->getPost();
        // get all previousdata of grant table
        $previousdata = $this->view->adm->editRecord("ob_grant",$grantid);
        // send previous data to grant log table
        $this->view->adm->updateLog("ob_grant_log",$previousdata[0],$this->view->createdby);
        // get all previousdata of grant activities
        $activitydetails = $grant->editactivity($grantid);
        // send previous data to grant activity log table
        foreach($activitydetails as $activitydetailslist){
            $editdata = array('id' => $activitydetailslist['id'],
                              'grant_id' => $grantid,
                              'module_id' => $activitydetailslist['module_id'],
                              'add' => $activitydetailslist['add'],
                              'edit' => $activitydetailslist['edit'], 
                              'view' => $activitydetailslist['view'],  
                              'delete' => $activitydetailslist['delete']);
            $grant->editactivitydetails('ob_grantactivity_log',$editdata);
        }
            // delete particular record from grant activity table
            $grant->deleteactivity('ob_grantactivity',$grantid);
            // update grant table 
            $data=array('name' => $grantname,
                            'created_date'=>date("Y-m-d : H-i-s"),
                            'created_by'=>$this->view->createdby);
            $this->view->adm->updateRecord('ob_grant',$grantid,$data);
            $moduleid = array();
            $moduleids = array();
            $values = array();
            $arraykeys = (array_keys($formData)); //filter keyvalues
                foreach($arraykeys as $arraykey){
                    $values[] = explode('_',$arraykey); 
                }
                foreach($values as $valuesf){
                    if(count($valuesf) > 2)
                    {
                        $moduleid[] = $valuesf[1]; //getModuleids
                        $moduleids[] = $valuesf[2]; //getSubmodules
                        $activitylist[] = $valuesf[0]."_".$valuesf[1]."_".$valuesf[2];
                    }
                }
                $moduleid=array_values(array_unique($moduleid));
                $moduleids=array_values(array_unique($moduleids));

               // set all permission as 0 before inserting exact value 
                foreach($moduleids as $moduleids1){
                    $inputdata=array(
                                'grant_id' => intVal($grantid),
                                'module_id'=> intVal($moduleids1),
                                'add'=>0,
                                'edit'=>0,
                                'view'=>0,
                                'delete'=>0);
                    $this->view->adm->addRecord('ob_grantactivity',$inputdata);
                } 
            // set all permission as 1 before inserting
            foreach($moduleid as $moduleid1){
                    $inputdata=array(
                                'grant_id' => intVal($grantid),
                                'module_id'=> intVal($moduleid1),
                                'add'=>1,
                                'edit'=>1,
                                'view'=>1,
                                'delete'=>1);
                    $this->view->adm->addRecord('ob_grantactivity',$inputdata);
                }
                // update all permission mode according to input data given
                foreach($moduleids as $moduleidinsert){
                    foreach($activitylist as $formData1){
                        if(strstr($formData1,$moduleidinsert)){
                            if(strstr($formData1,"add")){   
                                $data = array("add" => 1);
                                $grant->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"edit")){
                                $data = array("edit" => 1);
                                $grant->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"view")){
                                $data = array("view" => 1);
                                $grant->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            else if(strstr($formData1,"delete")){
                                $data = array("delete" => 1);
                                $grant->updateRecord('ob_grantactivity',$data,$moduleidinsert);
                                    } 
                            }
                    }
                }
           $this->_redirect('roles/index');
         } 
 }
    public function rolesviewAction() {
        $this->view->title = 'View Roles';
        // receive grant id 
        $grantid = $this->_getParam('id');
        $this->view->grantid = $grantid;
        // create instance for roles model 
        $grant = new Roles_Model_Roles();
        // get grant name
        $grantdetails = $this->view->adm->editRecord('ob_grant',$grantid);
        foreach($grantdetails as $grantdetails1){
            $this->view->grantname = $grantdetails1['name'];
        }
        // get all available modules from modules table 
        $this->view->module = $grant->getModule();
        // get stored values from grant activity table
        $this->view->availmodule = $grant->viewModuleid($grantid);
    }

    public function rolesdeleteAction() {
        $this->view->title = "Delete Role";
        // receive grant id 
        $grantid =  $this->_request->getParam('id');
        $this->view->grantid = $grantid;
        // create instance for delete form 
        $this->view->form  = new Roles_Form_Delete();
        // create instance for roles model 
        $dbobj = new Roles_Model_Roles();
        // check whether this grant is used by others 
        $rolestatus = $dbobj->getRolestatus($grantid);
        // get grant name for that grant id
        $grantname = $dbobj->getGrantname($grantid);
        $this->view->grantname = $grantname;

       // if that grant id is not used by anyone we can delete that record
        if(!$rolestatus)
            { 
                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                    if ($this->view->form->isValid($this->_request->getPost())) {
                        // get remarks 
                        $remarks = $this->_getParam('remarks');
                        // get grant details for that grant id
                        $previousdata = $this->view->adm->editRecord("ob_grant",$grantid);
                        // insert previous data into log table
                        $this->view->adm->updateLog("ob_grant_log",$previousdata[0],$this->view->createdby);
                        // get grant activities details for that grant id
                        $activitydetails = $dbobj->editactivity($grantid);
                        // delete grant data from grant table
                        $dbobj->deletegrantname('ob_grant',$grantid);
                        // insert grant activitity data into log table
                        foreach($activitydetails as $activitydetailslist){
                                $editdata = array('id' => $activitydetailslist['id'],
                                                'grant_id' => $grantid,
                                                'module_id' => $activitydetailslist['module_id'],
                                                'add' => $activitydetailslist['add'],
                                                'edit' => $activitydetailslist['edit'], 
                                                'view' => $activitydetailslist['view'],  
                                                'delete' => $activitydetailslist['delete']);
                                $dbobj->editactivitydetails('ob_grantactivity_log',$editdata);
                            }
                        // delete grant activity details
                          $dbobj->deleteactivity('ob_grantactivity',$grantid);
        		$this->_redirect('roles/index');
                }
                }
          }           // if that grant id is used by someone then we should assign message 
              else { 
                    $this->_helper->flashMessenger->addMessage('You cannot delete this role, its in usage');
                    $this->_helper->redirector('index');

               }
    }

}


 