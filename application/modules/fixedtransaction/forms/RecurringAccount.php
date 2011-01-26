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
class Transaction_Form_RecurringAccount extends ZendX_JQuery_Form
{
	public function __construct($recurringBeginDate,$recurringClosedDate,$recurringMinAmount,$recurringMaxAmount,$app)
	{
	parent::__construct($recurringBeginDate,$recurringClosedDate,$recurringMinAmount,$recurringMaxAmount,$app);
    $startdate= new ZendX_JQuery_Form_Element_DatePicker('startdate');
    $startdate->setAttrib('id', 'startdate');
	$startdate->setAttrib('size', '8');
	$startdate->setAttrib('class', '');
	$startdate->setRequired(true)
		->addValidators(array(array('Date', true),
		array('Between',false,array($recurringBeginDate,$recurringClosedDate,
		'messages' => array('notBetween' => 'date should be between '.$recurringBeginDate.' to (Closed date) '.$recurringClosedDate)))));
	
	
	
	$recurringamount = new Zend_Form_Element_Text('recurringamount');
	$recurringamount->setRequired(true)
	->addValidators(array(
	array('Digits'),
	array('GreaterThan',false,array($recurringMinAmount)),
	array('LessThan',false,array($recurringMaxAmount)),
	array('NotEmpty')
	)
	);
	$recurringamount->setAttrib('size', '8');
	
    $recurringperiod = new Zend_Form_Element_Text('recurringperiod');
    $recurringperiod->setAttrib('id', 'recurringperiod');
    $recurringperiod->setAttrib('class', 'NormalBtn');
	
	
	$memberfirstname = new Zend_Form_Element_MultiCheckbox('memberfirstname');
	$memberfirstname->setAttrib('class', 'textfield');

	$freequencyofdeposit = new Zend_Form_Element_Select('frequencyofdeposit');
	$freequencyofdeposit->addMultiOption('','Select...');
	$freequencyofdeposit->setAttrib('class', 'NormalBtn');
	$freequencyofdeposit->setAttrib('id', 'freequencyofdeposit');

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
	$periodinterest->setAttrib('size', '5');
	$accountId = new Zend_Form_Element_Hidden('accountId');
	$productIdss = new Zend_Form_Element_Hidden('productId');
	
	
	$recurringindex = new Zend_Form_Element_Text('recurringinterest');
	$recurringindex->setAttrib('id', 'recurringinterest');
	$recurringindex->setAttrib('size', '8');
	$recurringindex->setAttrib('class', 'NormalBtn');
	$recurringindex->setAttrib('readonly', 'true');
	
    $recurringindex->setAttrib('class', 'NormalBtn');
	$recurringindex->setAttrib('readonly', 'true');
	$memberTypeId = new Zend_Form_Element_Hidden('memberTypeId');
	$memberId = new Zend_Form_Element_Hidden('member_id');
	$productId = new Zend_Form_Element_Hidden('product_id');
	$offerproductId = new Zend_Form_Element_Hidden('offerproduct_id');
	$groupId= new Zend_Form_Element_Hidden('groupId');
	$this->addElements( array($memberfirstname,$recurringindex,$freequencyofdeposit,$recurringperiod,$recurringamount,$startdate,$perioddescription,$periodinterest,$memberId,$productId,$offerproductId,$groupId,$memberTypeId,$accountId,$productIdss));

	$period_id = new Zend_Form_Element_Hidden('period_id');
	$period_id->setAttrib('id', 'period_id');

	$startdate1= new Zend_Form_Element_Hidden('startdate1');
	$recurringamount1= new Zend_Form_Element_Hidden('recurringamount1');
	$perioddescription1= new Zend_Form_Element_Hidden('perioddescription1');
	$interest1= new Zend_Form_Element_Hidden('interest1');
	
        $Confirm = new Zend_Form_Element_Submit('Confirm');
			$Confirm->setLabel('Confirm');
		$Confirm->setAttrib('class', 'recurring');

        $submit = new Zend_Form_Element_Submit('Submit');
			$submit->setLabel('submit');
		$submit->setAttrib('class', 'recurring');

   $this->addElements(array($submit,$period_id,$Confirm,$startdate1,$recurringamount1,$perioddescription1,$interest1));
    }
}
