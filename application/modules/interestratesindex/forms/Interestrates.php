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
/**  
 * class is used to create a form for SavingInstance details along with the validation
*/
class Interestrates_Form_Interestrates extends Zend_Form
{
	public function init()
	{
		
		$interestname = new Zend_Form_Element_Text('interestname');
		$interestname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_interestrates','interest_name','recordstatus_id=3'));
		$interestname->setAttrib('class', 'txt_put');
		$interestname->setAttrib('id', 'interestname');
		$interestname->setLabel('interestname')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$start_range = new Zend_Form_Element_Text('start_range');
		$start_range->setAttrib('class', 'txt_put');
		$start_range->setAttrib('id', 'start_range');
		$start_range->setLabel('start_range')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));
		
		$end_range = new Zend_Form_Element_Text('end_range');
		$end_range->setAttrib('class', 'txt_put');
		$end_range->setAttrib('id', 'end_range');
		$end_range->setLabel('end_range')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$interest = new Zend_Form_Element_Text('interest');
		$interest->setAttrib('class', 'txt_put');
		$interest->setAttrib('id', 'interest');
		$interest->setLabel('penalty_per_day')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$creditlinename = new Zend_Form_Element_Select('creditlinename');
		$creditlinename->addMultiOption('','Select...');
		$creditlinename->setAttrib('class', 'txt_put');
		$creditlinename->setAttrib('id', 'creditlinename');
		$creditlinename->setRequired(true);
		
		$status = new Zend_Form_Element_Checkbox('status');
		$status->setAttrib('class', 'txt_put');
		$status->setAttrib('id', 'status');
		$status->setLabel('Active')
					->setRequired(true);


		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('class', 'savings');
		$submit->setAttrib('id', 'savings');

		$this->addElements( array($interestname,$start_range,$end_range,$interest,$creditlinename,$status,$submit));
	}
}
/** end of class */
