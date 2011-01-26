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