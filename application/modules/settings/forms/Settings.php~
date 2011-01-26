<?php
class settings_Form_Settings extends  ZendX_JQuery_Form {
public function init() {



$languages = new Zend_Form_Element_Select('languages');
$languages->addMultiOption('','Select...');
$languages->setAttrib('class', 'txt_put');
$languages->setRequired(true)
->addValidators(array(array('NotEmpty')));
$languages->setAttrib('onchange', 'getmember(this.value,"'.$app.'")');

$submit = new Zend_Form_Element_Submit('Submit');
$submit->removeDecorator('DtDdWrapper');
$this->addElements(array($languages,$submit));

}
}