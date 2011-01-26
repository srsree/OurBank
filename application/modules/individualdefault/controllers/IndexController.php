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

//add, view, delete individual members 
class Individualdefault_IndexController extends Zend_Controller_Action 
{
    //create a session and create common object modules
    public function init() 
    {
        $test = new DH_ClassInfo(APPLICATION_PATH . '/modules/activity/controllers/');
        $this->view->pageTitle=$this->view->translate('Individual');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//         $this->_redirect('index/logout');
//         }
        $module = $test->getControllerClassNames();
        $modulename = explode("_", $module[0]);
        $this->view->modulename = strtolower($modulename[0]);
        $this->view->adm = new App_Model_Adm();
        $individualcommon=new Individualmcommonview_Model_individualmcommonview();
//get the module id and submodule id
        $module=$individualcommon->getmodule('Individualm');
        foreach($module as $module_id){ }
        $this->view->mod_id=$module_id['parent'];
        $this->view->sub_id=$module_id['module_id'];
    }

    public function indexAction() 
    {}

//add individual member
    public function addmembernameAction()
    {
        //Acl
        //$access = new App_Model_Access();
        //$checkaccess = $access->accessRights('Individual',$this->view->globalvalue[0]['name'],'addmembernameAction');
        //if (($checkaccess != NULL)) {
        //add Action
        $this->view->title = $this->view->translate("Individual details");;
//load form for individual
        $addForm = new Individualdefault_Form_individualdefault();
        $this->view->form=$addForm;
        $convertdate = new Creditline_Model_dateConvertor();
//load gender details in the drop down list box
        $gender = $this->view->adm->viewRecord("gender","id","DESC");
        foreach($gender as $genderresult){
        $addForm->gender_id->addMultiOption($genderresult['id'],$genderresult['sex']);
        }
//load office names in the drop down list box
        $individual = new Individualm_Model_Individualm();
        $max_id=$individual->getoffice_hierarchy();
        $maxlevel=$max_id[0]['id'];
        $officename=$individual->getoffice($maxlevel);
        foreach($officename as $officename1){
        $addForm->office->addMultiOption($officename1['office_id'],$officename1['name']);
        }

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) 
        {
            $formData = $this->_request->getPost();
            if($addForm->isValid($formData))
            {
// add individual member
                $subOffice = $this->_request->getParam('office');
                $member_dob=$this->_request->getParam('memberdateofbirth');
                $memberfirstname = $this->_request->getParam('memberfirstname');
                $membergender = $this->_request->getParam('gender_id');
                $mobile=$this->_request->getParam('mobile');
                $date=date("y/m/d H:i:s");
                $lastid = $this->view->adm->addRecord("ourbank_member",array('id' => '',
                                                'office_id'=>$subOffice,
                                                'name' => $memberfirstname,
                                                'dateofbirth'=>$convertdate->phpmysqlformat($member_dob),
                                                'gender' => $membergender, 'mobile'=>$mobile,
                                                'created_date' =>$date,'created_by'=>$this->view->createdby));
//create a member code
                $o=str_pad($subOffice,3,"0",STR_PAD_LEFT);
                $p = "01";
                $u=str_pad($lastid,6,"0",STR_PAD_LEFT);
                $membercode=$o.$p.$u;
                $this->view->adm->updateRecord("ourbank_member",$lastid,array('membercode'=>$membercode));
//create a saving account number 
                $product=new Individualdefault_Model_individualdefault();
                $saving=$product->productoffers("Saving for individual");
                $product_id=$saving[0]['product_id'];
                $lastid1 = $this->view->adm->addRecord("ourbank_accounts",array('id' => '',
                                'member_id'=>$lastid,
                                'product_id' => $product_id,
                                'accountcreated_date' => $date, 
                                'membertype_id'=>'1',
                                'created_date' =>$date,
                                'created_by'=>$this->view->createdby,'status_id'=>'3'));
                $u1=str_pad($lastid1,5,"0",STR_PAD_LEFT);
                $p1="0".$product_id;
                $accountno=$o.$p.$p1."S".$u1;
                $this->view->adm->updateRecord("ourbank_accounts",$lastid1,array('account_number'=>$accountno));

               $this->_redirect('/individualmcommonview/index/commonview/id/'.$lastid);
            }
        }	
// 	} else {
//             $this->_redirect('index/index');
// 	}	

    }

