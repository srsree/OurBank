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
class Loanrepaymentg_Form_loanrepayment extends Zend_Form {
    public function init()
    {

    }


    public function __construct($p,$int,$totalAmt,$accNum)
    {
        parent::__construct($p,$int,$totalAmt,$accNum);

			$date = new ZendX_JQuery_Form_Element_DatePicker('date');
			$date->setAttrib('class', '');
			$date->setRequired(true);

			//$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
			$formfield = new App_Form_Field ();
			$amount = $formfield->field('Text','amount','','','txt_put','',true,'','','','','',0,'');
            $graterthan=new Zend_Validate_GreaterThan(0);
            $amount->setRequired(true)
                   ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));

			$transactionMode = $formfield->field('Select','transactionMode','','','txt_put','',true,'','','','','',0,'');
			$transactionMode->setAttrib('onchange','toggleField();');

			$transactionModeDetails = $formfield->field('Textarea','paymenttype_details','','','txt_put','',true,'','','',1,20,'',0,'');
			$transactionModeDetails->setAttrib('style','display:none');

			$description = $formfield->field('Textarea','description','','','txt_put','',true,'','','',2,20,'',0,'');
			$p = $formfield->field('Text','p','','','txt_put','','','','','','','',0,$p);
			$p->setAttrib('disable','true');
			$int = $formfield->field('Text','int','','','txt_put','','','','','','','',0,$int);
			$int->setAttrib('disable','true');
			$totalAmt = $formfield->field('Text','totalAmt','','','txt_put','','','','','','','',0,$totalAmt);
			$totalAmt->setAttrib('disable','true');
			// hidden feilds
			$accNum = $formfield->field('Hidden','accNum','','','txt_put','',true,'','','','','',0,$accNum);
			$sms = new Zend_Form_Element_Checkbox('sms');


			$submit = new Zend_Form_Element_Submit('Submit');
            $submit->setAttrib('id', 'button');

            $back = new Zend_Form_Element_Submit('Back');
            $back->setAttrib('id', 'button2');

			$this->addElements(array($date,$amount,$description,$transactionMode,$transactionModeDetails,
								$submit,$accNum,$back,$sms,$p,$int,$totalAmt));
		}
	}
