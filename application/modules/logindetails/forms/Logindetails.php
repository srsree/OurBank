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
class Logindetails_Form_Logindetails extends Zend_Form {

    public function init()
    {    		$username = new Zend_Form_Element_Text('username');
			$username->setAttrib('class', 'txt_put');
			$username->setAttrib('id', 'office');
			$username->setRequired(true);
			
			$password = new Zend_Form_Element_Password('password');
			$password->setAttrib('class', 'txt_put');
			$password->setAttrib('id', 'office');
			
			$email = new Zend_Form_Element_Text('email');
			$email->setAttrib('class', 'txt_put');
			$email->setAttrib('id', 'office');
			

			
			
			 $back= new Zend_Form_Element_Submit('Back');

			$submit = new Zend_Form_Element_Submit('Submit');
                        $update = new Zend_Form_Element_Submit('Update');

		        $this->addElements(array($username,$password,$email,$back,$submit,$update));
			
			


    }
}
