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

class Familymembers_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
        $this->view->pageTitle=$this->view->translate('Membership');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
	$this->view->createdby = $this->view->globalvalue[0]['id'];
        //$this->view->username = $this->view->globalvalue[0]['username'];
        //if (($this->view->globalvalue[0]['id'] == 0)) {
            //$this->_redirect('index/logout');
        //}
        //getting module name and change the side bar dynamically 
        $this->view->id=$subId=$this->_getParam('id');
        $this->view->subId=$subId=$this->_getParam('subId');
        $this->view->modId=$modId=$this->_getParam('modId');
        $addressmodel=new Individualmcommonview_Model_individualmcommonview();
        $module_name=$addressmodel->getmodule($subId);
        foreach($module_name as $module_view)
        {
            $address=$module_view['module_description'];
        }
        $this->view->pageTitle='Family members details';
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

    public function addfamilyAction() 
    {
        $this->view->title=$this->view->translate('Add family members');
        //load contact details form with two arguments ...
        $form = new Familymembers_Form_Familymembers($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->memberid=$member_id=$this->_getParam('id');
        $subid = $this->view->subId = $this->_getParam('subId');
        $this->view->form=$form;
        $this->view->submitform = new Bank_Form_Submit();
        //dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view) {
            $path1=$module_view['module_description'].'commonview';
        }
        $path1= $this->view->path1=strtolower($path1);

        $this->view->relation = $this->view->adm->viewRecord("ourbank_master_realtionshiptype","id","DESC");
        $this->view->qualify = $this->view->adm->viewRecord("ourbank_master_educationtype","id","DESC");
        $this->view->gender = $this->view->adm->viewRecord("ourbank_master_gender","id","DESC");
        $this->view->skill = $this->view->adm->viewRecord("ourbank_master_skills","id","DESC");
        $this->view->marital = $this->view->adm->viewRecord("ourbank_master_maritalstatus","id","DESC");
        $this->view->proffession = $this->view->adm->viewRecord("ourbank_master_profession","id","DESC");



        if ($this->_request->getPost('submit')) {
            $member_id=$this->_getParam('id');
            $mem_name=$this->_getParam('mem_name');
            $education=$this->_getParam('education');
            $relation=$this->_getParam('relation');
            $age=$this->_getParam('age');
            $gender = $this->_getParam('gender');
            $proffesion = $this->_getParam('proffesion');
            $skill = $this->_getParam('skill');
            $banckAccount = $this->_getParam('banckAccount');
            $dob = $this->_getParam('dob');
            $joinedshg = $this->_getParam('joinedshg');
            $marital = $this->_getParam('marital');

            $countname = count($mem_name);

            for($i = 0; $i< $countname; $i++) 
            {
                $familymembers = array('name' => $mem_name[$i],
                                    'member_id' => $member_id,
                                    'gender_id' => $gender[$i],
                                    'age' => $age[$i],
                                    'relationship_id' => $relation[$i],
                                    'physicalstatus_id' => '1',
                                    'maritalstatus_id' => $marital[$i],
                                    'eductaion_id' => $education[$i],
                                    'profession_id' => $proffesion[$i],
                                    'skill' => $skill[$i],
                                    'bank_ac' => '1',
                                    'date_of_birth' => $dob[$i],
                                    'joined_shg' => '1');
                $this->view->adm->addRecord("ourbank_family",$familymembers);
            }

            $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

    //editing contact details
    public function editfamilyAction()
    {
        $this->view->title=$this->view->translate('Edit Contact');
        //load contact details form with two arguments ...
        $form = new Crop_Form_Crop($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form = $form;
        $this->view->id = $this->_getParam('id');
        $subid = $this->view->subId = $this->_getParam('subId');
        $this->view->submitform = new Bank_Form_Submit();
        //dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view) {
            $path1=$module_view['module_description'].'commonview';
        }
        $path1= $this->view->path1=strtolower($path1);

        $familyobj = new Familymembers_Model_Familymembers();

//         echo "<pre>";print_r($family);
        $this->view->relation = $this->view->adm->viewRecord("ourbank_master_realtionshiptype","id","DESC");
        $this->view->qualify = $this->view->adm->viewRecord("ourbank_master_educationtype","id","DESC");
        $this->view->gender = $this->view->adm->viewRecord("ourbank_master_gender","id","DESC");
        $this->view->skill = $this->view->adm->viewRecord("ourbank_master_profession","id","DESC");
        $this->view->marital = $this->view->adm->viewRecord("ourbank_master_maritalstatus","id","DESC");
        $this->view->proffession = $this->view->adm->viewRecord("ourbank_master_profession","id","DESC");
        $family = $this->view->familydetails = $familyobj->getfamilydetails($this->view->id);
        //update contact details
        if ($this->_request->getPost('Update')) {
            $id=$this->_getParam('id');
            $family = $this->view->familydetails = $familyobj->getfamilydetails1($id);   
            $count = count($family);
            for ($j = 0 ; $j< $count; $j++) {
                $this->view->adm->addRecord("ourbank_family_log",$family[$j]);
            }
            $familyobj->deleteFamily("ourbank_family",$id);
            $member_id=$this->_getParam('id');
            $mem_name=$this->_getParam('mem_name');
            $education=$this->_getParam('education');
            $relation=$this->_getParam('relation');
            $age=$this->_getParam('age');
            $gender = $this->_getParam('gender');
            $proffesion = $this->_getParam('proffesion');
            $skill = $this->_getParam('skill');
            $banckAccount = $this->_getParam('banckAccount');
            $dob = $this->_getParam('dob');
            $joinedshg = $this->_getParam('joinedshg');
            $marital = $this->_getParam('marital');

            $count1 = count($mem_name);
            for($i = 0; $i< $count1; $i++) 
            {
                $familymembers = array('name' => $mem_name[$i],
                                    'member_id' => $member_id,
                                    'gender_id' => $gender[$i],
                                    'age' => $age[$i],
                                    'relationship_id' => $relation[$i],
                                    'physicalstatus_id' => '1',
                                    'maritalstatus_id' => $marital[$i],
                                    'eductaion_id' => $education[$i],
                                    'profession_id' => $proffesion[$i],
                                    'skill' => $skill[$i],
                                    'bank_ac' => '1',
                                    'date_of_birth' => $dob[$i],
                                    'joined_shg' => '1');
                $this->view->adm->addRecord("ourbank_family",$familymembers);
            }
            $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }
}
