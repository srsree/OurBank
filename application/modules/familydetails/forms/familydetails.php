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
class Familydetails_Form_familydetails extends Zend_Form {
    public function init()
    {} 
//add family details form elements
    public function __construct($number) 
    {
         parent::__construct($number);
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
	 for($i=1;$i<=$number;$i++) {
        $name = $formfield->field('Text','name'.$i,'','','','','','','','','','',0,0);
        $age = $formfield->field('Text','age'.$i,'','','','','','','','','','',0,0);

        $gender = new Zend_Form_Element_Select('gender'.$i);
        $gender->removeDecorator('DtDdWrapper'); 
        $gender->removeDecorator('HtmlTag');
        $gender->removeDecorator('label');

        $relation = new Zend_Form_Element_Select('relationship'.$i);
        $relation->removeDecorator('DtDdWrapper'); 
        $relation->removeDecorator('HtmlTag');
        $relation->removeDecorator('label');

        $physical = new Zend_Form_Element_Select('physicalstatus'.$i);
        $physical->removeDecorator('DtDdWrapper'); 
        $physical->removeDecorator('HtmlTag');
        $physical->removeDecorator('label');

        $marital = new Zend_Form_Element_Select('maritalstatus'.$i);
        $marital->removeDecorator('DtDdWrapper'); 
        $marital->removeDecorator('HtmlTag');
        $marital->removeDecorator('label');

        $familymemberid = $formfield->field('Hidden','familymember_id'.$i,'','','','','','','','','','',0,0);
        $this->addElements(array($name,$age,$gender,$relation,$physical,$marital,$familymemberid));
	}
    }
}
