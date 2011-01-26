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
class Enquiry_LoanconsolidationController extends Zend_Controller_Action
{
   public function init()
    {
       $this->view->pageTitle='Loan Consolidation';
    }

    public function indexAction()
    {
        $sessionName = new Zend_Session_Namespace('ourbank');
        $sessionName->primaryuserid;
        $this->view->title = "Consolidation of Loan";

                    $this->view->title = "Consolidation of Loan Amount with Interest";
		    $first = new Enquiry_Model_Loanconsolidation();//sending the input data in array for 4 fields in search
		    $loanDetails = $first->fetchloanDetails();
                    $this->view->loanDetails = $loanDetails;
               	    $period = $first->fetchPeriod();
                    $this->view->period = $period;


    }

}

