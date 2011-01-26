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
class Transaction_Form_SavingsTransaction extends ZendX_JQuery_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);

			$accountId = new Zend_Form_Element_Hidden('accountcode');
			$memberId = new Zend_Form_Element_Hidden('membercode');

                        $Date = new ZendX_JQuery_Form_Element_DatePicker('date');
                        $Date->setAttrib('class', 'txt_put');
			$Date->setJQueryParam('dateFormat', 'yy-mm-dd');
			$Date->setRequired(true)
	   					->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	   				array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));

			$Amount = new Zend_Form_Element_Text('amount');
			$Amount->setRequired(true)
					->addValidators(array(array('NotEmpty'),array('Float'),array('GreaterThan',false,array('0'))));
			$Amount->setAttrib('class', 'textfield');
			$Amount->setAttrib('id', 'amount');
			$Amount->setAttrib('size', '8');


			$paymenttype = new Zend_Form_Element_Select('paymenttype');
			$paymenttype->addMultiOption('','select');
			$paymenttype->setAttrib('class','NormalBtn');
			$paymenttype->setAttrib('id', 'paymenttype');
			$paymenttype->setAttrib('onchange','toggleField();');
			$paymenttype->setRequired(true);

			$description = new Zend_Form_Element_Textarea('transactiondescription');
			$description->setAttrib('class', 'textfield');
			$description->setAttrib('rows','2');
			$description->setAttrib('cols','20');
			$description->setRequired(true);

			$no = new Zend_Form_Element_Textarea('paymenttype_details');
			$no->setAttrib('class', 'textfield');
 			$no->setAttrib('rows','1');
			$no->setAttrib('cols','20');
			$no->setAttrib('id', 'paymenttype_details');
			$no->setAttrib('style','display:none;');
			$no->setRequired(true);

			$categoryId = new Zend_Form_Element_Hidden('categoryId');
			$categoryId->setAttrib('class', 'textfield');

			$date1 = new Zend_Form_Element_Hidden('date1');
			$amount1 = new Zend_Form_Element_Hidden('amounts');
			$transactiondescription1 = new Zend_Form_Element_Hidden('transactiondescription1');
			$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
			$paymenttype1 = new Zend_Form_Element_Hidden('paymenttype1');


			$confirm = new Zend_Form_Element_Submit('confirm');
			$confirm->setAttrib('class', 'NormalBtn');

			$submit = new Zend_Form_Element_Submit('Submit');
			$submit->setAttrib('class', 'NormalBtn');

			$submit->setLabel('submit');
			$this->addElements(array($Date,$Amount,$paymenttype,$submit,$accountId,$memberId,$description,$no,$categoryId,$confirm,$date1,$amount1,$transactiondescription1,$paymenttype_details1,$paymenttype1));
	}
}
