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
class Personalinfo_Form_Personalinfo extends Zend_Form {

    public function init()
    {    	
	$user_id = new Zend_Form_Element_Hidden('user_id');


	$dateofbirth = new Zend_Form_Element_Text('dateofbirth');
    	$dateofbirth->setAttrib('class', 'txt_put');
    	$dateofbirth->setRequired(true);


			
	$dateofjoin = new Zend_Form_Element_Text('dateofjoin');
    	$dateofjoin->setAttrib('class', 'txt_put');
    	$dateofjoin->setRequired(true);
	
			
	$email = new Zend_Form_Element_Text('email');
	$email->setAttrib('class', 'txt_put');
	$email->setAttrib('id', 'office');
			

			
			
	$back= new Zend_Form_Element_Submit('Back');

	$submit = new Zend_Form_Element_Submit('Submit');
	$update = new Zend_Form_Element_Submit('Update');

	$this->addElements(array($dateofbirth,$dateofjoin,$email,$back,$submit,$update,$user_id));
			
			


    }
}
