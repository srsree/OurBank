<?php
class settings_Form_Drop extends  ZendX_JQuery_Form 
{
    public function init() 
    {
       
$name = new Zend_Form_Element_Text('name');
        $name->setAttrib('class', 'txt_put');
        $name->addValidators(array(array('NotEmpty')))
                    ->setRequired(true);



       

        $this->addElements(array($name));
    }
}