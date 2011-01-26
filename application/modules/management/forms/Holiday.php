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
class Management_Form_Holiday extends  ZendX_JQuery_Form {
public function init() {

    $holidayname = new Zend_Form_Element_Text('holidayname');
    $holidayname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_holidayupdates', 'holidayname'));
    $holidayname->setAttrib('class', 'txt_put');
    $holidayname->setRequired(true)
                ->addValidators(array(array('NotEmpty')));


	$office_id = new Zend_Form_Element_Select('office_id');
	$office_id->addMultiOption('','Select...');
	$office_id->addMultiOption('All','All');
	$office_id->setAttrib('class', 'txt_put');
    $office_id->setRequired(true)
                 ->addValidators(array(array('NotEmpty')));

    $holidayupdate_id = new Zend_Form_Element_Hidden('holidayupdate_id');

    $holidayfrom = new ZendX_JQuery_Form_Element_DatePicker('holidayfrom');
    $holidayfrom->setAttrib('class', 'txt_put');
	$holidayfrom->setJQueryParam('dateFormat', 'yy-mm-dd');
    $holidayfrom->setRequired(true)
	   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	   array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));

				
				
				
    $holidayupto = new ZendX_JQuery_Form_Element_DatePicker('holidayupto');
    $holidayupto->setAttrib('class', 'txt_put');
	$holidayupto->setJQueryParam('dateFormat', 'yy-mm-dd');
    $holidayupto->setRequired(true)
	   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	   array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));


    $repayment_date = new ZendX_JQuery_Form_Element_DatePicker('repayment_date');
    $repayment_date->setAttrib('class', 'txt_put');
	$repayment_date->setJQueryParam('dateFormat', 'yy-mm-dd');
    $repayment_date->setRequired(true)
	->addValidators(array(array('NotEmpty')));
	array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date'));
	

    $submit = new Zend_Form_Element_Submit('Submit');
	$submit->removeDecorator('DtDdWrapper');
    $this->addElements(array($holidayname,$office_id,$holidayfrom,$holidayupto,$repayment_date,$holidayupdate_id,$submit));

}
}