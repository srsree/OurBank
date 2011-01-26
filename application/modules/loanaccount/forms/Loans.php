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
class Loanaccount_Form_Loans extends Zend_Form 
{
    public function init() 
    {
    }
    public function __construct($minimumDeposit,$ID,$codenum,$app) 
    {

        parent::__construct($minimumDeposit,$ID,$codenum,$app);
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
        
        $installments = $formfield->field('Select','installments','','','txt_put','',true,'','','','','',0,0);
        $installments->setAttrib('onchange','getInterests(this.value,"'.$app.'",'.base64_decode($ID).')');
        
        $interest = $formfield->field('Text','interest','','','txt_put','',true,'','','','','',0,0);
        $interest->setAttrib('size', '6');
        $interest->setAttrib('readonly', 'true');
        
        $interesttype = $formfield->field('Select','interesttype_id','','','txt_put','',true,'','','','','',0,0);

        $savingAccount = $formfield->field('Select','savingAccount','','','txt_put','',true,'','','','','',0,0);

        $fundings = $formfield->field('Select','fundings','','','txt_put','',true,'','','','','',0,0);
        $fundings->addMultiOption('','Select...');
        $fundings->addMultiOption('1','funders');
        $fundings->addMultiOption('2','group');
        $fundings->setAttrib('onchange','displayRow(this.value)');

        $funders = $formfield->field('Radio','funders','','','txt_put','',true,'','','','','',0,0);
        $funders->setAttrib('size', '8');
        //hidden feilds
		$code = $formfield->field('Hidden','code','','','','',false,'','','','','',0,$codenum);
		$Id = $formfield->field('Hidden','Id','','','','',false,'','','','','',0,$ID);
		$submit = $formfield->field('Submit','Submit','','','','',false,'','','','','',0,0);
		$Yes = $formfield->field('Submit','Yes','','','','',false,'','','','','',0,0);
		$back = $formfield->field('Submit','Back','','','','',false,'','','','','',0,0);

        $this->addElements(array($submit,$amount,$installments,$interest,$interesttype,$savingAccount,$fundings,$funders,$code,$Id,$date,$back,$Yes));
		if (substr(base64_decode($codenum),4,1) == 2) {
        	$group = new Zend_Form_Element_MultiCheckbox('group');
			$this->addElements(array($group));
		} else {
			$group = 0; 
		}
    }
}
