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
class Management_Form_Meeting extends Zend_Form{

 public function init() {
        Zend_Dojo::enableForm($this);
    }
        public function __construct($path) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);

        $meetingupdates_id = new Zend_Form_Element_Hidden('meetingupdates_id');

        $meeting_id  = new Zend_Form_Element_Hidden('meeting_id');
        $meeting_id ->setAttrib('class', 'txt_put');

        $meeting_name = new Zend_Form_Element_Text('meeting_name');
        $meeting_name->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $meeting_name->setAttrib('class', 'txt_put');
        $meeting_name->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_meetingdetails', 'meeting_name'));


        $meeting_days=new Zend_Form_Element_Select('meeting_days');
	$meeting_days->addMultiOption('','SelectTheDay'.'...');
        $meeting_days->setAttrib('class', 'selectbutton');

        $meeting_place=new Zend_Form_Element_Text('meeting_place');
        $meeting_place->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $meeting_place->setAttrib('class', 'txt_put');

        $meeting_time=new Zend_Form_Element_Text('meeting_time');
        $meeting_time->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $meeting_time->setAttrib('class', 'txt_put');

        $timeg=new Zend_Form_Element_Select('timeg');
        $timeg->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $timeg->setAttrib('class', 'txt_put');

        $group_head=new Zend_Form_Element_Select('group_head');
        $group_head->addMultiOption('','select'.'...');
        $group_head->setAttrib('class','selectbutton');

        $officetype_id = new Zend_Form_Element_Select('officetype_id');
        $officetype_id->setRequired(true);
        $officetype_id->addMultiOption('','select'.'...');
        $officetype_id->setAttrib('class','selectbutton');
        $officetype_id->setAttrib('onchange', 'getGroups(this.value,"'.$path.'")');


        $group = new Zend_Form_Element_Select('group');
        $group->addMultiOption('','select'.'...');
        $group->setAttrib('class','selectbutton');
        $group->setRegisterInArrayValidator(false);
//         $group->setAttrib('onchange', 'getGroupHead(this.value,"'.$path.'")');


        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'officesubmit');
	$submit->setLabel('Submit');


         $this->addElements(array($meetingupdates_id,$meeting_id,$meeting_name,$meeting_days,$meeting_place,$timeg,$group_head,
                                  $officetype_id,$group,$submit,$meeting_time));
	}
}


/**class end*/
