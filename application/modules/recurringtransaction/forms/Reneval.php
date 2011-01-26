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
class Transaction_Form_Reneval extends ZendX_JQuery_Form
	{
		public function __construct($begindate,$closedate,$minimum_deposit_amount,$maximum_deposit_amount,$app)
		{
			parent::__construct($begindate,$closedate,$minimum_deposit_amount,$maximum_deposit_amount,$app);

            $startdate = new ZendX_JQuery_Form_Element_DatePicker('startdate');
            $startdate->setAttrib('class', '');
	    $startdate->setAttrib('size', '10'); 
            $startdate->setJQueryParam('dateFormat', 'yy-mm-dd');
	    $startdate->setRequired(true)
		->addValidators(array(array('Date', true),
		array('Between',false,array($begindate,$closedate,
		'messages' => array('notBetween' => 'date should be between '.$begindate.' to (Closed date) '.$closedate)))));   

			$recurringamount = new Zend_Form_Element_Text('recurringamount');
			$recurringamount->setAttrib('id', 'recurringamount');   
			$recurringamount->setAttrib('size', '10'); 
			$recurringamount->setRequired(true)
				->addValidators(array(
					array('GreaterThan',false,array($minimum_deposit_amount)),
					array('LessThan',false,array($maximum_deposit_amount)),
					array('NotEmpty')
				));


			$perioddescription = new Zend_Form_Element_Select('perioddescription');
			$perioddescription->addMultiOption('','Select..');
			$perioddescription->setAttrib('class', 'NormalBtn');
			$perioddescription->setAttrib('id', 'perioddescription');
			$perioddescription->setRequired(true);
			$perioddescription->setAttrib('onchange', 'getInterests(this.value,"'.$app.'")');


			$periodinterest = new Zend_Form_Element_Select('periodinterest');
			$periodinterest->addMultiOption('','Select...');
			$periodinterest->setAttrib('class', 'NormalBtn');
			$periodinterest->setAttrib('id', 'periodinterest');
			$periodinterest->setAttrib('size', '8');

			$recurringindex = new Zend_Form_Element_Text('recurringinterest');
			$recurringindex->setAttrib('id', 'recurringinterest');
			$recurringindex->setAttrib('size', '8');
			$recurringindex->setAttrib('class', 'NormalBtn');
			$recurringindex->setAttrib('readonly', 'true');

			$totalamount = new Zend_Form_Element_Text('totalamount');
			$totalamount->setAttrib('class', 'NormalBtn');
			$totalamount->setAttrib('id', 'totalamount');
			$totalamount->setAttrib('size', '11');
			$totalamount->setRequired(true);
			$totalamount->setAttrib('readonly', 'true');
			$totalamount->setAttrib('onclick','AutoFill()');

			$accountId = new Zend_Form_Element_Hidden('accountId');
			$productId = new Zend_Form_Element_Hidden('productId');
			$memberId = new Zend_Form_Element_Hidden('memberId');

			$feeTotal = new Zend_Form_Element_Hidden('feeTotal');

			$capitalamount = new Zend_Form_Element_Hidden('capitalamount');
			$maturedinterestamount= new Zend_Form_Element_Hidden('maturedintrestamount');

			$paymenttype = new Zend_Form_Element_Select('paymenttype');
			$paymenttype->addMultiOption('','select..');
			$paymenttype->setAttrib('class','NormalBtn');
			$paymenttype->setAttrib('id', 'paymenttype');
			$paymenttype->setAttrib('onchange','toggleField();');
			$paymenttype->setRequired(true);

			$description = new Zend_Form_Element_Textarea('transactiondescription');
			$description->setAttrib('class', 'textfield');
			$description->setAttrib('rows','2');
			$description->setAttrib('cols','20');

			$no = new Zend_Form_Element_Textarea('paymenttype_details');
			$no->setAttrib('class', 'textfield');
 			$no->setAttrib('rows','1');
			$no->setAttrib('cols','20');
			$no->setAttrib('id', 'paymenttype_details');
			$no->setAttrib('style','display:none;');
			$no->setRequired(true);

			$payableamount = new Zend_Form_Element_Text('payableamount');
			$payableamount->setAttrib('class', 'textfield');
			$payableamount->setAttrib('size', '11');
			$payableamount->setAttrib('readonly', 'true');
			$payableamount->setAttrib('onclick','AutoFill()');

			$startdate1 = new Zend_Form_Element_Hidden('startdate1');
			$perioddescription1 = new Zend_Form_Element_Hidden('perioddescription1');
			$interest1 = new Zend_Form_Element_Hidden('interest1');
			$recurringamount1 = new Zend_Form_Element_Hidden('recurringamount1');
			$paymenttype1 = new Zend_Form_Element_Hidden('paymenttype1');
			$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
			$transactiondescription1 = new Zend_Form_Element_Hidden('transactiondescription1');


			$Confirm = new Zend_Form_Element_Submit('Confirm');
			$Confirm->setLabel('Confirm');
			$Confirm->setAttrib('class', 'recurring');

			$submit = new Zend_Form_Element_Submit('Submit');
			$submit->setLabel('submit');
			$submit->setAttrib('class', 'Submit');

			$this->addElements( array($recurringindex,$recurringamount,$startdate,$perioddescription,$periodinterest,$accountId,$productId,$memberId,$submit,$maturedinterestamount,$capitalamount,$totalamount,$paymenttype,$description,$no,$feeTotal,$payableamount,$Confirm,$startdate1,$perioddescription1,$interest1,$recurringamount1,$paymenttype1,$paymenttype_details1,$transactiondescription1));
		}
	}
