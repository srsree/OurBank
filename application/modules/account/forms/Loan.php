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
class Account_Form_Loan extends ZendX_JQuery_Form
{
    public function init()
    {
        Zend_Dojo::enableForm($this);
    }


    public function __construct($app)
    {
        Zend_Dojo::enableForm($this);
        parent::__construct($app);

        $interest_category = new Zend_Form_Element_Select('interest_category');
	$interest_category->addMultiOption('','select');
        $interest_category->setRequired(true);
        $interest_category->setAttrib('onchange', 'getinterestcategory(this.value,"'.$app.'")');

        $creditline_id = new Zend_Form_Element_Select('creditline_id');
	$creditline_id->addMultiOption('','select');
        $creditline_id->setRegisterInArrayValidator(false);
        $creditline_id->setRequired(true);
        $creditline_id->setAttrib('onchange', 'getinterestranges(this.value,"'.$app.'"),getcreditline(this.value,"'.$app.'")');


        $startdate = new ZendX_JQuery_Form_Element_DatePicker('loanAccountdate');
        $startdate->setJQueryParam('dateFormat', 'yy-mm-dd');
        $startdate->setAttrib('class', 'txt_put');
        $startdate->setRequired(true);

        $amount = new Zend_Form_Element_Text('amount');
        $amount->setAttrib('class', 'txt_put');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $amount->setRequired(true)
		 ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $amount->setAttrib('onchange','getinterest(this.value,"'.$app.'"),getballet(this.value,"'.$app.'"),getfeepercent(this.value,"'.$app.'")');

        $interest = new Zend_Form_Element_Text('interest');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $interest->setRequired(true)
		 ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $interest->setAttrib('class', 'txt_put');
        $interest->setAttrib('readonly', 'true');

        $installments = new Zend_Form_Element_Select('installments');
	$installments->addMultiOption('','select');
        $installments->setRequired(true);

        $ballet = new Zend_Form_Element_Text('ballet');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $ballet->setRequired(true)
		 ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $ballet->setAttrib('class', 'txt_put');
        $ballet->setAttrib('readonly', 'true');

        $fee = new Zend_Form_Element_Text('fee');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $fee->setRequired(true)
		 ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $fee->setAttrib('class', 'txt_put');
        $fee->setAttrib('readonly', 'true');
        $fee->setAttrib('onclick','getfee(this.value,"'.$app.'")');

        $members = new Zend_Form_Element_MultiCheckbox('members');
        $members->setAttrib('class', 'txt_put');
        $members->setRequired(true);


        $activityname = new Zend_Form_Element_Select('activity_id');
	$activityname->addMultiOption('','select');
        $activityname->setRequired(true);

        $cteditlineamount = new Zend_Form_Element_Text('cteditlineamount');
        $cteditlineamount->setAttrib('class', 'txt_put');
        $cteditlineamount->setAttrib('readonly', 'true');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $cteditlineamount->setRequired(true)
		 ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));

        $feepercent = new Zend_Form_Element_Hidden('feepercent');
        $feepercent->setAttrib('class', 'txt_put');
        $feepercent->setAttrib('id', 'fee');

        $back = new Zend_Form_Element_Submit('Back');
        $back->setAttrib('id', 'button2');

        $this->addElements( array($creditline_id,$startdate,$amount,$installments,$interest,$ballet,$back,$members,$fee,$cteditlineamount,$activityname,$interest_category,$feepercent));

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('id', 'button');

        $this->addElements(array($submit));
    }
}
