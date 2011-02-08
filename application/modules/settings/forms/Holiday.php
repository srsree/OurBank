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