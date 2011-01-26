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

class Enquiry_InterestController extends Zend_Controller_Action
{

    public function init()
    {
       $this->view->pageTitle='Repayment of  List';
    }

    public function indexAction() {

       $sessionName = new Zend_Session_Namespace('ourbank');
       $sessionName->primaryuserid;
       $this->view->title = "Transaction Due Amount";

       $searchForm = new Enquiry_Form_Search();
       $this->view->form = $searchForm;

       if ($this->_request->isPost() && $this->_request->getPost('Search')) {
               $formData = $this->_request->getPost();

            if ($this->_request->isPost()) {

                $transaction_date = $this->_request->getParam('field6'); 

                        $transaction = new Enquiry_Model_Interest(); 
                        $transactionDetails = $transaction->fetchTransactionDetails($transaction_date);
                        

                       if (!$transactionDetails) {
                            
                            echo "<font color='RED'>No Transaction has been recorded for this Date</font>";
                                } else {
                     
                                $this->view->transaction = $transactionDetails;
                        }
                  }
            }
        }
    }


