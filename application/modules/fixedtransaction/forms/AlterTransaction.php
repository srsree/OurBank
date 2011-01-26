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

class Transaction_Form_AlterTransaction extends Zend_Form
{
	public function __construct()
        {


    		$transactionType = new Zend_Form_Element_Select('transactionType');
                $transactionType->setAttrib('class', 'NormalBtn');
                $transactionType->setRequired(true)
                                ->addValidators(array(array('NotEmpty')));

        	$transactionMode = new Zend_Form_Element_Select('transactionMode');
                $transactionMode->setAttrib('class', 'NormalBtn');
                $transactionMode->setRequired(true)
                                ->addValidators(array(array('NotEmpty')));
                $transactionMode->setAttrib('onchange', 'display(this.value);');

                $transaction_interest_amount = new Zend_Form_Element_Text('transaction_interest_amount');
                $transaction_interest_amount->setAttrib('class', 'NormalBtn');

         	
        	$transaction_fine_amount = new Zend_Form_Element_Text('transaction_fine_amount');
                $transaction_fine_amount->setAttrib('class', 'NormalBtn'); 
        
                $account_id = new Zend_Form_Element_Text('account_id');
                $account_id->setAttrib('class', 'NormalBtn');     	

                $transaction_date = new Zend_Form_Element_Text('transaction_date');
                $transaction_date->setAttrib('class', 'NormalBtn');
                $transaction_date->setRequired(true)
                                 ->addValidators(array(array('NotEmpty')));
                $transaction_date->setRequired(true)
	                         ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	                         array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));

                $transaction_amount = new Zend_Form_Element_Text('transaction_amount');
                $transaction_amount->setAttrib('class', 'NormalBtn');
                

                $transaction_remarks = new Zend_Form_Element_Textarea
                ('transaction_remarks', array('rows' => 3,'cols' => 25,));
                $transaction_remarks->setAttrib('class', 'NormalBtn');

                $submit = new Zend_Form_Element_Submit('submit');
                $submit->setAttrib('id', 'submit');
                $submit->setAttrib('class', 'NormalBtn');
                $submit->setLabel('submit');
		
		$this->addElements(array($transactionType,
                                         $transactionMode,
                                         $transaction_interest_amount,
                                         $transaction_fine_amount,
                                         $account_id,
                                         $transaction_date,
                                         $transaction_amount,
                                         $transaction_remarks,
                                         $submit));
        }
}