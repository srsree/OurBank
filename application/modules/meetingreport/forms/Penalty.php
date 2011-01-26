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
class Penalty_Form_Penalty extends Zend_Form
{
	public function init()
	{
		
		$penaltyname = new Zend_Form_Element_Text('penaltyname');
		$penaltyname->addValidator(new Zend_Validate_Db_NoRecordExists('ob_penalty_details','penalty_name','recordstatus_id=3'));
		$penaltyname->setAttrib('class', 'txt_put');
		$penaltyname->setAttrib('id', 'penaltyname')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$penalty_per_month = new Zend_Form_Element_Text('penalty_per_month');
		$penalty_per_month->setAttrib('class', 'txt_put');
		$penalty_per_month->setAttrib('id', 'penalty_per_month')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));
		
		$penalty_per_day = new Zend_Form_Element_Text('penalty_per_day');
		$penalty_per_day->setAttrib('class', 'txt_put');
		$penalty_per_day->setAttrib('id', 'penalty_per_day')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));
		
		$status = new Zend_Form_Element_Checkbox('status');
		$status->setAttrib('class', 'txt_put');
		$status->setAttrib('id', 'status')		
					->setRequired(true);

		$unit_per_month = new Zend_Form_Element_Select('unit_per_month');
		$unit_per_month->addMultiOption('','Select...');
		$unit_per_month->addMultiOptions(array('1'=>'Flat','2'=>'Percentage'));
		$unit_per_month->setAttrib('class', 'txt_put');
		$unit_per_month->setAttrib('id', 'unit_per_month');
		$unit_per_month->setRequired(true);


		$unit_per_day = new Zend_Form_Element_Select('unit_per_day');
		$unit_per_day->addMultiOption('','Select...');
		$unit_per_day->addMultiOptions(array('1'=>'Flat','2'=>'Percentage'));
		$unit_per_day->setAttrib('class', 'txt_put');
		$unit_per_day->setAttrib('id', 'unit_per_day');
		$unit_per_day->setRequired(true);

		$creditlinename = new Zend_Form_Element_Select('creditlinename');
		$creditlinename->addMultiOption('','Select...');
		$creditlinename->setAttrib('class', 'txt_put');
		$creditlinename->setAttrib('id', 'creditlinename');
		$creditlinename->setRequired(true);

		//add submit button
		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('class', 'savings');
		$submit->setAttrib('id', 'Submit');
		//add elements to form
		$this->addElements( array($penaltyname,$penalty_per_month,$penalty_per_day,$status,$unit_per_month,$unit_per_day,$creditlinename,$submit));
	}
}
/** end of class */
