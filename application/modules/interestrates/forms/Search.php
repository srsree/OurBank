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
class Interestrates_Form_Search extends Zend_Form {
    public function init() {
		$formfield = new App_Form_Field();
		$search_interest_name = $formfield->field('Text','search_interest_name','','','','','','','','','','','','');
		$search_credit_interest = $formfield->field('Select','search_credit_interest','','','','','','','','','','','','');
	        $this->addElements(array($search_interest_name,$search_credit_interest));
    }
}
