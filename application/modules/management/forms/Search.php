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
class Management_Form_Search extends ZendX_JQuery_Form {
    public function init() {

        $field1 = new Zend_Form_Element_Select('field1');
        $field1->addMultiOption('','Select');
        $field1->setAttrib('size', '12');


        $field2 = new Zend_Form_Element_Text('field2');
        $field2->setAttrib('size', '12');


        $field3 = new Zend_Form_Element_Text('field3');
        $field3->setAttrib('size', '12');


        $field4 = new Zend_Form_Element_Text('field4');
        $field4->setAttrib('size', '12');


        $field5 = new Zend_Form_Element_Select('field5');
        $field5->addMultiOption('','Select');

        $field6 = new Zend_Form_Element_Text('field6');
        $field6->setAttrib('size', '12');
        
        $field7 = new ZendX_JQuery_Form_Element_DatePicker('field7');
        $field7->setAttrib('size', '12');
        
        $field8 = new ZendX_JQuery_Form_Element_DatePicker('field8');
        $field8->setAttrib('size', '12');

  $field9 = new Zend_Form_Element_Select('field9');
        $field9->addMultiOption('','Select');

  $field10 = new Zend_Form_Element_Select('field10');
        $field10->addMultiOption('','Select');

        $submit = new Zend_Form_Element_Submit('Search');

        $this->addElements(array($field1,$field2,$field3,$field4,$field5,$field6,$field7,$field8,$submit,$field9,$field10));

    }
}