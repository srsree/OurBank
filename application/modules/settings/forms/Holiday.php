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
class Management_Form_Holiday extends Zend_Form {
    public function init() {
        Zend_Dojo::enableForm($this);
    }
    public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);

        $holidayname = new Zend_Form_Element_Text('holidayname');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));



        $office_id = new Zend_Form_Element_Select('office_id');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));


        $holiday_id = new Zend_Form_Element_Hidden('holiday_id');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));


       $holidayfrom= new ZendX_JQuery_Form_Element_DatePicker('holidayfrom');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));





       $holidayupto = new ZendX_JQuery_Form_Element_DatePicker('holidayupto');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));


        $holidayrepayment_id = new ZendX_JQuery_Form_Element_DatePicker('holidayrepayment_id');
        $holidayname->setAttrib('class', 'txt_put');
        $holidayname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));


        $submit = new Zend_Form_Element_Submit('Submit');




        $this->addElements(array($holidayname,$office_id,$holidayfrom,$holidayupto,$holiday_id,$holidayrepayment_id,$submit));



    }
}