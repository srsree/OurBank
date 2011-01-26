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

class Enquiry_FeedetailsController extends Zend_Controller_Action
{
    public function init()
    {
       $this->view->pageTitle='Fee Details';
    }
    public function indexAction()
    {
        $sessionName = new Zend_Session_Namespace('ourbank');
        $sessionName->primaryuserid;
        $this->view->title = "Fee Details";

        $searchForm = new Enquiry_Form_Search();
        $this->view->form = $searchForm;

	$oName = new Enquiry_Model_FeeDetails();
	$select = $oName->fetchAllProducts();
	foreach($select as $oName) {
        $searchForm->field1->addMultiOption($oName->offerproduct_id,$oName->offerproductname);
	}

         if ($this->_request->isPost() && $this->_request->getPost('Search')) {
               $formData = $this->_request->getPost();

            if ($this->_request->isPost()) {
                   $fromDate = $this->_request->getParam('field5'); 
                   $toDate = $this->_request->getParam('field6');
                   $productName = $this->_request->getParam('field1');
                   $formData = $this->_request->getPost();

                if ($searchForm->isValid($formData)) {
                    echo "Ramya";

                    $fee = new Enquiry_Model_FeeDetails();
                    $arrayFee = $fee->feeSearch($fromDate,$toDate,$productName);

                      if (!$arrayFee) {
                             echo "<font color='RED'>Records Not Found Please Try Again...</font>";
                            } else {
                            $this->view->feeView = $arrayFee;
                                                        }
                                                }
                                           }
                                    }
                                }
}
