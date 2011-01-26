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
class Management_Form_Savings extends ZendX_JQuery_Form {
    public function init() {
        Zend_Dojo::enableForm($this);
        $this->addElement('hidden', 'id', array('value' => 1));

        $this->addElement('text', 'period_ofrange_monthfrom', 
                    array('required' => true,'label' => 'Name','order'    => 2,'size' => 4 , 'class' => 'txt_put'));

        $this->addElement('text', 'period_ofrange_monthto', 
                    array('required' => true,'label' => 'Name','order'    => 2,'size' => 4 , 'class' => 'txt_put'));

        $this->addElement('text', 'Interest', 
                    array('required' => true,'label' => 'Name','order'    => 2,'size' => 4 , 'class' => 'txt_put')); 

        $this->addElement('button', 'addElement', array('label' => 'Add','order' => 91));

        $this->addElement('button', 'removeElement', array('label' => 'Remove','order' => 92));
        // Submit
        $this->addElement('submit', 'submit', array('label' => 'Submit','order' => 93));




    }


    public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);
       $this->setName('article_form')
                        ->setAction(URL.'/admin/article/save')
                        ->setMethod('post')
                        ->addPrefixPath('MF_Form_Element', 'MF/Form/Element/', 'element')
                        ->setAttrib('enctype', 'multipart/form-data')
                        ->setAttrib('id', 'article-form'); 

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
        $offerproductshortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductshortname'));
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
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true)
                   ->addValidator(new Zend_Validate_GreaterThan($begindate));

        $applicableto = new Zend_Form_Element_Select('applicableto');
        $applicableto->addMultiOption('','Select...');
        $applicableto->setAttrib('class', 'txt_put');
        $applicableto->setRequired(true)
                     ->addValidators(array(array('NotEmpty')));

        $capital_glsubcode_id = new Zend_Form_Element_Select('capital_glsubcode_id');
        $capital_glsubcode_id->addMultiOption('','Select...');
        $capital_glsubcode_id->setAttrib('class', 'txt_put');
        $capital_glsubcode_id->setRequired(true)
                             ->addValidators(array(array('NotEmpty')));

        $Interest_glsubcode_id  = new Zend_Form_Element_Select('Interest_glsubcode_id');
        $Interest_glsubcode_id->addMultiOption('','Select...');
        $Interest_glsubcode_id->setAttrib('class', 'txt_put');
        $Interest_glsubcode_id->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $minmumloanamount  = new Zend_Form_Element_Text('minmumloanamount');
        $minmumloanamount->setAttrib('class', 'txt_put');
        $minmumloanamount->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));

        $maximunloanamount  = new Zend_Form_Element_Text('maximunloanamount');
        $maximunloanamount->setAttrib('class', 'txt_put');
        $maximunloanamount->setRequired(true);
        $validator=new Zend_Validate_Digits();
        $maximunloanamount->addValidator($validator,true);


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

        $fee_glsubcode_id  = new Zend_Form_Element_Select('fee_glsubcode_id');
        $fee_glsubcode_id->addMultiOption('','Select...');
        $fee_glsubcode_id->setAttrib('class', 'txt_put');
        $fee_glsubcode_id->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $fee_id = new Zend_Form_Element_MultiCheckbox('fee_id');

        $fund_id = new Zend_Form_Element_MultiCheckbox('fund_id');

        $submit = new Zend_Form_Element_Submit('Submit');






	$submit = new Zend_Form_Element_Submit('Submit');


        $this->addElements(array($offerproductname,$offerproductshortname,
                                 $offerproduct_description,
                                 $begindate,$closedate,
                                 $applicableto,$capital_glsubcode_id,
                                 $Interest_glsubcode_id,$minmumloanamount,
                                 $maximunloanamount,$minimumfrequency,
                                 $maximumfrequency,$graceperiodnumber,
                                 $fee_glsubcode_id,$fee_id,
                                 $fund_id,$product_id,$submit));

    }
}