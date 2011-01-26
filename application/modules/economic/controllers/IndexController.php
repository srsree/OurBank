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
class Economic_IndexController extends Zend_Controller_Action 
{
//add and edit of family economic details...
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

//add family economic details...
    public function addAction() 
    {
        $this->view->title = $this->view->translate("Add health information");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count number of family members
        $family_model=new Familydetails_Model_familydetails();
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
        $addForm = new Health_Form_health($number);
        $this->view->form=$addForm;
//set the name in the economic add form 
        for($i=1;$i<=$number;$i++){
        foreach($count_member as $family_details){
            $a='name'.$i;
            $e='familymemberid'.$i;
           $addForm->$a->setValue($family_details['name']);
           $addForm->$e->setValue($family_details['id']);
            $i++;
         }
        }
//set the value of profession details in the drop down list box
        $occupation = $this->view->adm->viewRecord("ourbank_profession","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($occupation as $occupation1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($occupation1['id'],$occupation1['profession']);
        $status=array('01'=>'Yes','02'=>'No');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status);
        }}

//insert the family economic details
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();

            for($i=1;$i<=$number;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $this->view->adm->addRecord("ourbank_familyeconomic",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'profession'=>$health,
                                            'earnings' => $treat,
                                            'benefits'=>$access,
                                            ));
            }
             $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

//edit family economic details
    public function editAction() 
    {
        $this->view->title = $this->view->translate("Edit health information");;
        $this->view->memberid=$member_id=$this->_getParam('id');
//count family members
        $family_model=new Familydetails_Model_familydetails();
        $this->view->famil_details=$count_member = $family_model->edit_family($member_id);
        $this->view->family_number=$number=count($count_member);
//load economic form with respective number family members
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

//set the profession details in the drop down lis box...
        $occupation = $this->view->adm->viewRecord("ourbank_profession","id","DESC");
        for($i=1;$i<=$number;$i++){
        foreach($occupation as $occupation1){ 
        $health_id = "health".$i;
        $treatment_id="treatment".$i;
        $accessibility="accessability".$i;
        $addForm->$health_id->addMultiOption($occupation1['id'],$occupation1['profession']);
        $status=array('01'=>'Yes','02'=>'No');
        $addForm->$treatment_id->addMultiOptions($status);
        $addForm->$accessibility->addMultiOptions($status);
        }}

//get economic details and set the value in the economic form...
        $memberhealth=new Economic_Model_economic();
        $edit_family =$memberhealth->edit_economic($member_id);
        $number_health=count($edit_family);
        for($j=1;$j<=$number;$j++){
        foreach($edit_family as $edit_family1){
            $b='health'.$j;
            $c='treatment'.$j;
            $d='accessability'.$j;
           $addForm->$b->setValue($edit_family1['profession']);
           $addForm->$c->setValue($edit_family1['earnings']);
           $addForm->$d->setValue($edit_family1['benefits']);
            $j++;
         }
        }

        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();
//update the family economic details
            for($i=1;$i<=$number_health;$i++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$i);
                $health=$this->_request->getParam('health'.$i);
                $treat=$this->_request->getParam('treatment'.$i);
                $access=$this->_request->getParam('accessability'.$i);
                $memberhealth->updateeconomic($familymember_id,array(
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'profession'=>$health,
                                            'earnings' => $treat,
                                            'benefits'=>$access,
                                            ));
            }

//insert addtional the family economic details
            $k=$number_health+1;
            for($k;$k<=$number;$k++)
            {   $familymember_id=$this->_request->getParam('familymemberid'.$k);
                $health=$this->_request->getParam('health'.$k);
                $treat=$this->_request->getParam('treatment'.$k);
                $access=$this->_request->getParam('accessability'.$k);
                $this->view->adm->addRecord("ourbank_familyeconomic",array('id' => '',
                                            'familymember_id'=>$familymember_id,
                                            'member_id' => $member_id,
                                            'profession'=>$health,
                                            'earnings' => $treat,
                                            'benefits'=>$access,
                                            ));
            }
         $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }

    }
}
