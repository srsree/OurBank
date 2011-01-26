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
class Summaryloan_IndexController extends Zend_Controller_Action 
{
 function init()
     { 
      	$this->view->pageTitle = "Summary Loan Outstanding Details";
        $this->view->tilte = "Reports";
        $this->view->type=$this->_request->getParam('type');
        $sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid;
        $login=new App_Model_Users();
        $loginname=$login->username($userid);
        foreach($loginname as $loginname) {
          $this->view->username=$loginname['username'];
       }

     }
     function indexAction()
     {
        $this->view->pageTitle = "Summary Loan";
        $searchForm = new Summaryloan_Form_Search();
        $this->view->form = $searchForm;

//         $individual = new Membership_Model_Individual();
// 
//         $subBranch = $individual->getBranchOffice();
//         foreach($subBranch as $subBranch) {
//                 $searchForm->field1->addMultiOption($subBranch->office_id,$subBranch->office_name);
//         }

	 if ($this->_request->isPost()) {
            $sub1 = $this->_request->getPost('Search');
	    if($sub1 == "Search") {	
               $fromDate = $this->_request->getParam('field3'); 
               $toDate = $this->_request->getParam('field2');
               $brancId = $this->_request->getParam('field1');
               
               $summaryloans = new Reports_Model_Summaryloans();
	       $accountLoan = $summaryloans->accountloandetailsSearch(array('office_id' => $brancId,
                                                          'accountinstallment_date1' => $fromDate,
                                                          'accountinstallment_date' => $toDate));
    
                $Loan = $summaryloans->accountdetailsSearch(array('office_id' => $brancId));
                if (!$Loan) {
                     echo "<font color='RED'>Records Not Found Please Try Again...</font>";	
                } else {
                      $amountPaid = 0;
                      $this->view->Loan = $Loan;
                      $this->view->accountLoan = $accountLoan;
               }
            }
        }
        $sub1 = $this->_request->getPost('Search');
	if($sub1!= "Search") {	
            $summaryloans = new Summaryloan_Model_Summaryloan();
            $accountLoan = $summaryloans->accountloandetails();
            $Loan = $summaryloans->accountdetails();
            $this->view->Loan = $Loan;
            $this->view->accountLoan = $accountLoan;
        }
    }

}

