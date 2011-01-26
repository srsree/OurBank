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
class Fixedtransaction_Form_transferfunds extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);

        $accountId1 = new Zend_Form_Element_Hidden('accountId');
        $productId1 = new Zend_Form_Element_Hidden('productId');
        $memberId1 = new Zend_Form_Element_Hidden('memberId');
        $maturedamount = new Zend_Form_Element_Hidden('maturedinterestamount');
        $interestamountto = new Zend_Form_Element_Hidden('interestamountto');
        $capitalamount= new Zend_Form_Element_Hidden('capitalamount');
        $penalinterest= new Zend_Form_Element_Hidden('penalinterest');

        $paymenttype = new Zend_Form_Element_Select('paymenttype');
        $paymenttype->addMultiOption('','select..');
        $paymenttype->setAttrib('class','NormalBtn');
        $paymenttype->setAttrib('id', 'paymenttype');
        $paymenttype->setAttrib('onchange','toggleField();');
        $paymenttype->setRequired(true);

        $description = new Zend_Form_Element_Textarea('transactiondescription');
        $description->setAttrib('class', 'textfield');
        $description->setAttrib('rows','2');
        $description->setAttrib('cols','20');
        $description->setRequired(true);

        $no = new Zend_Form_Element_Textarea('paymenttype_details');
        $no->setAttrib('class', 'textfield');
        $no->setAttrib('rows','1');
        $no->setAttrib('cols','20');
        $no->setAttrib('id', 'paymenttype_details');
        $no->setAttrib('style','display:none;');
        $no->setRequired(true);

        $paymenttype1 = new Zend_Form_Element_Hidden('paymenttype1');
        $paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
        $transactiondescription1 = new Zend_Form_Element_Hidden('transactiondescription1');


        $Confirm = new Zend_Form_Element_Submit('Confirm');
        $Confirm->setLabel('Confirm');
        $Confirm->setAttrib('class', 'Confirm');

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setLabel('Submit');
        $submit->setAttrib('class', 'recurring');

        $this->addElements( array($accountId1,$productId1,$memberId1,$maturedamount,$submit,$capitalamount,$interestamountto,$penalinterest,$paymenttype,$description,$no,$Confirm,$paymenttype1,$paymenttype_details1,$transactiondescription1));
    }
}
