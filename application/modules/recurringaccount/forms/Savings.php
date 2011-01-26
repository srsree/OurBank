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
class Fixedaccount_Form_Savings extends Zend_Form 
{
    public function init() 
    {
    }
    public function __construct($minimumDeposit,$ID,$memberID) 
    {
        parent::__construct($minimumDeposit);
        parent::__construct($ID);
        parent::__construct($memberID);
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
       	$formfield = new App_Form_Field ();
        $amount = $formfield->field('Text','amount','','','txt_put','',true,'','','','','',0,0);
        $amount->addValidators(array(array('Float'),
                                      array('GreaterThan',false,array($minimumDeposit-.0001,
                                            'messages' => array('notGreaterThan' => 'Minimum 
                                             Amount To open a savings account ='.$minimumDeposit)))));
        $date = new ZendX_JQuery_Form_Element_DatePicker('date');
        $date->setAttrib('class', 'txt_put');
        $date->setJQueryParam('dateFormat', 'yy-mm-dd');
        $date->setRequired(true);
        //hidden feilds
	$memberId = $formfield->field('Hidden','memberId','','','','',false,'','','','','',0,$memberID);
	$Id = $formfield->field('Hidden','Id','','','','',false,'','','','','',0,$ID);
	$submit = $formfield->field('Submit','Submit','','','','',false,'','','','','',0,0);
	$Yes = $formfield->field('Submit','Yes','','','','',false,'','','','','',0,0);
	$back = $formfield->field('Submit','Back','','','','',false,'','','','','',0,0);
        $this->addElements(array($submit,$amount,$memberId,$Id,$date,$back,$Yes));
    }
}
