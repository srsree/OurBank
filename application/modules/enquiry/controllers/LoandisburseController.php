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

class Enquiry_LoandisburseController extends Zend_Controller_Action
{

   public function init()
    {
       $this->view->pageTitle='Loan Enquiry';
    }

    public function indexAction()
    {
        $sessionName = new Zend_Session_Namespace('ourbank');
        $sessionName->primaryuserid;
        $this->view->title = "loan Enquiry";

        $searchForm = new Enquiry_Form_Search();
        $this->view->form = $searchForm;

        $oName = new Enquiry_Model_LoanDisburse();
        //print_r($oName);
        $select = $oName->fetchAllOffice();
      	foreach($select as $oName) {
	    $searchForm->field1->addMultiOption($oName->office_id,$oName->office_name);

            }

        $oName = new Enquiry_Model_LoanDisburse();
        $select = $oName->fetchAllUsers();
        foreach($select as $oName) {
        $searchForm->field7->addMultiOption($oName->user_id,$oName->firstname);
              }

         if ($this->_request->isPost() && $this->_request->getPost('Search')) {

              $brancId = $this->_request->getParam('field1');
	      $createdBy = $this->_request->getParam('field7');
              $formData = $this->_request->getPost();
            
                    $oName = new Enquiry_Model_LoanDisburse();
                    $arrayLoan = $oName->loanSearch($brancId,$createdBy);
                    
                    if (!$arrayLoan) {
                        echo "<font color='RED'>Records Not Found Please Try Again...</font>";	
                    } else {
                        $this->view->loanView = $arrayLoan;
     }
  }   
}
}





