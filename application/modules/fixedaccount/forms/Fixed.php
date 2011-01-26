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
class Fixedaccount_Form_Fixed extends Zend_Form 
{
   public function __construct($path) {
    parent::__construct($path);
        $date1 = new ZendX_JQuery_Form_Element_DatePicker('date1');
        $date1->setAttrib('class', 'txt_put');
        $date1->setJQueryParam('dateFormat', 'yy-mm-dd');
        $date1->setRequired(true);

        $period = new Zend_Form_Element_Select('period');
        $period->addMultiOption('','Select...');
        $period->setAttrib('class', 'txt_put');
        $period->setRequired(true);
        $period->setAttrib('onchange', 'getInterests("'.$path.'",this.value)');

        $interest = new Zend_Form_Element_Text('interest');
        $interest->setAttrib('class', 'txt_put');
//         $interest->setAttrib('id', 'interestval');
//         $interest->setAttrib('readonly', 'true');

        $tAmount = new Zend_Form_Element_Text('tAmount');
        $tAmount->setAttrib('class', 'txt_put');
        $tAmount->setAttrib('onchange', 'calculateMatureAmount()');

        $matureamount = new Zend_Form_Element_Text('matureamount');
        $matureamount->setAttrib('class', 'txt_put');

        $amount = new Zend_Form_Element_Text('amount');
        $amount->setAttrib('class', 'txt_put');
//         $amount->setRequired(true);
        $amount->setAttrib('onchange', 'calculateTotalAmount(this.value),calculateMatureAmount()');

        $memberfirstname = new Zend_Form_Element_MultiCheckbox('memberfirstname');
        $memberfirstname->setAttrib('class', 'textfield');
//         $memberfirstname->setRequired(true);

        $fixedfee = new Zend_Form_Element_Text('fixedfee');
        $fixedfee->setAttrib('class', 'txt_put');
        $fixedfee->setAttrib('readonly', 'true');

        $totalamount = new Zend_Form_Element_Text('totalamount');
        $totalamount->setAttrib('class', 'txt_put');
        $totalamount->setAttrib('readonly', 'true');

        $memberId = new Zend_Form_Element_Hidden('memberId');

        $productId= new Zend_Form_Element_Hidden('Id');

        $membercode= new Zend_Form_Element_Hidden('code');

        $typeId = new Zend_Form_Element_Hidden('typeId');

        $Type= new Zend_Form_Element_Hidden('Type');

        $memberTypeIdv = new Zend_Form_Element_Hidden('memberTypeIdv');

        $submit = new Zend_Form_Element_Submit('Submit');

        $Yes = new Zend_Form_Element_Submit('Yes');

        $back = new Zend_Form_Element_Submit('Back');

        $this->addElements(array($submit,$amount,$period,$matureamount,$interest,$tAmount,
                                 $memberfirstname,$fixedfee,$memberId,$membercode,$totalamount,$Type,$date1,$productId,$typeId,$memberTypeIdv,
                                 $Yes,$back));
        }
}
