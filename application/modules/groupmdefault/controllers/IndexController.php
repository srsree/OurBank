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
class Groupmdefault_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle='Groupm';
        $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/groupm/controllers/');// create instance to get controller name 
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();// get session values
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//                 $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm(); // create instance for common adm model page
        $module = $test->getControllerClassNames();
        $modulename = explode("_", $module[0]);
        $this->view->modulename = strtolower($modulename[0]);
    
    }

    public function addgroupAction() 
    {
        if($this->_request->getParam('error')) { // display error message for wrong head selection
			$error = $this->_request->getParam('error');
			if($error == 1 ) {
				$this->view->error = "Improper Group head selection ! ";
			}
        }
        $app = $this->view->baseUrl();
        $this->view->pageTitle = "Groupm";
        $addForm = new Groupmdefault_Form_groupdefault($app);
        $this->view->form=$addForm;
        $dbobj = new Groupmdefault_Model_groupdefault();

           $hierarchy = $dbobj->getofficehierarchy();
               foreach($hierarchy as $hiearchyids){
             $hiearchyid = $hiearchyids['hierarchyid'];
            }
        $officedetails = $this->view->adm->getRecord('ourbank_office','officetype_id',$hiearchyid);
        foreach($officedetails as $officeiddetails) { 
        $addForm->office->addMultiOption($officeiddetails['id'],$officeiddetails['name']);
        }

    }
    public function getmembersaddAction()
    {
         // get branch id and display branch members
        $branch_id = $this->_request->getParam('branch_id');
        $this->_helper->layout->disableLayout();
        $dbobj= new Groupmdefault_Model_groupdefault();
        $this->view->members = $dbobj->GetBranchMembers($branch_id);
    }
    public function getmembersAction()
    {
        $branch_id = $this->_request->getParam('branch_id');
        $group_id = $this->_request->getParam('group_id');

        $this->_helper->layout->disableLayout();
        $dbobj= new Groupmdefault_Model_groupdefault();
        $this->view->members = $dbobj->GetBranchMembers1($branch_id,$group_id); //List all members including Joined Memeber //remaining 
        $this->view->groupheaddetails = $dbobj->Getgrouphead($group_id); //get group head
        foreach($this->view->groupheaddetails as $grouphead){
                $this->view->grouphead = $grouphead['head'];
        }
        $fetchMembersValue=$dbobj->assignMembers($group_id); //get assigned members
        $this->view->assignMembers = $fetchMembersValue;
     }
    public function groupaccountAction() 
    {  
        $member_id = $_POST['member_id'];
        $group_head = $_POST['memberhead'];
        $result = "";
        if(in_array($group_head,$member_id))
            {
               $result = "ok"; // check if selected members and group head is correct 
            }
        if($result == "ok")
        { // if result ok get input values
          $office_id = $this->_request->getParam('office');
          $groupname = $this->_request->getParam('groupname');
          $createddate= $this->_request->getParam('Created_Date');
          $convertdate = new App_Model_dateConvertor();
          $createddate=$convertdate->phpmysqlformat($createddate);
            $date=date("y/m/d H:i:s");
            // validate the group name if name exists or not
            $validator = new Zend_Validate_Db_RecordExists('ourbank_group','name');
            if ($validator->isValid($groupname)) {
                $messages = $validator->getMessages();	
                    $this->view->errorgroupname=$groupname.'Already Existed';// if name exists display error message
            } else {
                $groupid = $this->view->adm->addRecord("ourbank_group",array('name' => $groupname)); // Insert group name and get pk id
            $dbobj= new Groupmdefault_Model_groupdefault();
            $grouptypeid = $dbobj->getGrouptypeid('Group');
            // generate group code
            $groupcode=str_pad($office_id,3,"0",STR_PAD_LEFT)."0".$grouptypeid.str_pad($groupid,5,"0",STR_PAD_LEFT);
            // update rest of group values
            $this->view->adm->updateRecord("ourbank_group",$groupid,array('office_id' =>$office_id,'head'=>$group_head,'groupcode' =>$groupcode,'group_created_date'=>$date,'created_by' =>$this->view->createdby,'created_date' =>$createddate ));/* Group created date -> Including timestamp , Created date should contain date only*/

                foreach($member_id as $memberid)
                 {
                  $this->view->adm->addRecord("ourbank_groupmembers",array('id' =>$groupid,
                                                                    'member_id' =>$memberid,
                                                                    'groupmember_status' =>3));////add groupmembers with its group id ->($groupid)
                 }
                  $account_id = $this->view->adm->addRecord("ourbank_accounts",array('id' =>'',
                                                                    'membertype_id' =>3,
                                                                    'accountcreated_date' =>$date,
                                                                    'created_date' =>$createddate,
                                                                    'created_by' =>$this->view->createdby,
                                                                    'status_id' => 1)); // insert some value to accounts table
            $grouptypeid = $dbobj->getGrouptypeid('Group');
            $productdetails = $dbobj->getProductid($grouptypeid);
            foreach($productdetails as $productdetail){
                $productid = $productdetail['id'];
            }

                $productcode = 'S';
		$accountNumber=str_pad($office_id,3,"0",STR_PAD_LEFT).str_pad($grouptypeid,2,"0",STR_PAD_LEFT).str_pad($productcode,3,"0",STR_PAD_LEFT).str_pad($account_id,6,"0",STR_PAD_LEFT);
$this->view->adm->updateRecord("ourbank_accounts",$account_id,array('account_number' =>$accountNumber,'member_id'=>$groupid,'product_id' =>$productid));// // Group created date -> Including timestamp , Created date should contain date only


                    $this->_redirect('groupmcommonview/index/commonview/id/'.$groupid);
                }
        }else{  // if not ok display errormessage 
            $error = "1";
            $this->_redirect('/groupmdefault/index/addgroup/error/'.$error);
            }
    }
    public function editgroupAction()
    {
        // check group head , and members are correct 
        if($this->_request->getParam('error'))
        {
        $error = $this->_request->getParam('error');
        if($error == 1 ){ // display error message for wrongly chosen group head 
                $this->view->error = "Improper Group head selection ! ";
            }
        }
        $app = $this->view->baseUrl();
        $group_id=$this->_getParam('id');
        $this->view->groupid=$group_id;
        $this->view->title = "Edit Group Details"; 
        // create instance for form page with baseurl
        $addForm = new Groupmdefault_Form_groupdefault($app);
        $this->view->form=$addForm;
 
        $dbobject = new Groupmdefault_Model_groupdefault();
         $hierarchy = $dbobject->getofficehierarchy();
               foreach($hierarchy as $hiearchyids){
             $hiearchyid = $hiearchyids['hierarchyid'];
            }
         // load office id
        $officedetails = $this->view->adm->getRecord('ourbank_office','officetype_id',$hiearchyid);
        foreach($officedetails as $officeiddetails) { 
        $addForm->office->addMultiOption($officeiddetails['id'],$officeiddetails['name']);
        }

        $dbobj = new Groupmcommonview_Model_groupcommon();
        $result = $dbobj->getgroup($group_id);
        $convertdate = new App_Model_dateConvertor();
        // assign values with respective form fields
        foreach($result as $group){
        $addForm->office->setValue($group['officeid']);
        $addForm->groupname->setValue($group['name']);
        $addForm->Created_Date->setValue($convertdate->phpnormalformat($group['group_created_date']));
        }
        // enable javascript function to load groupmembers 
        echo "<script>getMember('".$group['officeid']."','".$app."','".$group['groupid']."');</script>";
 
            if ($this->_request->isPost() && $this->_request->getPost('Submit')) 
            {  
                $mem = $this->_request->getPost('member_id'); // get selected members
                $group_head = $_POST['memberhead'];// get group head 

                $result = "";
                
                if(in_array($group_head,$mem)){ // check members and group head are correct or not
                    $result = "ok";
                }
                if($result == "ok"){  // if ok then get all input values
                    $office_id = $this->_request->getParam('office');
                    $groupname = $this->_request->getParam('groupname');
                    $createddate= $this->_request->getParam('Created_Date');
                    $convertdate = new App_Model_dateConvertor();
                    $createddate=$convertdate->phpmysqlformat($createddate);
                    $date=date("y/m/d H:i:s");
                    $groupdetails = $dbobject->getgroupdetails($group_id); // get group details for particular id
                    $this->view->adm->addRecord("ourbank_group_log",$groupdetails[0]);  // add group details to log table
                    $this->view->adm->updateRecord("ourbank_group",$group_id,array('office_id' =>$office_id,'name' =>$groupname,'head'=>$group_head,'group_created_date'=>$date,'created_by' =>$this->view->createdby,'created_date' =>$createddate)); // update group details
                    $dbobject->UpdateGroupdetails($group_id);
                    // insert group members 
                    foreach($mem as $memberid){
                    $this->view->adm->addRecord("ourbank_groupmembers",array('id' =>$group_id,
                                                'member_id' =>$memberid,
                                                'groupmember_status' =>3));
                    }
                    $this->_redirect('groupmcommonview/index/commonview/id/'.$group_id);
                        }
                else{ // display error message for wrong group head selection
                    $error = "1";
                    $this->_redirect('groupmdefault/index/editgroup/id/'.$group_id.'/error/'.$error);
            
                }
            }
        }
 public function deletegroupAction()
    {
//        $checkaccess = $access->accessRights('Group',$this->view->globalvalue[0]['name'],'activitydeleteAction');
//        if (($checkaccess != NULL)) {
        $this->view->groupid=$this->_request->getParam('id');
        $deleteForm = new Groupmdefault_Form_Delete();
        $this->view->form=$deleteForm; 
        // create instance for Groupmdefault model page
        $dbobj= new Groupmdefault_Model_groupdefault();
        // create instance for Groupmcommonview model page
        $groupcommon=new Groupmcommonview_Model_groupcommon();
        $module=$groupcommon->getmodule('groupm');
        // get module id for group dynamically
        foreach($module as $module_id){ }
        $moduleid=$module_id['module_id'];
        if ($this->_request->isPost() && $this->_request->getPost('Submit')){
         $formdata = $this->_request->getPost();
            if($deleteForm->isValid($formdata)) {
                $grouptypeid = $dbobj->getGrouptypeid('Group');
                // get the current status of group
                $status = $dbobj->getAccountstatus($this->view->groupid,$grouptypeid);
                if(!$status){
                    $flag = true;
                    }
                    if($status){
                        foreach($status as $statusid){
                            if($statusid['accountstatus_id'] == 5) {
                                $flag = true;
                                }
                            else{
                                $flag = false;
                            }
                        }
                }
                if($flag == true){ // if there is no account for that group we can delete
                    $redirect = $this->view->adm->deleteAction("ourbank_group",$this->view->modulename,$this->view->groupid);
                    $this->view->adm->deleteSubmodule("address",$this->view->groupid,$moduleid);

                    $dbobj->UpdateGroupdetails($this->view->groupid);
                    $this->_redirect("/".$redirect);
                }
                if($flag==false){ // if account exists then display error message
                    echo "<font color='red'>You cannot delete this group, because this group have some active account.</font>";
                }
                }
	}
	}
}
