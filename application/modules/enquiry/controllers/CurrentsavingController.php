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

class Enquiry_CurrentsavingController extends Zend_Controller_Action
{

   public function init()
    {
       $this->view->pageTitle='Current Loan List';
    }

    public function indexAction()
    {
        $sessionName = new Zend_Session_Namespace('ourbank');
        $sessionName->primaryuserid;
        $this->view->title = "Current Loan List";

        $searchForm = new Enquiry_Form_Search();
        $this->view->form = $searchForm;

        $first = new Enquiry_Model_CurrentSaving();
        $oName = $first->branchDetails();
        foreach ($oName as $oName) {
            $searchForm->field1->addMultiOption($oName["office_id"],$oName["office_name"]);
	}

        $this->view->depositeAmount = 0;
        $this->view->withdrawlAmount = 0;
        $this->view->totalAmount = 0; 
        $this->view->deposit = 0;
        $this->view->withdrawl = 0;
        $this->view->sum = 0;

         if ($this->_request->isPost() && $this->_request->getPost('Search')) {
               $formData = $this->_request->getPost();
           
             if ($this->_request->isPost()) {

                 $office_id = $this->_request->getParam('field1'); 
                 $first = new Enquiry_Model_CurrentSaving();
                 $result = $first->fetchSavingsDetails($office_id);
                 $this->view->result = $result; 
                    
            $second = new Enquiry_Model_CurrentSaving();
            $accountBalanc = $second->accountBalanceDetails($office_id);
            $this->view->accountBalanc = $accountBalanc;

            if (!$result && !$accountBalanc) {
                 echo "<font color='RED' size = '3'>No Savings Account</font>";	
            } else {
                foreach($result as $result1) {
                    $this->view->officeName = $result1["office_name"];
                }

            }

        } else {
            $office_id = $this->_request->getParam('field1'); 

            $first = new Enquiry_Model_CurrentSaving();
            $result = $first->SavingsDetails();
            $this->view->result = $result; 

            $second = new Enquiry_Model_CurrentSaving();
            $accountBalanc = $second->accountBalance();
            $this->view->accountBalanc = $accountBalanc;
         }
     }
  }
}

