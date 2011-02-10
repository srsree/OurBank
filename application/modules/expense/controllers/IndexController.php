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
class Expense_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
//it is create session and implement ACL concept...
        $this->view->pageTitle=$this->view->translate('Expense details');
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
        $this->view->title = $this->view->translate("Add expense details");
        $this->view->memberid=$member_id=$this->_getParam('id');
        $this->view->submoduleid = $this->_getParam('subId');

//count number of family members
        $db_model=new Expense_Model_expense();
        $this->view->expense_details=$count_expense = $db_model->getexpensetypes();
        $this->view->number=$number=count($count_expense);
// //load form with respective to number of family member
        $addForm = new Expense_Form_expense($number);
        $this->view->form=$addForm;
// //set the value of member name and sex
        for($i=1;$i<=$number;$i++){
        foreach($count_expense as $count_expense1){
            $b='source_id'.$i;
            $addForm->$b->setValue($count_expense1['id']);
            $i++;
         }
        }

// //insert the expense details 
        if ($this->_request->isPost() && $this->_request->getPost('submit')) 
        {

        $submoduleid = $this->_getParam('subId');

            $formData = $this->_request->getPost();
            for($i=1;$i<=$number;$i++)
            {	if($this->_request->getParam('value'.$i)){
                $this->view->adm->addRecord("ourbank_expensedetails",
                                            array('id' => '',
                                            'submodule_id' => $submoduleid,
                                            'member_id'=>$member_id,
                                            'expense_id'=>$this->_request->getParam('source_id'.$i),
                                            'value'=>$this->_request->getParam('value'.$i),
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
        $this->view->title = $this->view->translate("Edit expense information");
        $this->view->memberid=$member_id=$this->_getParam('id');
        $this->view->submoduleid = $submoduleid = $this->_getParam('subId');

//count number of family members
        $db_model=new Expense_Model_expense();
        $this->view->expense_details=$count_expense = $db_model->getexpensetypes();
        $this->view->number=$number=count($count_expense);

// //load form with respective to number of family member
        $addForm = new Expense_Form_expense($number);
        $this->view->form=$addForm;

//set the value of member name and sex

        for($i=1;$i<=$number;$i++){
        foreach($count_expense as $count_expense1){
           $b='source_id'.$i;
           $addForm->$b->setValue($count_expense1['id']);
            $i++;
         }
        }


// // //set the value of expense...
        $expensedetails = $db_model->get_expensedetails($member_id); 
        $i=1;
        foreach($expensedetails as $expensedetails1){ 
        $c='value'.$expensedetails1['expense_id'];
        $d='source_id'.$i;
        $addForm->$c->setValue($expensedetails1['value']);
        $addForm->$d->setValue($expensedetails1['expense_id']);
        $i++;
        }

// //update the family health details...
        if ($this->_request->isPost() && $this->_request->getPost('update')) 
        {
            $submoduleid = $this->_getParam('subId');

            $expense_db = new Expense_Model_expense ();
            $editExpense = $expense_db->get_expensedetails($member_id);
            for ($j = 0 ; $j< count($editExpense); $j++) {
                $this->view->adm->addRecord("ourbank_expensedetails_log",$editExpense[$j]);
            }
            $expense_db->deleteexpense($member_id);
            for($i=1;$i<=$number;$i++)
            {	if($this->_request->getParam('value'.$i)){
                $this->view->adm->addRecord("ourbank_expensedetails",
                                            array('id' => '',
                                            'submodule_id' => $submoduleid,
                                            'member_id'=>$member_id,
                                            'expense_id'=>$this->_request->getParam('source_id'.$i),
                                            'value'=>$this->_request->getParam('value'.$i),
                                            'created_date'=>date("y/m/d H:i:s"),
                                            'created_by'=>$this->view->createdby
                                            ));
		}
            }
                 $this->_redirect('/individualmcommonview/index/commonview/id/'.$member_id);
		}

        }
	
}
