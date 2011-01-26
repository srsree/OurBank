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
class Outstanding_Form_Search extends ZendX_JQuery_Form {
    public function init() {
	//$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	$formfield = new App_Form_Field ();
	$bank = $formfield->field('Select','bank','','','','',false,'','','','','','','');
	$activity = $formfield->field('Select','activity','','','','',false,'','','','','','','');
	$creditline = $formfield->field('Select','creditline','','','','',false,'','','','','','','');
	$year = $formfield->field('Select','year','','','','',false,'','','','','','','');
	$month = $formfield->field('Select','month','','','','',false,'','','','','','','');
        $submit = new Zend_Form_Element_Submit('Search');
	 $pdf=new Zend_Form_Element_Submit('PDF');

        $this->addElements(array($bank,$activity,$creditline,$month,$year,$submit,$pdf));

    }
}
