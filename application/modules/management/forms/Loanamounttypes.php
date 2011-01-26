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
	class Management_Form_Loanamounttypes extends Zend_Form {

	public function init() {
		$laonamount_type_name = new Zend_Form_Element_Text('laonamount_type_name');
		$laonamount_type_name->setAttrib('class', 'txt_put');
		$laonamount_type_name->setAttrib('size', '10');

		$laonamount_type_description = new Zend_Form_Element_Select('laonamount_type_description');
		$laonamount_type_description->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_loanamount_typedetails', 'loanamount_type_id','intereststatus_id=3'));
		$laonamount_type_description->addMultiOption('','select');
		$laonamount_type_description->setAttrib('class', 'txt_put');
		$laonamount_type_description->setAttrib('id', 'laonamount_type_description');
		$laonamount_type_description->setLabel('laonamount_type_description')
					->setRequired(true)
					->addValidators(array(array('NotEmpty')));

		$laonamount_type_id = new Zend_Form_Element_Hidden('laonamount_type_id');

		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setLabel('submit');
		$submit->setAttrib('class', 'officesubmit');

		$this->addElements(array($submit,$laonamount_type_description,$laonamount_type_name,$laonamount_type_id));
	}
}