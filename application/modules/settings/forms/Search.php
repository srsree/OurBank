<?php
class Management_Form_Search extends Zend_Dojo_Form {
    public function init() {

        $field1 = new Zend_Form_Element_Select('field1');
        $field1->addMultiOption('','Select...');
        $field1->setAttrib('class', 'txt_put');

        $field2 = new Zend_Form_Element_Text('field2');
        $field2->setAttrib('class', 'txt_put');

        $field3 = new Zend_Form_Element_Text('field3');
        $field3->setAttrib('class', 'txt_put');

        $field4 = new Zend_Form_Element_Text('field4');
        $field4->setAttrib('class', 'txt_put');

        $submit = new Zend_Form_Element_Submit('Search');

        $this->addElements(array($field1,$field2,$field3,$field4,$submit));

    }
}