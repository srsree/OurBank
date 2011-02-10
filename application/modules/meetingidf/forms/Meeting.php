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
    class Meeting_Form_Meeting extends Zend_Form 
    {

    public function init() {
    }

    public function __construct($path) {
        parent::__construct($path);

        $formfield = new App_Form_Field ();
// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value

        $meeting_name = $formfield->field('Text','meeting_name','','','mand','',true,'','','','','','','');
        $group_head = $formfield->field('Text','group_head','','','mand','','','','','','','','','');
        $hiddenId=new Zend_Form_Element_Hidden('group_head_id');
        $meeting_place = $formfield->field('Text','meeting_place','','','mand','',true,'','','','','','','');
        $meeting_time = $formfield->field('Text','meeting_time','','','mand','',true,'','','','','','','');

        $institute_bank_id = new Zend_Form_Element_Select('institute_bank_id');
        $institute_bank_id->addMultiOption('','Select...');
        $institute_bank_id->setAttrib('class', 'txt_put');
        $institute_bank_id->setAttrib('onchange', 'getGroups(this.value,"'.$path.'")');
        $institute_bank_id->addValidators(array(array('NotEmpty')));

        $group_name = new Zend_Form_Element_Select('group_name');
        $group_name->addMultiOption('','Select...');
        $group_name->setAttrib('class', 'txt_put');
//         $group_name->setAttrib('onchange', 'getHeadName(this.value,"'.$path.'")');
        $group_name->setRequired(true)
                        ->setRegisterInArrayValidator(false)
                        ->addValidators(array(array('NotEmpty')));
        
        $meeting_day = $formfield->field('Select','meeting_day','','','mand','',true,'','','','','','','');
        $submit = $formfield->field('Submit','Submit','','','','Submit','','','','','','','','');
        $Back = $formfield->field('Submit','Back','','','','Back','','','','','','','','');


        $this->addElements( array ($meeting_name,$group_head,$meeting_place,$meeting_time,$institute_bank_id,$group_name,$meeting_day,$Back,$hiddenId,$submit));
    }
}