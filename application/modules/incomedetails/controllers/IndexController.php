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
class Incomedetails_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
//it is create session and implement ACL concept...
        $this->view->pageTitle=$this->view->translate('Income details');
        $globalsession = new App_Model_Users();
//         $this->view->globalvalue = $globalsession->getSession();
//         $this->view->createdby = $this->view->globalvalue[0]['id'];
        $sessionName = new Zend_Session_Namespace('ourbank');
        $this->view->createdby = $sessionName->primaryuserid;
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

        $this->view->title = $this->view->translate("Add Income details");
        $this->view->memberid=$member_id=$this->_getParam('id');
	$this->view->submoduleid =$moduleid= $this->_getParam('subId');
	//count number of family members
        $family_model=new incomedetails_Model_incomedetails();
        $this->view->loan_details=$count_loan = $family_model->editIncometypes();
        $this->view->number=$number=count($count_loan);
	//load form with respective to number of family member
        $addForm = new incomedetails_Form_incomedetails($number);
        $this->view->form=$addForm;
	//set the value of member name and sex
	
        for($i=1;$i<=$number;$i++){
        foreach($count_loan as $count_loan1){
            $a='source'.$i;
            $b='source_id'.$i;
           $addForm->$a->setValue($count_loan1['name']);
           $addForm->$b->setValue($count_loan1['id']);
            $i++;
         }
        }

	//insert the family health details 
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {
            $formData = $this->_request->getPost();
	   $moduleid= $this->_getParam('subid');
            for($i=1;$i<=$number;$i++)
            {	if($this->_request->getParam('incomeamount'.$i)){
                $this->view->adm->addRecord("ourbank_incomedetails",array('id' => '',
                                            'member_id'=>$member_id,
                                            'submodule_id'=>$moduleid ,
                                            'income_id'=>$this->_request->getParam('source_id'.$i),
                                            'value' => $this->_request->getParam('incomeamount'.$i),
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

	$moduleid= $this->_getParam('subId');
        $this->view->title = $this->view->translate("Edit Income Details");
        $this->view->memberid=$member_id=$this->_getParam('id');
	$this->view->submoduleid =$moduleid= $this->_getParam('subId');
	//count number of family members
        $family_model=new incomedetails_Model_incomedetails();
        $this->view->loan_details=$count_income = $family_model->editIncometypes();
        $this->view->number=$number=count($count_income);
	//load form with respective to number of family member
        $addForm = new incomedetails_Form_incomedetails($number);
        $this->view->form=$addForm;
	//set the value of member name and sex

        for($i=1;$i<=$number;$i++){
        foreach($count_income as $count_income1){
            $a='source'.$i;
            $b='source_id'.$i;
           $addForm->$a->setValue($count_income1['name']);
           $addForm->$b->setValue($count_income1['id']);
            $i++;
         }
        }

	// // //set the value of expense...
        $detailsdetails = $family_model->getIncomedetails($member_id); 
        $i=1;
        foreach($detailsdetails as $detailsdetails1){ 
        $c='incomeamount'.$detailsdetails1['income_id'];
        $d='source_id'.$i;
        $addForm->$c->setValue($detailsdetails1['value']);
        $addForm->$d->setValue($detailsdetails1['income_id']);
        $i++;
        }

	//update the family health details...
        if ($this->_request->isPost() && $this->_request->getPost('update')) 
        {
		$moduleid= $this->_getParam('subid');  
 		$expense_db = new Incomedetails_Model_Incomedetails ();
            $editExpense = $expense_db->getIncomedetails($member_id);
            for ($j = 0 ; $j< count($editExpense); $j++) {
                $this->view->adm->addRecord("ourbank_incomedetails_log",$editExpense[$j]);
            }
            $expense_db->deleteincome($member_id);


	    for($i=1;$i<=$number;$i++)
            {	if($this->_request->getParam('incomeamount'.$i)){
                $this->view->adm->addRecord("ourbank_incomedetails",array('id' => '',
                                            'member_id'=>$member_id,
                                            'submodule_id'=>$moduleid ,
                                            'income_id'=>$this->_request->getParam('source_id'.$i),
                                            'value' => $this->_request->getParam('incomeamount'.$i),
                                            'created_date'=>date("y/m/d H:i:s"),
                                            'created_by'=>$this->view->createdby
                                            ));
		}
		}
                 $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
		}
        }
	
}
