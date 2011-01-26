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
class Transaction_Form_recurringTransaction extends ZendX_JQuery_Form
{
	public function __construct($amountTopay,$currentdate,$lastPaidDate)
	{
	parent::__construct($amountTopay,$currentdate,$lastPaidDate);


		$transactionMode = new Zend_Form_Element_Select('transactionMode');
		$transactionMode->addMultiOption('','Select...');
		$transactionMode->setAttrib('class','selectbutton');
		$transactionMode->setAttrib('onchange','toggleField();');
		$transactionMode->setAttrib('id','paymenttype');
		$transactionMode->setRequired(true);

		$transactionModeDetails = new Zend_Form_Element_Textarea('paymenttype_details');
		$transactionModeDetails->setAttrib('class', 'txt_put');
		$transactionModeDetails->setAttrib('id','paymenttype_details');
		$transactionModeDetails->setAttrib('style','display:none');
		$transactionModeDetails->setAttrib('rows','1');
		$transactionModeDetails->setAttrib('cols','20');
	    $transactionModeDetails->setRequired(true);

		$recurringDate= new ZendX_JQuery_Form_Element_DatePicker('recurringDate');
		$recurringDate->setRequired(true);
        $recurringDate->setAttrib('id', 'recurringDate');
        $recurringDate->setAttrib('size', '8');   
        $recurringDate->setAttrib('class', '');
        $recurringDate->setRequired(true)
				->addValidators(array(array('Date', true),
				array('Between',false,array($currentdate,$lastPaidDate,
				'messages' => array('notBetween' => 'date should be between '.$lastPaidDate.' to (installment date) '.$currentdate)))));


		$amount = new Zend_Form_Element_Text('amount');
		$amount->setRequired(true)
			->addValidators(array(array('Float'),
			array('GreaterThan',false,array($amountTopay-.0001,
				'messages' => array('notGreaterThan' => 'Min Payable Amount='.$amountTopay)))
				));
		$amount->setAttrib('class', 'txt_put');
		$amount->setAttrib('id', 'amount');
		$amount->setAttrib('size', '8');

		$accountId = new Zend_Form_Element_Hidden('accountId');
		$productId = new Zend_Form_Element_Hidden('productId');

		$recurringDate1 = new Zend_Form_Element_Hidden('recurringDate1');
		$amount1 = new Zend_Form_Element_Hidden('amounts1');
		$transactionMode1 = new Zend_Form_Element_Hidden('transactionMode1');
		$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
		$fine1 = new Zend_Form_Element_Hidden('fine1');

		$Submit = new Zend_Form_Element_Submit('Submit');
		$Submit->setLabel('submit');	

		$Confirm = new Zend_Form_Element_Submit('Confirm');
		$Confirm->setLabel('Confirm');
		
		$this->addElements(array($transactionMode,$transactionModeDetails,$Submit,$recurringDate,$amount,$accountId,$productId,$Confirm,$recurringDate1,$amount1,$transactionMode1,$paymenttype_details1,$fine1));
    }
}
