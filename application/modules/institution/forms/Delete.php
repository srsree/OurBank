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
/*
 *  create form elements for delete institution
 */ 
class Institution_Form_Delete extends Zend_Form {
	public function init() {
		$remarks = new Zend_Form_Element_Textarea('remarks');
		$remarks->setAttrib('class', 'textfield');
		$remarks->setAttrib('id', 'remarks');
		$remarks->setAttrib('rows','2');
		$remarks->setAttrib('cols','20');
		$remarks->setRequired(true)
		->addValidators(array(array('NotEmpty')));
		//add submit button
		$submit_yes = new Zend_Form_Element_Submit('Yes');
		$submit_yes->setAttrib('id', 'Yes');
		//add elements to form
		$this->addElements(array($remarks,$submit_yes));
	}
}
