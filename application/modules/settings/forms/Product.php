<?php
class Management_Form_Product extends Zend_Form {
    public function init() {
        Zend_Dojo::enableForm($this);
    }
    public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);

        $category_id = new Zend_Form_Element_Select('category_id');
        $category_id->addMultiOption('','Select...');
        $category_id->setAttrib('class', 'txt_put')
                     ->setLabel('Category  Name');
        $category_id->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

        $productname = new Zend_Form_Element_Text('productname');
        $productname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productdetails', 'productname'));
        $productname->setAttrib('class', 'txt_put')
                     ->setLabel('Product Name');
        $productname->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));



        $product_id = new Zend_Form_Element_Hidden('product_id');
        $product_id->setAttrib('class', 'txt_put');


       $productshortname= new Zend_Form_Element_Text('productshortname');
       $productshortname->setAttrib('class', 'txt_put')
                           ->setLabel('Product Short Name');
       $productshortname->setRequired(true)
               ->addValidators(array(array('NotEmpty')))
               ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

      
       $product_description= new Zend_Form_Element_Textarea('product_description', array('rows' => 3,'cols' => 20,));
       $product_description->setAttrib('class', '')
                           ->setLabel('Productdescription');
       $product_description->setRequired(true)
               ->addValidators(array(array('NotEmpty')))
               ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));



        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('id', 'save')
               ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('colspan' => '8 ')),
                             array(array('data'=>'HtmlTag'), array('tag' => 'td ', 'colspan'=>'8')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));



        $this->addElements(array($category_id,$productname,$productshortname,$product_description,$product_id,$submit));
        $this->setDecorators(array('FormElements',array(array('data'=>'HtmlTag'),array('tag'=>'table' ,'id' =>'hor-minimalist-b')),'Form'));


    }
}