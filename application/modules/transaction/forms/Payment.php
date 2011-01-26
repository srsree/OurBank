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
class Transaction_Form_Payment extends Zend_Form{

 public function init() {
        Zend_Dojo::enableForm($this);
    }
        public function __construct($path) {

        $fromglcode=new Zend_Form_Element_Select('fromglcode');
	$fromglcode->addMultiOption('','Select'.'...');
        $fromglcode->setAttrib('class', 'selectbutton');
//         $fromglcode->setRequired(true)
//                     ->addValidators(array(array('NotEmpty')));
        $fromglcode->setAttrib('onchange', 'getglcode(this.value,"'.$path.'")');

        $fromglsubcode=new Zend_Form_Element_Select('fromglsubcode');
	$fromglsubcode->addMultiOption('','Select'.'...');
        $fromglsubcode->setAttrib('class', 'selectbutton');

        $toglcode=new Zend_Form_Element_Select('toglcode');
	$toglcode->addMultiOption('','Select'.'...');
        $toglcode->setAttrib('class', 'selectbutton');
        $toglcode->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $toglcode->setAttrib('onchange', 'gettoglcode(this.value,"'.$path.'")');

        $toglsubcode=new Zend_Form_Element_Select('toglsubcode');
	$toglsubcode->addMultiOption('','Select'.'...');
        $toglsubcode->setAttrib('class', 'selectbutton');


        $amount=new Zend_Form_Element_Text('amount');
        $amount->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $amount->setAttrib('class', 'txt_put');

        $transactiondate=new Zend_Form_Element_Text('transactiondate');
        $transactiondate->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $transactiondate->setAttrib('class', 'txt_put');

	$description = new Zend_Form_Element_Textarea('description');
	$description->setAttrib('class', 'textfield');
 	$description->setAttrib('rows','1');
	$description->setAttrib('cols','20');
	$description->setAttrib('id', 'description');
	$description->setRequired(true);


        $officeType=new Zend_Form_Element_Select('officeType');
	$officeType->addMultiOption('','Select'.'...');
        $officeType->setAttrib('class', 'selectbutton');
        $officeType->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $officeType->setAttrib('onchange', 'getBranch(this.value,"'.$path.'")');

        $subOffice=new Zend_Form_Element_Select('subOffice');
	$subOffice->addMultiOption('','Select'.'...');
        $subOffice->setAttrib('class', 'selectbutton');

	$paymenttype = new Zend_Form_Element_Select('paymenttype');
	$paymenttype->addMultiOption('','select');
	$paymenttype->setAttrib('class','NormalBtn');
	$paymenttype->setAttrib('id', 'paymenttype');
	$paymenttype->setAttrib('onchange','toggleField();');
	$paymenttype->setRequired(true);


	$no = new Zend_Form_Element_Textarea('paymenttype_details');
	$no->setAttrib('class', 'textfield');
 	$no->setAttrib('rows','1');
	$no->setAttrib('cols','20');
	$no->setAttrib('id', 'paymenttype_details');
	$no->setAttrib('style','display:none;');
	$no->setRequired(true);


        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'officesubmit');

        $this->addElements(array($fromglcode,$fromglsubcode,$toglcode,$toglsubcode,$amount,$transactiondate,$description,$submit,$officeType,$subOffice,$paymenttype,$no));
    }
}


/**class end*/
