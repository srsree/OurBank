<?php
class Loandisbursmentg_Form_loandisbursement extends Zend_Form 
{
    public function __construct()
    {
        parent::__construct();

        $date = new ZendX_JQuery_Form_Element_DatePicker('date');
        $date->setAttrib('class', 'txt_put');
        $date->setJQueryParam('dateFormat', 'yy-mm-dd');
        $date->setRequired(true);

		$Amount = new Zend_Form_Element_Text('Amount');
		$Amount->setAttrib('class', 'textfield');
        $graterthan=new Zend_Validate_GreaterThan(0);
        $Amount->setRequired(true)
        ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));

		$description = new Zend_Form_Element_Textarea('description');
		$description->setAttrib('rows', '2');
		$description->setAttrib('cols', '20');
		$description->setRequired(true);

		$sms = new Zend_Form_Element_Checkbox('sms');
        $back = new Zend_Form_Element_Submit('Back');
        $back->setAttrib('id', 'button2');

		$submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('id', 'button');
		$this->addElements( array($date,$Amount,$description,$submit,$back,$sms));
	}
}
