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
class Management_Form_Fee extends Zend_Form {
    public function init() {
        Zend_Dojo::enableForm($this);
    }
    public function __construct($currencysymbol) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);

        $feename = new Zend_Form_Element_Text('feename');
        $feename->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_feedetails', 'feename'));
        $feename->setAttrib('class', 'txt_put')
                     ->setLabel('Fee Name');
        $feename->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td',"'..'")),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
							 


       $feedescription= new Zend_Form_Element_Textarea('feedescription', array('rows' => 3,'cols' => 20,));
       $feedescription->setAttrib('class', '')
                           ->setLabel('Description');
       $feedescription->setRequired(true)
               ->addValidators(array(array('NotEmpty')))
               ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

        $feeappliesto_id = new Zend_Form_Element_Select('feeappliesto_id');
        $feeappliesto_id->addMultiOption('','Select...');
        $feeappliesto_id->setAttrib('class', 'txt_put')
                     ->setLabel('Member Type');
        $feeappliesto_id->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

        $feefrequency_id = new Zend_Form_Element_Select('feefrequency_id');
        $feefrequency_id->addMultiOption('','Select...');
        $feefrequency_id->setAttrib('class', 'txt_put')
                     ->setLabel('Fee for');
        $feefrequency_id->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

        $feevalue = new Zend_Form_Element_Text('feevalue');
        $feevalue->setAttrib('class', 'txt_put')
                     ->setLabel('Fee Amount');
        $feevalue->setRequired(true)
                     ->addValidators(array(array('NotEmpty')))
                     ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                             array('Label', array('tag' => 'td')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

        $fee_id = new Zend_Form_Element_Hidden('fee_id');
        $fee_id->setAttrib('class', 'txt_put');



        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('id', 'Submit')
               ->setDecorators(array('ViewHelper',
                             array('Description',array('tag'=>'','escape'=>false)),'Errors',
                             array(array('data'=>'HtmlTag'), array('colspan' => '8 ')),
                             array(array('data'=>'HtmlTag'), array('tag' => 'td ', 'colspan'=>'8')),
                             array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));



        $this->addElements(array($fee_id,$feename,$feevalue,$feedescription,$feeappliesto_id,$feefrequency_id,$product_id,$submit));
        $this->setDecorators(array('FormElements',array(array('data'=>'HtmlTag'),array('tag'=>'table' ,'id' =>'hor-minimalist-b')),'Form'));


    }
}