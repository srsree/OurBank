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
class Health_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
//it is create session and implement ACL concept...
        $this->view->pageTitle=$this->view->translate('Individual member');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

//add family health add action
    public function addAction() 
    {
        $this->view->title = $this->view->translate("Add health information");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count number of family members
        $family_model=new Familydetails_Model_familydetails();
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
//load form with respective to number of family member
        $addForm = new Health_Form_health($number);
        $this->view->form=$addForm;
//set the value of member name and sex
        for($i=1;$i<=$number;$i++){
        foreach($count_member as $family_details){
            $a='name'.$i;
            $e='familymemberid'.$i;
           $addForm->$a->setValue($family_details['name']);
           $addForm->$e->setValue($family_details['id']);
            $i++;
         }
        }
//set the value of health problem and other drop down box...
        $problem = $this->view->adm->viewRecord("ourbank_health_problem","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($problem as $problem1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($problem1['id'],$problem1['health_problem']);
        $status=array('01'=>'Yes','02'=>'No');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status);
        }}
//insert the family health details 
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();

            for($i=1;$i<=$number;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $this->view->adm->addRecord("ourbank_familyhealth",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'health_problem'=>$health,
                                            'under_treatment' => $treat,
                                            'clinical_accessability'=>$access,
                                            ));
            }
             $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

//edit family health details
    public function editAction() 
    {
        $this->view->title = $this->view->translate("Edit health information");
        $this->view->memberid=$member_id=$this->_getParam('id');
        $family_model=new Familydetails_Model_familydetails();
//count the number of family members
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
//load the edit form with respective the family member...
        $addForm = new Health_Form_health($number);
        $this->view->form=$addForm;
//set the value of member name and sex
        for($i=1;$i<=$number;$i++){
        foreach($count_member as $family_details){
            $a='name'.$i;
            $e='familymemberid'.$i;
           $addForm->$a->setValue($family_details['name']);
           $addForm->$e->setValue($family_details['id']);
            $i++;
         }
        }

//set the value of health problem and other drop down box...
        $problem = $this->view->adm->viewRecord("ourbank_health_problem","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($problem as $problem1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($problem1['id'],$problem1['health_problem']);
        $status=array('01'=>'Yes','02'=>'No');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status);
        }}
//get the member health details and set health details in the edit form...
        $memberhealth=new Health_Model_health();
        $edit_family =$memberhealth->edit_health($member_id);
        $number_health=count($edit_family);
        for($j=1;$j<=$number;$j++){
        foreach($edit_family as $edit_family1){
            $b='health'.$j;
            $c='treatment'.$j;
            $d='accessability'.$j;
           $addForm->$b->setValue($edit_family1['health_problem']);
           $addForm->$c->setValue($edit_family1['under_treatment']);
           $addForm->$d->setValue($edit_family1['clinical_accessability']);
            $j++;
         }
        }

//update the family health details...
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();
//update the family health is already exiting...
            for($i=1;$i<=$number_health;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $memberhealth->updatehealth($familymember_id,array(
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'health_problem'=>$health,
                                            'under_treatment' => $treat,
                                            'clinical_accessability'=>$access,
                                            ));
            }
//insert addtional health details...
            $k=$number_health+1;
            for($k;$k<=$number;$k++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$k);
                $health=$this->_request->getParam('health'.$k);
                $treat=$this->_request->getParam('treatment'.$k);
                $access=$this->_request->getParam('accessability'.$k);
                $this->view->adm->addRecord("ourbank_familyhealth",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'health_problem'=>$health,
                                            'under_treatment' => $treat,
                                            'clinical_accessability'=>$access,
                                            ));
            }
         $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }

    }
}
