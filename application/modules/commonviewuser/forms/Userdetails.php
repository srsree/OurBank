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
class  Commonviewuser_Form_Userdetails extends Zend_Form {

    public function init() {
$user_id = new Zend_Form_Element_Hidden('user_id');
		        $grant_id = new Zend_Form_Element_MultiCheckbox('grant_id');
	
			$username = new Zend_Form_Element_Text('username');
			$username->setAttrib('class', '');
			$username->setAttrib('size', '10');
		
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
                       
                       
$officename = new Zend_Form_Element_Select('officebranch');
$officename->addMultiOption('','Select...');
$officename->setAttrib('class', 'txt_put');
$officename->setRequired(true)
->addValidators(array(array('NotEmpty')));
                       
                        $submit = new Zend_Form_Element_Submit('Submit');
			$back= new Zend_Form_Element_Submit('Back');
			$update = new Zend_Form_Element_Submit('Update');

		        $this->addElements(array($grant_id,$update,$user_id,$back,$username,$gender,$designation,$submit,$officename));

    }
}