//edit individual member 
    public function editmembernameAction()
    {
        //Acl
        //$access = new App_Model_Access();
        //$checkaccess = $access->accessRights('Individual',$this->view->globalvalue[0]['name'],'editmembernameAction');
        //if (($checkaccess != NULL)) {

        $member_id=$this->_getParam('id');
        $this->view->memberid=$member_id;
        $this->view->title = $this->view->translate("Edit member details"); 

//load individual form
        $addForm = new Individualdefault_Form_individualdefault();
        $convertdate = new Creditline_Model_dateConvertor();
        $this->view->form=$addForm;

//load gender and office names in the drop down list box
        $gender = $this->view->adm->viewRecord("gender","id","DESC");
        foreach($gender as $genderresult){
            $addForm->gender_id->addMultiOption($genderresult['id'],$genderresult['sex']);
        }
         $individual = new Individualm_Model_Individualm();
        $max_id=$individual->getoffice_hierarchy();
        $maxlevel=$max_id[0]['id'];
        $officename=$individual->getoffice($maxlevel);
        foreach($officename as $officename1){
        $addForm->office->addMultiOption($officename1['office_id'],$officename1['name']);
        }

//set the individual member value in the edit form
        $edit_member = $this->view->adm->editRecord("ourbank_member",$member_id);
        foreach($edit_member as $editmembername)
        {
            $this->view->form->memberdateofbirth->setValue($convertdate->phpnormalformat($editmembername['dateofbirth']));
            $this->view->form->office->setValue($editmembername['office_id']);
            $this->view->form->memberfirstname->setValue($editmembername['name']);
            $this->view->form->gender_id->setValue($editmembername['gender']);
            $this->view->form->mobile->setValue($editmembername['mobile']);
        }

//update individual member details
        if ($this->_request->isPost() && $this->_request->getPost('Update')) 
        {
            $formData = $this->_request->getPost();
            if($addForm->isValid($formData))
            {
            $olddate = $this->view->adm->editRecord("ourbank_member",$member_id);
            $this->view->adm->updateLog("ourbank_member_log",$olddate[0],$this->view->createdby);
            $office=$this->_request->getParam('office');
            $member_dob=$this->_request->getParam('memberdateofbirth');
            $memberfirstname = $this->_request->getParam('memberfirstname');
            $membergender = $this->_request->getParam('gender_id');
            $mobile=$this->_request->getParam('mobile');
            $date=date("y/m/d H:i:s");
            foreach($olddate as $olddate)
            $olddate['membercode'];
            $this->view->adm->updateRecord("ourbank_member",$member_id,array('id' => $member_id,
                            'office_id'=>$office,
                            'membercode'=>$olddate['membercode'],
                            'name' => $memberfirstname,
                            'dateofbirth'=>$convertdate->phpmysqlformat($member_dob),
                            'gender' => $membergender,'mobile'=>$mobile,
                            'created_date' =>$date,'created_by'=>$this->view->createdby));

            $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
            }
        }
        // // 	} else {
        // //             $this->_redirect('index/index');}
    }

    public function viewmemberAction()
    {
    }

//delete individual member 
    public function deletememberAction()
    {
        //Acl
        //$access = new App_Model_Access();
        //$checkaccess = $access->accessRights('Individual',$this->view->globalvalue[0]['name'],'editmembernameAction');
        //if (($checkaccess != NULL)) {
        //delete action
    
        $id=$this->_request->getParam('id'); 
        $this->view->memberid=$id;
        $individualcommon=new Individualcommonview_Model_individualcommon;
        $member_name=$individualcommon->getmember($id);
        $this->view->membername=$member_name;

//load delete form 
        $delform=new Membername_Form_Delete();
        $this->view->delete=$delform;
        if ($this->_request->isPost() && $this->_request->getPost('Submit'))
        {
            $formdata = $this->_request->getPost();
            //print_r($formdata);
            if($delform->isValid($formdata)) 
            { 
            $delete=new Individualdefault_Model_individualdefault();
            $account=$delete->findaccount($id);
//delete member details, contact and address details...
            if(!$account){
            $this->view->adm->deletemember("ourbank_member",$id);
            $this->view->adm->deleteSubmodule("contact",$id,$this->view->sub_id);
            $this->view->adm->deleteSubmodule("address",$id,$this->view->sub_id);
            $family=$delete->getfamilydetails('ourbank_family',$id);
            $economic=$delete->getfamilydetails('ourbank_familyeconomic',$id);
            $education=$delete->getfamilydetails('ourbank_familyeducation',$id);
            $health=$delete->getfamilydetails('ourbank_familyhealth',$id);
            $familyno=count($family);

//add old data in the log tables.
            for($i=0;$i<$familyno;$i++)
            {
                $delete->updateLog("ourbank_family_log",$family[$i]);
                $delete->updateLog("ourbank_familyeconomic_log",$economic[$i]);
                $delete->updateLog("ourbank_familyeducation_log",$education[$i]);
                $delete->updateLog("ourbank_familyhealth_log",$health[$i]);
            }
//delete family details, health, education, economic details...
            $delete->deleteRecord("ourbank_family",$id);
            $delete->deleteRecord("ourbank_familyeconomic",$id);
            $delete->deleteRecord("ourbank_familyeducation",$id);
            $delete->deleteRecord("ourbank_familyhealth",$id);
            $this->_redirect('/individualm');
            }
             else
                { echo "<font color=red>This member having active accounts</font>";
                }
            }
        }	
        // 	} else {
        //             $this->_redirect('index/index');
        // 	}
    }


}

