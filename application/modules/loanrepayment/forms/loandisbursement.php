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
class Loandisbursment_Form_loandisbursement extends Zend_Form
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


			$Amount = new Zend_Form_Element_Text('Amount');
			$Amount->setRequired(true)
					->addValidators(array(array('NotEmpty'),array('Digits'),array('GreaterThan',false,array('0'))));
			$Amount->setAttrib('class', 'textfield');
			$Amount->setAttrib('id', 'Amount');

			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);


			$submit = new Zend_Form_Element_Submit('Submit');
			$submit->setAttrib('class', 'officesubmit');


			$this->addElements( array($date,$Amount,$description,$submit));
		}
	}
