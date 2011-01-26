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
/**  
* class is used to create a form for SavingInstance details along with the validation
*/
class Attendance_Form_Attendance extends Zend_Form 
{
    public function __construct($path) {
        parent::__construct($path);

        $formfield = new App_Form_Field ();
        $vtype=array('Float');
// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value
        $meeting_name = new Zend_Form_Element_Select('meeting_name');
        $meeting_name->addMultiOption('','Select...');
        $meeting_name->setAttrib('class', 'mand');
        $meeting_name->setAttrib('id', 'meeting_name');
        $meeting_name->setAttrib('onchange', 'getMembers1(this.value,"'.$path.'",10)');
        $meeting_name->setRequired(true);

        $meeting_date = $formfield->field('Text','meeting_date','','','mand','Meeting date',true,'','','','','','','');
        $submit = $formfield->field('Submit','Submit','','','','Submit','','','','','','','','');
        $Back = $formfield->field('Submit','Back','','','','Back','','','','','','','','');

        $this->addElements( array($meeting_name,$meeting_date,$Back,$submit));
    }
}
/** end of class */
