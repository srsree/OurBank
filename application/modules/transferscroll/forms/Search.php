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
 *  create searchform elements
 */
class Transferscroll_Form_Search extends Zend_Form {
	public function init() {
		Zend_Dojo::enableForm($this);
	}
	public function __construct($options = null) {
		Zend_Dojo::enableForm($this);
		parent::__construct($options);
	
		$field1 = new Zend_Form_Element('datefrom');
		$field1->setAttrib('class', 'txt_put');
	
	
		$submit = new Zend_Form_Element_Submit('Search');
		$pdf=new Zend_Form_Element_Submit('PDF');
		//add element to form
		$this->addElements(array($field1,$submit,$pdf));
	}
}
