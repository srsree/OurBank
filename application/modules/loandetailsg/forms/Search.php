<?php
class Loandetailsg_Form_Search extends Zend_Form 
{
    public function init() 
    {
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $num = new Zend_Form_Element_Text('accNum');
        $num->setAttrib('class', 'txt_put');
	    $num->setRequired(true);
        $submit = new Zend_Form_Element_Submit('Search');
        $this->addElements(array($num,$submit));
    }
}