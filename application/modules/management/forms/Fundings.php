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
class Management_Form_Fundings extends ZendX_JQuery_Form {
    public function init() {

        $fundingupdates_id = new Zend_Form_Element_Hidden('fundingupdates_id'); 
        $funding_id = new Zend_Form_Element_Hidden('funding_id');

        $funder_id = new Zend_Form_Element_Select('funder_id');
        $funder_id->addMultiOption('','Select...');
        $funder_id->setAttrib('class', 'txt_put');
        $funder_id->setRequired(true)
		->addValidators(array(array('NotEmpty')));
		
//  $funder_id = new Zend_Form_Element_Text('funder_id');
//         $funder_id->addValidators(array(array('NotEmpty')));
//         $funder_id->setAttrib('class', 'txt_put');
//         $funder_id->setRequired(true)
// 		->addValidators(array(array('NotEmpty')));
// 









		$institutionName = new Zend_Form_Element_Select('institutionname');
		$institutionName->setAttrib('class', 'txt_put');
		$institutionName->setAttrib('id', 'institutionname');
		$institutionName->setLabel('institutionname') ->setRequired(true);
		$institutionName->addMultiOption('','Select...');
		
      
        $fundingname = new Zend_Form_Element_Text('fundingname');
        $fundingname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_fundingdetails', 'fundingname'));
        $fundingname->setAttrib('class', 'txt_put');
        $fundingname->setRequired(true)
		->addValidators(array('NotEmpty','alpha'));
		
		$interest = new Zend_Form_Element_Text('interest');
        $interest->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_fundingdetails', 'fundingname'));
        $interest->setAttrib('class', 'txt_put');
        $interest->setRequired(true)
		->addValidators(array(array('NotEmpty')));

        $funding_currency_id = new Zend_Form_Element_Select('funding_currency_id');
        $funding_currency_id->addMultiOption('','Select...');
        $funding_currency_id->setAttrib('class', 'txt_put');
        $funding_currency_id->setRequired(true)
                            ->addValidators(array(array('NotEmpty')));

        $fundingamount = new Zend_Form_Element_Text('fundingamount');
        $fundingamount->setAttrib('class', 'txt_put');
        $fundingamount->setRequired(true)
                       ->addValidators(array('Float',));

        $exchangerate = new Zend_Form_Element_Text('exchangerate');
        $exchangerate->setAttrib('class', 'txt_put');
        $exchangerate->setRequired(true)
                       ->addValidators(array(array('Float',)));

        $fund_beginingdate = new ZendX_JQuery_Form_Element_DatePicker('fund_beginingdate');
        $fund_beginingdate->setAttrib('class', 'txt_put');
        $fund_beginingdate->setJQueryParam('dateFormat', 'yy-mm-dd');
        $fund_beginingdate->setRequired(true)
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true);

        $fund_closingdate  = new ZendX_JQuery_Form_Element_DatePicker('fund_closingdate');
        $fund_closingdate->setAttrib('class', 'txt_put');
        $fund_closingdate->setJQueryParam('dateFormat', 'yy-mm-dd');
        $fund_closingdate->setRequired(true)
                    ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true);

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->removeDecorator('DtDdWrapper');

        $this->addElements(array($fundingupdates_id,$fundingupdates_id,$funder_id,
                                 $funding_id,
                                 $fundingname,$funding_currency_id,
                                 $fundingamount,$exchangerate,
                                 $fund_beginingdate,$fund_closingdate,$institutionName,$interest,
                                 $submit));

    }


}