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
class Transaction_Form_loandisbursement extends ZendX_JQuery_Form
	{
	public function __construct($options = null)
	{
		parent::__construct($options);

			$date = new ZendX_JQuery_Form_Element_DatePicker('Date1');
			$date->setAttrib('class', '');
			$date->setJQueryParam('dateFormat', 'yy-mm-dd');
			$date->setRequired(true)
				->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
				array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));

			$accountCode= new Zend_Form_Element_Hidden('accountcode');
			$memberId = new Zend_Form_Element_Hidden('membercode');
			$categoryId = new Zend_Form_Element_Hidden('categoryId');
			$loanAmount = new Zend_Form_Element_Hidden('loan_amount');
			$typeId = new Zend_Form_Element_Hidden('typeId');


			$creditlinebalance= new Zend_Form_Element_Text('creditlinebalance');
			$creditlinebalance->setAttrib('readonly', 'true');

			$transactionType = new Zend_Form_Element_Select('transaction_type');
			$transactionType->setAttrib('class', 'NormalBtn');
			$transactionType->setAttrib('id', 'transaction_type');
			$transactionType->addMultiOption('3','-Loan Disbursement-');

			$Amount = new Zend_Form_Element_Text('Amount');
			$Amount->setRequired(true)
					->addValidators(array(array('NotEmpty'),array('Digits'),array('GreaterThan',false,array('0'))));
			$Amount->setAttrib('class', 'textfield');
			$Amount->setAttrib('id', 'Amount');

			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);

			$fee = new Zend_Form_Element_Text('fee');
			$fee->setAttrib('class', 'textfield');
			$fee->setAttrib('readonly', 'true');

			$Save = new Zend_Form_Element_Submit('Save');
			$Save->setAttrib('class', 'officesubmit');

			$submit = new Zend_Form_Element_Submit('Submit');
			$submit->setAttrib('class', 'officesubmit');

			$transactionTypeId = new Zend_Form_Element_Hidden('transactionType_id');
			$transactionTypeId->setAttrib('class', 'textfield');

			$disburseddate = new Zend_Form_Element_Hidden('disburseddate');
			$description1 = new Zend_Form_Element_Hidden('description1');
			$Amount1 = new Zend_Form_Element_Hidden('Amount1');
			$fee1 = new Zend_Form_Element_Hidden('fee1');

			$this->addElements( array($Amount,$date,$transactionType,$description,$categoryId,$memberId,$typeId,$fee,$submit,$loanAmount,$accountCode,$transactionTypeId,$creditlinebalance,$Save,$disburseddate,$description1,$Amount1,$fee1));
		}
	}
