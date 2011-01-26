<?php
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

/**  
 * class is used to create a form for SavingInstance details along with the validation
*/
class Savings_Form_Savings extends Zend_Form
{
public function __construct() 
    {
    parent::__construct();
    // 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        // create instance to call common field
        $formfield = new App_Form_Field ();
        // send parameters to get form fields (first parameter is a form field type)
        $offerproduct_id = $formfield->field('Hidden','offerproduct_id','','','','offerproduct_id',false,'','','','','','','');
        $productshortname = $formfield->field('Text','productshortname','','','','productshortname',false,'','','','','','','');
        $currentdates = $formfield->field('Hidden','currentdates','','','','currentdates',false,'','','','','','','');
        $productType = $formfield->field('Select','productType','','','','productType',false,'','','','','','','');
        $productType->setRegisterInArrayValidator(false);
        $productType->setAttrib('onchange', 'getSavingAccount(this.value)');	
        
        $savingproducttype = $formfield->field('Text','savingproductname','','','','savingproductname',false,'','','','','','','');
                        $savingproducttype->setAttrib('readonly', 'true');
        
        $offerproductname = $formfield->field('Text','offerproductname','','','mand','offerproductname',true,'','','','','','','');
                        $offerproductname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsoffer', 'name'));
        
        $offerproductshortname = $formfield->field('Text','offerproductshortname','','','mand','offerproductshortname',true,'','','','','','','');
        $offerproductshortname->addValidators(array(array('NotEmpty'),array('stringLength', false, array(1, 3))));
        
        $offerproduct_description = $formfield->field('Textarea','offerproduct_description','','','mand','offerproduct_description',true,'','','',2,23,'','');
        
        $begindate = $formfield->field('Text','begindate','','','','begindate',false,'','','','','',0,'');
                    

        
        $closedate = $formfield->field('Text','closedate','','','mand','closedate',true,'','','','','','','');
        $closedate->addValidator(new Zend_Validate_Date('DD-MM-YYYY'),true,
                                                array('messages' =>array(Zend_Validate_Date::FALSEFORMAT => 'Enter the valid date')));	   					
        $feeglcode = $formfield->field('Select','feeglcode','','','mand','feeglcode',true,'','','','','','','');

        $applicableto = $formfield->field('Select','applicableto','','','mand','applicableto',true,'','','','','','','');
        $glsubcode = $formfield->field('Select','glsubcode_id','','','mand','glsubcode_id',true,'','','','','','','');
        $minmumdeposit = $formfield->field('Text','minmumdeposit','','','mand','minmumdeposit',true,'','','','','','','');
        
        $graterthan=new Zend_Validate_GreaterThan(0);
        $minmumdeposit->setRequired(true)
                ->addValidators(array(array('stringLength', false, array(1,8))))
                            ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $frequencyofdeposit = $formfield->field('Select','frequencyofdeposit','','','mand','frequencyofdeposit',true,'','','','','','','');
        $Int_timefrequency_id = $formfield->field('Select','Int_timefrequency_id','','','mand','Int_timefrequency_id',true,'','','','','','','');
        
        $frequencyofinterestupdating = $formfield->field('Select','frequencyofinterestupdating','','','mand','frequencyofinterestupdating',true,'','','','','','','');
    
        $frequencyofinterestupdating->addMultiOption('MinBalance','MinBalance');
        $frequencyofinterestupdating->addMultiOption('AvgBalance','AvgBalance');
        $minimumbalanceforinterest = $formfield->field('Text','minimumbalanceforinterest','','','mand','minimumbalanceforinterest',true,'','','','','','','');

        $graterthan=new Zend_Validate_GreaterThan(0);
        $minimumbalanceforinterest->setRequired(true)
                                    ->addValidators(array(array('stringLength', false, array(2,8))))
                                    ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $minimum_deposit_amount = $formfield->field('Text','minimum_deposit_amount','','','mand','minimum_deposit_amount',true,'','','','','','','');
        $graterthan=new Zend_Validate_GreaterThan(0);
        $minimum_deposit_amount->setRequired(true)
                                ->addValidators(array(array('stringLength', false, array(1,10))))
                                ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $maximum_deposit_amount = $formfield->field('Text','maximum_deposit_amount','','','mand','maximum_deposit_amount',true,'','','','','','','');
        $graterthan=new Zend_Validate_GreaterThan(0);
        $maximum_deposit_amount->setRequired(true)
        ->addValidators(array(array('stringLength', false, array(1,10))))
        ->addValidators(array(array('NotEmpty'),array('Float'),array($graterthan,true)));
        $frequency_of_deposit = $formfield->field('Select','frequency_of_deposit','','','','frequency_of_deposit',true,'','','','','','','');
        $penal_Interest = $formfield->field('Text','penal_Interest','','','mand','penal_Interest',true,'','','','','','','');
	$graterthan=new Zend_Validate_GreaterThan(0);
        $penal_Interest->setRequired(true)
                       ->addValidators(array(array('stringLength', false, array(1,4))))
                       ->addValidators(array(array('NotEmpty'),array('Digits'),array($graterthan,true)));
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'savings');
        $submit->setAttrib('id', 'savings');
        $this->addElements(array($productType,$offerproductname,$offerproductshortname,$offerproduct_description,$begindate,$closedate,$feeglcode,$applicableto,$minmumdeposit,$frequencyofdeposit,$Int_timefrequency_id,$frequencyofinterestupdating,$minimumbalanceforinterest,$minimum_deposit_amount,$maximum_deposit_amount,$frequency_of_deposit,$penal_Interest,$savingproducttype,$submit,$offerproduct_id,$productshortname,$currentdates,$glsubcode));
        }	
}
/** end of class */
