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
class Email_Form_email extends Zend_Form
{
	public function init()
	{
	$email= new Zend_Form_Element_Text('email');
        $email->setAttrib('class', 'txt_put');
        $email->setAttrib('id', 'email');
        $email->setAttrib('tabindex', '5');
        $email->setAttrib($value,'true');

	$website = new Zend_Form_Element_Text('website');
        $website->setAttrib('class', 'txt_put');
        $website->setAttrib('id', 'website');
        $website->setAttrib('tabindex', '6');
        $website->setAttrib($value,'true');

      
         $submit = new Zend_Form_Element_Submit('Submit');
	 $back= new Zend_Form_Element_Submit('Back');


         $this->addElements( array ($email,$website,$submit,$back));

		
	}
}
/** end of class */
