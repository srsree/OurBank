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
class Services_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
//it is create session and implement ACL concept...
        $this->view->pageTitle=$this->view->translate('Services required by the family');
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
        $this->view->title = $this->view->translate("Add loan details");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count number of family members
        $family_model=new Services_Model_services();
        $this->view->loan_details=$count_loan = $family_model->get_servicesdetails();
        $this->view->number=$number=count($count_loan);
//load form with respective to number of family member
        $addForm = new Services_Form_services($number);
        $this->view->form=$addForm;
//set the value of member name and sex

        for($i=1;$i<=$number;$i++){
        foreach($count_loan as $count_loan1){
            $a='services'.$i;
            $b='source_id'.$i;
           $addForm->$a->setValue($count_loan1['name']);
           $addForm->$b->setValue($count_loan1['id']);
            $i++;
         }
        }

//insert the Services details 
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();
            for($i=1;$i<=$number;$i++)
            {	if($this->_request->getParam('whom'.$i)){
                $this->view->adm->addRecord("ourbank_servicedetails",array('id' => '',
                                            'member_id'=>$member_id,
                                            'service_id' => $this->_request->getParam('source_id'.$i),
                                            'to_whom'=>$this->_request->getParam('whom'.$i),
                                            'own_land'=>$this->_request->getParam('fund'.$i),
                                            'recuired_loan_help' => $this->_request->getParam('help'.$i),
                                            'created_date'=>date("y/m/d H:i:s"),
                                            'created_by'=>$this->view->createdby
                                            ));
		}
            }
             $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
        }
    }

//edit family health details
    public function editAction() 
    {
        $this->view->title = $this->view->translate("Edit loan details");
        $this->view->memberid=$member_id=$this->_getParam('id');
//count number of family members
        $family_model=new Services_Model_services();
        $this->view->loan_details=$count_loan = $family_model->get_servicesdetails();
        $this->view->number=$number=count($count_loan);
//load form with respective to number of family member
        $addForm = new Services_Form_services($number);
        $this->view->form=$addForm;
//set the value of member name and sex

        for($i=1;$i<=$number;$i++){
        foreach($count_loan as $count_loan1){
            $a='services'.$i;
            $b='source_id'.$i;
           $addForm->$a->setValue($count_loan1['name']);
           $addForm->$b->setValue($count_loan1['id']);
            $i++;
         }
        }

//set the value of Services details
         $loandetails = $family_model->get_service($member_id); 
        $i=1;
        foreach($loandetails as $loandetails1){ 
        $c='whom'.$loandetails1['service_id'];
        $d='fund'.$loandetails1['service_id'];
        $e='help'.$loandetails1['service_id'];
        $h='record_id'.$i;
        $addForm->$c->setValue($loandetails1['to_whom']);
        $addForm->$d->setValue($loandetails1['own_land']);
        $addForm->$e->setValue($loandetails1['recuired_loan_help']);
        $addForm->$h->setValue($loandetails1['id']);
        $i++;
        }

//update the family health details...
        if ($this->_request->isPost() && $this->_request->getPost('update')) 
        {
           
//update the family health is already exiting...

            $editservice = $family_model->get_service($member_id);
            for ($j = 0 ; $j< count($editservice); $j++) {
                $this->view->adm->addRecord("ourbank_servicedetails_log",$editservice[$j]);
            }
            $family_model->deleteservice($member_id);
            for($i=1;$i<=$number;$i++)
            {	
                if($this->_request->getParam('whom'.$i)){
                $this->view->adm->addRecord("ourbank_servicedetails",array('id' => '',
                                            'member_id'=>$member_id,
                                            'service_id' => $this->_request->getParam('source_id'.$i),
                                            'to_whom'=>$this->_request->getParam('whom'.$i),
                                            'own_land'=>$this->_request->getParam('fund'.$i),
                                            'recuired_loan_help' => $this->_request->getParam('help'.$i),
                                            'created_date'=>date("y/m/d H:i:s"),
                                            'created_by'=>$this->view->createdby
                                            ));
		}
          }
          $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);

        }
	
}
}
