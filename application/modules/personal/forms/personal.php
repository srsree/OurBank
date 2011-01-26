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
class Personal_Form_personal extends Zend_Form
{
	public function init()
	{
        $dateofbirth = new Zend_Form_Element_Text('memberdateofbirth ');
 	$dateofbirth->setAttrib('tabindex', '8');
        $dateofbirth->setAttrib('class', 'txt_put');
	$dateofbirth->setAttrib('size', '10');
        $dateofbirth->setAttrib('id', 'memberdateofbirth');
        $dateofbirth->setAttrib($value,'true');
        $dateofbirth->setRequired(true)
	->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true,
	array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));

        $physicalstatus_id = new Zend_Form_Element_Select('physicalstatus_id');
        $physicalstatus_id->addMultiOption('','Select');
        $physicalstatus_id->setAttrib('class', 'txt_put');
        $physicalstatus_id->setAttrib('id', 'physicalstatus_id');
        $physicalstatus_id->setAttrib('tabindex', '11');  
        $physicalstatus_id->setAttrib($value,'true');

        $maritalstatus_id = new Zend_Form_Element_Select('membermaritalstatus_id');
        $maritalstatus_id->addMultiOption('','Select');
        $maritalstatus_id->setAttrib('class', 'txt_put');
        $maritalstatus_id->setAttrib('id', 'membermaritalstatus_id');
        $maritalstatus_id->setAttrib('tabindex', '10');  
        $maritalstatus_id->setAttrib($value,'true');

        $memberpersonalid  = new Zend_Form_Element_Text('memberpersonalid ');
        $memberpersonalid->setAttrib('class', 'txt_put');
        $memberpersonalid->setAttrib('id', 'memberpersonalid');
        $memberpersonalid->setAttrib('tabindex', '7');
        $memberpersonalid->setAttrib($value,'true');

         $submit = new Zend_Form_Element_Submit('Submit');

	$back= new Zend_Form_Element_Submit('Back');


         $this->addElements( array ($dateofbirth,$physicalstatus_id,$maritalstatus_id,$memberpersonalid,$submit,$back));

		
	}
}
/** end of class */
