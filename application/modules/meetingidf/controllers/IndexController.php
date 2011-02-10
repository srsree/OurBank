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
class Meeting_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle='Meeting';
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->username = $this->view->globalvalue[0]['username'];
        $this->view->createdby = $this->view->globalvalue[0]['id'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
        $this->view->dateconvert = new App_Model_dateConvertor();

        $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/meetingindex/controllers/');
        $module = $test->getControllerClassNames();
        $modulename = explode("_", $module[0]);
        $this->view->modulename = strtolower($modulename[0]);
    }

    public function indexAction()
    {
        $this->view->pageTitle='Meetings';
    }

    public function meetingaddAction()  
    { 
//Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {
                //add
        $path = $this->view->baseUrl();
        $this->view->title = "New Meeting";
        $this->view->pageTitle='Meetings';

        $meetingForm = new Meeting_Form_Meeting($path);
        $this->view->meetingForm = $meetingForm;
        $meeting = new Meeting_Model_Meeting();

//         $office = $this->view->adm->viewRecord("ourbank_office","id","DESC");
        $office = $meeting->getBranch();
        foreach($office as $office1){
            $meetingForm->institute_bank_id->addMultiOption($office1['id'],$office1['name']);
        }

        $days = $this->view->adm->viewRecord("ourbank_master_weekdays","id","ASC");
        foreach($days as $days) {
            $meetingForm->meeting_day->addMultiOption($days['id'],$days['name']);
        }

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
            if ($meetingForm->isValid($formData)) {
                $formdata1=array('name'=>$formData['meeting_name'],
                                    'village_id'=>$formData['institute_bank_id'],
                                    'group_id'=>$formData['group_name'],
                                    'grouphead_name'=> '',
                                    'place'=>$formData['meeting_place'],
                                    'time'=>$formData['meeting_time'],
                                    'day'=>$formData['meeting_day'],
                                    'created_by'=>$this->view->createdby);

                $id = $this->view->adm->addRecord("ourbank_meeting",$formdata1);
                $this->_redirect('/meetingindex');
                }
        }
// 		} else {
// 		$this->_redirect('index/index');
// 		}
        }

    public function meetingeditAction()
    {
//Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {
                //edit
        $this->view->pageTitle='Meetings';
        $path = $this->view->baseUrl();
        $this->view->title = "Edit Meeting";
        $this->view->meeting_id=$meeting_id = $this->_getParam('meeting_id');
        $meetingForm = new Meeting_Form_Meeting($path);
        $this->view->meetingForm = $meetingForm;
        $meeting = new Meeting_Model_Meeting();

        $office = $meeting->getBranch();
        foreach($office as $office1){
            $meetingForm->institute_bank_id->addMultiOption($office1['id'],$office1['name']);
        }
        $days = $this->view->adm->viewRecord("ourbank_master_weekdays","id","ASC");
        foreach($days as $days) {
            $meetingForm->meeting_day->addMultiOption($days['id'],$days['name']);
        }
        $fetchMeetingDetails=$meeting->fetchMeetingdetailsForID($meeting_id);
//         foreach($fetchMeetingDetails as $meetings1) {}
// //         echo "<script>getGroups('".$meetings1['bank_id']."','".$path."');</script>";
        
        foreach($fetchMeetingDetails as $meetings) {
            $this->view->meetingForm->meeting_name->setValue($meetings['name']);
            $this->view->meetingForm->institute_bank_id->setValue($meetings['village_id']);
            $this->view->meetingForm->group_head->setValue($meetings['grouphead_name']);
            $this->view->meetingForm->meeting_place->setValue($meetings['place']);
            $this->view->meetingForm->meeting_time->setValue($meetings['time']);
            $this->view->meetingForm->meeting_day->setValue($meetings['wid']);

            $formdata2=array('id'=>$meetings['id'],'name'=>$meetings['name'],
                    'village_id'=>$meetings['village_id'],'group_id'=>$meetings['group_id'],
                    'grouphead_name'=>'',
                    'place'=>$meetings['place'],'time'=>$meetings['time'],
                    'day'=>$meetings['wid'],'created_by'=>$meetings['created_by'],
                    'created_date'=>$meetings['created_date']);
        }

        $office=$meeting->fetchGroupnames($meetings['village_id']);
            foreach($office as $office) {
                $meetingForm->group_name->addMultiOption($office['id'],$office['name']);
            }
        $this->view->meetingForm->group_name->setValue($meetings['group_id']);
        $meetingForm->meeting_name->removeValidator('Db_NoRecordExists');

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $id = $this->_getParam('meeting_id');
            $formData = $this->_request->getPost();
            $this->view->meeting_id=$meeting_id = $this->_getParam('meeting_id');
            if ($meetingForm->isValid($formData)) {
                $formdata1=array('name'=>$formData['meeting_name'],
                                    'village_id'=>$formData['institute_bank_id'],
                                    'group_id'=>$formData['group_name'],
                                    'grouphead_name'=> '',
                                    'place'=>$formData['meeting_place'],
                                    'time'=>$formData['meeting_time'],'day'=>$formData['meeting_day'],
                                    'created_by'=>$this->view->createdby);
                $this->view->adm->updateLog("ourbank_meeting_log",$formdata2,$this->view->createdby);
                //update 					
                $this->view->adm->updateRecord("ourbank_meeting",$id,$formdata1);
                $this->_redirect("/meetingindex");
            }
        }
// 		} else {
// 		$this->_redirect('index/index');
// 		}
    }

    public function meetingviewAction() {
    }

    public function meetingdeleteAction() {
        $this->view->pageTitle='Meetings';
//Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {

        $this->view->id=$meeting_id = $this->_getParam('meeting_id');
        $deleteForm=new App_Form_Delete();
        $this->view->deleteForm=$deleteForm;
        if($this->_request->isPost() && $this->_request->getPost('Delete')) {
            $formdata = $this->_request->getPost();
            if($deleteForm->isValid($formdata)) {
                $redirect = $this->view->adm->deleteAction("ourbank_meeting",$this->view->modulename,$this->view->id);
                $this->_redirect("/".$redirect);
            }
        }

// 		} else {
// 		$this->_redirect('index/index');
// 		}
    }

    public function fetchgroupsAction()
    {
        $this->_helper->layout->disableLayout();

        $path = $this->view->baseUrl();
        $meetingForm = new Meeting_Form_Meeting($path);
        $this->view->meetingForm = $meetingForm;
        $officeID=$this->_request->getParam('officeID');

        $meeting = new Meeting_Model_Meeting();
        $office=$meeting->fetchGroupnames($officeID);

        foreach($office as $office) {
            $meetingForm->group_name->addMultiOption($office['id'],$office['name']);
        }
    }

    public function fetchheadnameAction() 
    {
        $this->_helper->layout->disableLayout();

        $path = $this->view->baseUrl();
        $meetingForm = new Meeting_Form_Meeting($path);
        $this->view->meetingForm = $meetingForm;
        $group_id=$this->_request->getParam('group_id');
        $meeting = new Meeting_Model_Meeting();
        $headname=$meeting->fetchHeadName($group_id);
        foreach($headname as $headname1){}
        $this->view->headname=$headname1['member_name'];
    }
}