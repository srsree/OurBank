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
	class Meeting_Form_Meeting extends Zend_Form {

	public function init()
	{
		Zend_Dojo::enableForm($this);
	}

	public function __construct($options = null)
	{
		Zend_Dojo::enableForm($this);
		parent::__construct($options);

		$meeting_name = new Zend_Form_Element_Text('meeting_name');
		//$meeting_name->addValidator(new Zend_Validate_Db_NoRecordExists('ob_creditline_details','creditline_name','recordstatus_id=3'));
		$meeting_name->setAttrib('class', 'txt_put');
		$meeting_name->setAttrib('id', 'meetingname');
		$meeting_name->setLabel('meetingname')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$group_head = new Zend_Form_Element_Text('group_head');
		//$group_head->addValidator(new Zend_Validate_Db_NoRecordExists('ob_creditline_details','creditline_name','recordstatus_id=3'));
		$group_head->setAttrib('class', 'txt_put');
		$group_head->setAttrib('id', 'group_head');
		$group_head->setLabel('group_head')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$meeting_place = new Zend_Form_Element_Text('meeting_place');
		//$creditlinename->addValidator(new Zend_Validate_Db_NoRecordExists('ob_creditline_details','creditline_name','recordstatus_id=3'));
		$meeting_place->setAttrib('class', 'txt_put');
		$meeting_place->setAttrib('id', 'meeting_place');
		$meeting_place->setLabel('meeting_place')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$meeting_time = new Zend_Form_Element_Text('meeting_time');
		$meeting_time->addValidator(new Zend_Validate_Db_NoRecordExists('ob_creditline_details','creditline_name','recordstatus_id=3'));
		$meeting_time->setAttrib('class', 'txt_put');
		$meeting_time->setAttrib('id', 'meeting_time');
		$meeting_time->setLabel('meeting_time')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$office_type = new Zend_Form_Element_Select('office_type');
		$office_type->addMultiOption('','Select...');
		$office_type->setAttrib('class', 'txt_put');
		$office_type->addValidators(array(array('NotEmpty')));

		$group_name = new Zend_Form_Element_Select('group_name');
		$group_name->addMultiOption('','Select...');
		$group_name->addMultiOption('All','All');
		$group_name->setAttrib('class', 'txt_put');
		$group_name->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$meeting_day = new Zend_Form_Element_Select('meeting_day');
		$meeting_day->addMultiOption('','Select...');
		//$meeting_day->addMultiOption('All','All');
		$meeting_day->setAttrib('class', 'txt_put');
		$meeting_day->setRequired(true)
				->addValidators(array(array('NotEmpty')));

		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('class', 'officesubmit');
		$submit->setlabel('Submit');

		$this->addElements( array ($meeting_name,$group_head,$meeting_place,$meeting_time,$office_type,$group_name,$meeting_day,$submit));

//===================================================================================================================================
	}
}