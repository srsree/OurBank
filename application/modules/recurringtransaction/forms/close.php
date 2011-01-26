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
/**Loan Disbursement Module
This Class will
-Create an disbursement form having 3 fields namely date description n disbursed amount
*/
class Transaction_Form_close extends Zend_Form
    {
		public function __construct($options = null)
		{
			parent::__construct($options);
            $accountCode= new Zend_Form_Element_Hidden('accountcode');
            $memberId = new Zend_Form_Element_Hidden('membercode');
			$categoryId = new Zend_Form_Element_Hidden('categoryId');


			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);

			$totalamount = new Zend_Form_Element_Text('totalamount');
			$totalamount->setAttrib('class', 'textfield');
			$totalamount->setAttrib('id', 'totalamount');
			$totalamount->setAttrib('readonly', 'true');


			$paymenttype = new Zend_Form_Element_Select('paymenttype');
			$paymenttype->addMultiOption('','select');
			$paymenttype->setAttrib('class','NormalBtn');
			$paymenttype->setAttrib('id', 'paymenttype');
			$paymenttype->setAttrib('onchange','toggleField();');
			$paymenttype->setRequired(true);


			$no = new Zend_Form_Element_Textarea('paymenttype_details');
			$no->setAttrib('class', 'textfield');
 			$no->setAttrib('rows','1');
			$no->setAttrib('cols','20');
			$no->setAttrib('id', 'paymenttype_details');
			$no->setAttrib('style','display:none;');
			$no->setRequired(true);

			$paymenttype1 = new Zend_Form_Element_Hidden('paymenttype1');
			$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
			$totalamount1 = new Zend_Form_Element_Hidden('totalamount1');
			$description1 = new Zend_Form_Element_Hidden('description1');

            $confirm = new Zend_Form_Element_Submit('confirm');
            $confirm->setAttrib('class', 'officesubmit');

            $submit = new Zend_Form_Element_Submit('Submit');
            $submit->setAttrib('class', 'officesubmit');
            $this->addElements( array ($submit,$description,$accountCode,$memberId,$categoryId,$totalamount,$paymenttype,$no,$confirm,$paymenttype1,$paymenttype_details1,$totalamount1,$description1));
        }
    }
