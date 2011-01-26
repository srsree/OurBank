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

class Transaction_Form_recurringstatus extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		parent::__construct();

		$account_id = new Zend_Form_Element_Hidden('accountId');
		$product_id = new Zend_Form_Element_Hidden('productId');

		$newStatus = new Zend_Form_Element_Select('newStatus');
		$newStatus->setAttrib('class', 'NormalBtn');
		$newStatus->setRequired(true);
		$newStatus->addMultiOption('','Select...');

		$description = new Zend_Form_Element_Textarea('description');
		$description->setAttrib('class', 'textfield');
		$description->setAttrib('rows','2');
		$description->setAttrib('cols','20');
		$description->setRequired(true);

		$newStatus1 = new Zend_Form_Element_Hidden('newStatus1');
		$description1 = new Zend_Form_Element_Hidden('description1');
	
		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setLabel('submit');
		$submit->setAttrib('class', 'recurring');

		$Confirm = new Zend_Form_Element_Submit('Confirm');
		$Confirm->setLabel('Confirm');
		$Confirm->setAttrib('class', 'recurring');

		$this->addElements(array($submit,$description,$newStatus,$account_id,$product_id,$Confirm,$newStatus1,$description1));
    }
}
