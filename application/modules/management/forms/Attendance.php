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
class Management_Form_Attendance extends Zend_Form{

 public function init() {
        Zend_Dojo::enableForm($this);
    }
        
        public function __construct($path) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);

        $attendanceupdates_id = new Zend_Form_Element_Hidden('attendanceupdates_id');

        $attendance_id  = new Zend_Form_Element_Hidden('attendance_id');
        $attendance_id ->setAttrib('class', 'txt_put');

        $officetype_id = new Zend_Form_Element_Select('officetype_id');
        $officetype_id->setRequired(true);
        $officetype_id->addMultiOption('','select'.'...');
        $officetype_id->setAttrib('class','selectbutton');
        $officetype_id->setAttrib('onchange', 'getGroups(this.value,"'.$path.'")');


        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'officesubmit');
	$submit->setLabel('Submit');


         $this->addElements(array($officetype_id,$submit,$attendanceupdates_id,$attendance_id));
	}
}


/**class end*/
