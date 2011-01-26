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
class Education_IndexController extends Zend_Controller_Action 
{
//add and edit of family education details...
    public function init()
    {
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
    
//add family education details...
    public function addAction() 
    {
        $this->view->title = $this->view->translate("Add health information");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count number of family members
        $family_model=new Familydetails_Model_familydetails();
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
//set the name in the education add form 
        $addForm = new Health_Form_health($number);
        $this->view->form=$addForm;
        for($i=1;$i<=$number;$i++){
        foreach($count_member as $family_details){
            $a='name'.$i;
            $e='familymemberid'.$i;
           $addForm->$a->setValue($family_details['name']);
           $addForm->$e->setValue($family_details['id']);
            $i++;
         }
        }
//set the value of qualification details in the drop down list box
        $problem = $this->view->adm->viewRecord("ourbank_qualification","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($problem as $problem1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($problem1['id'],$problem1['qualification']);
        $status=array('01'=>'Far','02'=>'Near');
        $status1=array('01'=>'Available','02'=>'Not available','03'=>'Rearly available');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status1);
        }}

//insert the family education details
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();

            for($i=1;$i<=$number;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $this->view->adm->addRecord("ourbank_familyeducation",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'qualification'=>$health,
                                            'school_location' => $treat,
                                            'transportation'=>$access,
                                            ));
            }
             $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

//edit family education details
    public function editAction() 
    {
        $this->view->title = $this->view->translate("Edit health information");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count family members
        $family_model=new Familydetails_Model_familydetails();
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
//load education form with respective number family members
        $addForm = new Health_Form_health($number);
        $this->view->form=$addForm;
//set the name of family members
        for($i=1;$i<=$number;$i++){
        foreach($count_member as $family_details){
            $a='name'.$i;
            $e='familymemberid'.$i;
           $addForm->$a->setValue($family_details['name']);
           $addForm->$e->setValue($family_details['id']);
            $i++;
         }
        }

//set the qualification details in the drop down lis box...
        $problem = $this->view->adm->viewRecord("ourbank_qualification","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($problem as $problem1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($problem1['id'],$problem1['qualification']);
        $status=array('01'=>'Far','02'=>'Near');
        $status1=array('01'=>'Available','02'=>'Not available','03'=>'Rearly available');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status1);
        }}

//get education details and set the value in the education form...
        $memberhealth=new Education_Model_education();
        $edit_family =$memberhealth->edit_education($member_id);
        $number_health=count($edit_family);
        for($j=1;$j<=$number;$j++){
        foreach($edit_family as $edit_family1){
            $b='health'.$j;
            $c='treatment'.$j;
            $d='accessability'.$j;
           $addForm->$b->setValue($edit_family1['qualification']);
           $addForm->$c->setValue($edit_family1['school_location']);
           $addForm->$d->setValue($edit_family1['transportation']);
            $j++;
         }
        }
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();
//update the family education details
            for($i=1;$i<=$number_health;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $memberhealth->updateeducation($familymember_id,array(
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'qualification'=>$health,
                                            'school_location' => $treat,
                                            'transportation'=>$access,
                                            ));
            }

//insert addtional the family education details
            $k=$number_health+1;
            for($k;$k<=$number;$k++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$k);
                $health=$this->_request->getParam('health'.$k);
                $treat=$this->_request->getParam('treatment'.$k);
                $access=$this->_request->getParam('accessability'.$k);
                $this->view->adm->addRecord("ourbank_familyeducation",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'qualification'=>$health,
                                            'school_location' => $treat,
                                            'transportation'=>$access,
                                            ));
            }
         $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }

    }
}
