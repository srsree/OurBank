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
class Transaction_Form_Loanrepayment extends Zend_Form
{

	public function __construct($haveToPay,$currentdate,$fromDate)
	{
	parent::__construct($haveToPay,$currentdate,$fromDate);

			$accountId = new Zend_Form_Element_Hidden('accountcode');
			$installment_status = new Zend_Form_Element_Hidden('installment_status');
			$memberId = new Zend_Form_Element_Hidden('membercode');

			$amount = new Zend_Form_Element_Text('amount');
			$amount->setRequired(true)
					->addValidators(array(array('Float'),
									array('GreaterThan',false,array($haveToPay-.0001,
											'messages' => array('notGreaterThan' => 'Min='.$haveToPay)))
									));
			$amount->setAttrib('class', 'txt_put');
			$amount->setAttrib('id', 'amount');

        	$loanInterestAmountPaied = new Zend_Form_Element_Text('loanInterestAmountPaied');
			$loanInterestAmountPaied->setAttrib('class', 'textfieldreadonly');
			$loanInterestAmountPaied->setAttrib('readonly', 'true');
			$loanInterestAmountPaied->setAttrib('id', 'loanInterestAmountPaied');


			$loanRepaymentDate= new Zend_Form_Element_Text('loanRepaymentDate');
			$loanRepaymentDate->setAttrib('id', 'loanRepaymentDate');
			$loanRepaymentDate->setAttrib('size', '8');
			$loanRepaymentDate->setAttrib('class','txt_put');
			$loanRepaymentDate->setRequired(true)
				->addValidators(array(array('Date', true),
			array('Between',false,array($fromDate,$currentdate,
			'messages' => array('notBetween' => 'date should be between '.$fromDate.' to (today date) '.$currentdate)))));

			$transactionMode = new Zend_Form_Element_Select('transactionMode');
			$transactionMode->addMultiOption('','select');
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

			$pay = new Zend_Form_Element_Submit('pay');
			$pay->setAttrib('class', 'officesubmit');
			$pay->setAttrib('onclick', 'getState(this.value)');
			$pay->setLabel('pay');

			$back= new Zend_Form_Element_Submit('back');
			$back->setAttrib('class', 'officesubmit');


			$confirm = new Zend_Form_Element_Submit('confirm');
			$confirm->setAttrib('class', 'officesubmit');
			$confirm->setAttrib('onclick', 'getState(this.value)');
			$confirm->setLabel('confirm');

    		$categoryId = new Zend_Form_Element_Hidden('categoryId');
            $categoryId->setAttrib('class', 'txt_put');

			$amount1 = new Zend_Form_Element_Hidden('repayableamounts1');
			$loanRepaymentDate1 = new Zend_Form_Element_Hidden('loanRepaymentDate1');
			$transactionMode1 = new Zend_Form_Element_Hidden('transactionMode1');
			$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
			$fine1 = new Zend_Form_Element_Hidden('fine1');

  			$this->addElements(array($accountId,$amount,$loanRepaymentDate,$pay,$memberId,$loanInterestAmountPaied,$transactionMode,$transactionModeDetails,$categoryId,$installment_status,$confirm,$amount1,$loanRepaymentDate1,$transactionMode1,$paymenttype_details1,$fine1,$back));

        }
}
