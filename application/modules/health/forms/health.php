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
class Health_Form_health extends Zend_Form {
    public function init()
    {} 

    public function __construct($number) 
    {
        //$number = number family members
        //create a health form elements...
         parent::__construct($number);
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
	 for($i=1;$i<=$number;$i++) {
        $name = $formfield->field('Text','name'.$i,'','','','',true,'','','','','',0,0);
        $name->setAttrib('readonly','');

        $health = new Zend_Form_Element_Select('health'.$i);
        $health->removeDecorator('DtDdWrapper'); 
        $health->removeDecorator('HtmlTag');
        $health->removeDecorator('label');

        $treatment = new Zend_Form_Element_Select('treatment'.$i);
        $treatment->removeDecorator('DtDdWrapper'); 
        $treatment->removeDecorator('HtmlTag');
        $treatment->removeDecorator('label');

        $Accessibility = new Zend_Form_Element_Select('accessability'.$i);
        $Accessibility->removeDecorator('DtDdWrapper'); 
        $Accessibility->removeDecorator('HtmlTag');
        $Accessibility->removeDecorator('label');

        $familymemberid = $formfield->field('Hidden','familymemberid'.$i,'','','','','','','','','','',0,0);
        $this->addElements(array($name,$health,$treatment,$Accessibility,$familymemberid));
	}
    }
}
