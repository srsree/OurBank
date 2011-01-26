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
 *  create search form elements for office
 */
class Office_Form_Search extends Zend_Dojo_Form {


    public function init() {
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
        $vtype=array('Digits');				
        $office_type = $formfield->field('Select','office','','','','Office type:','','','','','','',0,0);
        $shortname = $formfield->field('Text','shortname','','','','Office Short Name:','','','','','','',0,0);
        $city = $formfield->field('Text','city','','','','City:','','','','','','',0,0);
        $officename = $formfield->field('Text','officename','','','','Office Name:','','','','','','',0,0);
	//add elements to form
        $this->addElements(array($office_type,$shortname,$city,$officename));

    }
}
