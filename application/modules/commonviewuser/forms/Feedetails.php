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
class  Commonviewuser_Form_Feedetails extends Zend_Form {

    public function init() {
		$fee_id = new Zend_Form_Element_Hidden('fee_id');
		$officebranch = new Zend_Form_Element_Select('officebranch');
		$officebranch->addMultiOption('','Select...');
		$officebranch->setAttrib('class', 'txt_put');
		$officebranch->setRequired(true)
		->addValidators(array(array('NotEmpty')));

		$gender = new Zend_Form_Element_Select('gender');
		$gender->addMultiOption('','Select...');
		$gender->setAttrib('class', 'txt_put');
		$gender->setRequired(true)
		->addValidators(array(array('NotEmpty')));

		$designation = new Zend_Form_Element_Select('designation');
		$designation->addMultiOption('','Select...');
		$designation->setAttrib('class', 'txt_put');
		$designation->setRequired(true)
		->addValidators(array(array('NotEmpty')));


		
		

		$firstname = new Zend_Form_Element_Text('username');
		$firstname->setAttrib('class', '');
		$firstname->setAttrib('size', '10');
		
		        $grant_id = new Zend_Form_Element_MultiCheckbox('grant_id');
			
		
                       
		
		
		
		$submit = new Zend_Form_Element_Submit('Submit');
		$back= new Zend_Form_Element_Submit('Back');
		$update = new Zend_Form_Element_Submit('Update');

		$this->addElements(array($update,$fee_id,$back,$firstname,$submit,$officebranch,$gender,$designation,$grant_id));

    }
}
