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
class Agriculture_Form_agriculture extends Zend_Form {
    public function init()
    {} 

    public function __construct($number) 
    {
        //$number = number family members
        //create a health form elements...

        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();

      

        $ownername = $formfield->field('Text','ownername','','','','',true,'','','','','',0,0);
        $survey = $formfield->field('Text','survey','','','','',true,'','','','','',0,0);
        $survey->setAttrib('size',10);
        $acre = $formfield->field('Text','acre','','','','',true,'','','','','',0,0);
        $acre->setAttrib('size',5);
        $acrevalue = $formfield->field('Text','acrevalue','','','','',true,'','','','','',0,0);
        $acrevalue->setAttrib('size',5);

        $tenant = new Zend_Form_Element_Select('tenant');
        $tenant->removeDecorator('DtDdWrapper'); 
        $tenant->removeDecorator('HtmlTag');
        $tenant->removeDecorator('label');

     

        $village = $formfield->field('Text','village','','','','',true,'','','','','',0,0);


        $ownertype = new Zend_Form_Element_Select('ownertype');
        $ownertype->removeDecorator('DtDdWrapper'); 
        $ownertype->removeDecorator('HtmlTag');
        $ownertype->removeDecorator('label');

        $land_id = $formfield->field('Hidden','land_id','','','','','','','','','','',0,0);
        $this->addElements(array($tenant,$ownername,$village,$survey,$acre,$acrevalue,$ownertype,$land_id));
	
    }

}
