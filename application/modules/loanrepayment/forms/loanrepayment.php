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
class Loanrepayment_Form_loanrepayment extends Zend_Form {
    public function init()
    {
        Zend_Dojo::enableForm($this);
    }


    public function __construct()
    {
        Zend_Dojo::enableForm($this);
        parent::__construct();
			$date = new ZendX_JQuery_Form_Element_DatePicker('Date1');
			$date->setAttrib('class', '');
			$date->setRequired(true);


			$Amount = new Zend_Form_Element_Text('Amount');
                        $graterthan=new Zend_Validate_GreaterThan(0);
                        $Amount->setRequired(true)
                                ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
			$Amount->setAttrib('class', 'textfield');
			$Amount->setAttrib('id', 'Amount');

			$interestamount = new Zend_Form_Element_Hidden('interestamount');
			$interestamount->setAttrib('class', 'textfield');
			$interestamount->setAttrib('readonly', 'true');
                        $graterthan=new Zend_Validate_GreaterThan(0);
                        $interestamount->setRequired(true)
                                ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));

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

			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);

			$installment_status = new Zend_Form_Element_Hidden('installment_status');

			$sms = new Zend_Form_Element_Checkbox('sms');


			$submit = new Zend_Form_Element_Submit('Submit');
                        $submit->setAttrib('id', 'button');

                        $back = new Zend_Form_Element_Submit('Back');
                        $back->setAttrib('id', 'button2');

			$this->addElements( array($date,$Amount,$interestamount,$description,$transactionMode,$transactionModeDetails,$submit,$installment_status,$back,$sms));
		}
	}
