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
class Management_Form_Loan extends ZendX_JQuery_Form {
    public function init() {
        Zend_Dojo::enableForm($this);
   }
    public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);


        $product_id = new Zend_Form_Element_Select('product_id');
        $product_id->addMultiOption('','Select...');
        $product_id->setAttrib('class', 'txt_put');
        $product_id->setRequired(true)
                     ->addValidators(array(array('NotEmpty')));

        $offerproductname = new Zend_Form_Element_Text('offerproductname');
        $offerproductname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductname'));
        $offerproductname->setAttrib('class', 'txt_put');
        $offerproductname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));

        $offerproductshortname = new Zend_Form_Element_Text('offerproductshortname');
        $offerproductshortname->setAttrib('class', 'txt_put');
        $offerproductshortname->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $offerproduct_description= new Zend_Form_Element_Textarea('offerproduct_description', array('rows' => 3,'cols' => 20,));
        $offerproduct_description->setAttrib('class', '');
        $offerproduct_description->setRequired(true)
                                 ->addValidators(array(array('NotEmpty',)));


       $begindate = new Zend_Form_Element_Text('begindate');
       $begindate->setAttrib('class', 'txt_put');
       $begindate->setRequired(true)
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true);

        $closedate = new Zend_Form_Element_Text('closedate');
        $closedate->setAttrib('class', 'txt_put');
        $closedate->setRequired(true)
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true);

        $applicableto = new Zend_Form_Element_Select('applicableto');
        $applicableto->addMultiOption('','Select...');
        $applicableto->setAttrib('class', 'txt_put');
        $applicableto->setRequired(true)
                     ->addValidators(array(array('NotEmpty')));

        $minmumloanamount  = new Zend_Form_Element_Text('minmumloanamount');
        $minmumloanamount->setAttrib('class', 'txt_put');

        $maximunloanamount  = new Zend_Form_Element_Text('maximunloanamount');
        $maximunloanamount->setAttrib('class', 'txt_put');


        $minimumfrequency  = new Zend_Form_Element_Text('minimumfrequency');
        $minimumfrequency->setAttrib('class', 'txt_put'); 	
        $minimumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));

        $maximumfrequency  = new Zend_Form_Element_Text('maximumfrequency');
        $maximumfrequency->setAttrib('class', 'txt_put');
        $maximumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',))); 

        $graceperiodnumber  = new Zend_Form_Element_Text('graceperiodnumber');
        $graceperiodnumber->setAttrib('class', 'txt_put');
        $graceperiodnumber->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));	

        $penal_Interest  = new Zend_Form_Element_Text('penal_Interest');
        $penal_Interest->setAttrib('class', 'txt_put');

        $period_ofrange_monthfrom  = new Zend_Form_Element_Text('period_ofrange_monthfrom');
        $period_ofrange_monthfrom->setAttrib('class', 'txt_put');
        $period_ofrange_monthfrom->setAttrib('size', '5');

        $period_ofrange_monthto  = new Zend_Form_Element_Text('period_ofrange_monthto');
        $period_ofrange_monthto->setAttrib('class', 'txt_put');
        $period_ofrange_monthto->setAttrib('size', '5');

        $Interest  = new Zend_Form_Element_Text('Interest');
        $Interest->setAttrib('class', 'txt_put');
        $Interest->setAttrib('size', '5');

        $submit = new Zend_Form_Element_Submit('Submit');

        $this->addElements(array($offerproductname,$offerproductshortname,
                                 $offerproduct_description,
                                 $begindate,$closedate,$penal_Interest,
                                 $applicableto,$minmumloanamount,
                                 $maximunloanamount,$minimumfrequency,
                                 $maximumfrequency,$graceperiodnumber,
                                 $fund_id,$product_id,$submit,$period_ofrange_monthfrom,$period_ofrange_monthto,$Interest));

    }
}