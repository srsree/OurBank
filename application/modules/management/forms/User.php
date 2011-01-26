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
class Management_Form_User extends ZendX_JQuery_Form {
    public function init() {
    }


    public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);


        $product_id = new Zend_Dojo_Form_Element_ComboBox('product_id');
        $product_id->addMultiOption('','Select...');
        $product_id->setAttrib('class', 'txt_put');
        $product_id->setRequired(true)
                   ->addValidators(array(array('NotEmpty')));



        $offerproductname = new Zend_Dojo_Form_Element_ValidationTextBox('offerproductname');
        $offerproductname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductname'));
        $offerproductname->setAttrib('class', 'txt_put');
        $offerproductname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));

        $offerproductshortname = new Zend_Dojo_Form_Element_ValidationTextBox('offerproductshortname');
        $offerproductshortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductshortname'));
        $offerproductshortname->setAttrib('class', 'txt_put');
        $offerproductshortname->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $offerproduct_description= new Zend_Dojo_Form_Element_SimpleTextarea('offerproduct_description', array('rows' => 3,'cols' => 20,));
        $offerproduct_description->setAttrib('class', '');
        $offerproduct_description->setRequired(true)
                                 ->addValidators(array(array('NotEmpty',)));

//         $begindate = new Zend_Dojo_Form_Element_DateTextBox('begindate');
//         $begindate->setLabel('Birthday');

        $begindate = new ZendX_JQuery_Form_Element_DatePicker('begindate',array('label' => 'Date:'));
        $begindate->setJQueryParam('dateFormat', 'yy-mm-dd');
        $begindate->setAttrib('class', 'txt_put');
        $begindate->setRequired(true)
                 ->addValidators(array(array('Date', true,
                                array('messages' => array('dateNotYYYY-MM-DD' => 'Please enter in this format(YYYY-MM-DD)'
                                ,'dateInvalid' => "'%value%' is not a valid date Please enter in this format(YYYY-MM-DD)"))),
                array('Between',false,array($beginDate,$matureDate,
                'messages' => array('notBetween' => 'date should be between '.$beginDate.' to (Closed date) '.$matureDate)))));




        $minmumloanamount  = new Zend_Dojo_Form_Element_NumberSpinner('minmumloanamount',array(
   
              'value'             => '7',
   
              'label'             => 'NumberSpinner',
  
              'smallDelta'        => 5,
   
              'largeDelta'        => 25,
   
              'defaultTimeout'    => 500,
  
              'timeoutChangeRate' => 100,
  
              'min'               => 9,
  
              'max'               => 1550,
  
              'places'            => 0,
  
              'maxlength'         => 20,
  
          ));
        $minmumloanamount->setAttrib('class', 'txt_put');
        $minmumloanamount->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));




        $closedate = new Zend_Dojo_Form_Element_TextBox('closedate');
        $closedate->setAttrib('class', 'txt_put');
        $closedate->setRequired(true)
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true)
                   ->addValidator(new Zend_Validate_GreaterThan($begindate));

        $applicableto = new Zend_Dojo_Form_Element_ComboBox('applicableto');
        $applicableto->addMultiOption('','Select...');
        $applicableto->setAttrib('class', 'txt_put');
        $applicableto->setRequired(true)
                     ->addValidators(array(array('NotEmpty')));





        $maximunloanamount  = new Zend_Dojo_Form_Element_NumberTextBox('maximunloanamount');
        $maximunloanamount->setAttrib('class', 'txt_put');
        $maximunloanamount->setRequired(true);
        $validator=new Zend_Validate_Digits();
        $maximunloanamount->addValidator($validator,true);


        $minimumfrequency  = new Zend_Dojo_Form_Element_NumberTextBox('minimumfrequency');
        $minimumfrequency->setAttrib('class', 'txt_put');
        $minimumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));

        $maximumfrequency  = new Zend_Dojo_Form_Element_NumberTextBox('maximumfrequency');
        $maximumfrequency->setAttrib('class', 'txt_put');
        $maximumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',))); 

        $graceperiodnumber  = new Zend_Dojo_Form_Element_NumberTextBox('graceperiodnumber');
        $graceperiodnumber->setAttrib('class', 'txt_put');
        $graceperiodnumber->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));	



        $submit = new Zend_Dojo_Form_Element_SubmitButton('Submit');







        $this->addElements(array($offerproductname,$offerproductshortname,
                                 $offerproduct_description,
                                 $begindate,$closedate,
                                 $applicableto,$minmumloanamount,
                                 $maximunloanamount,$minimumfrequency,
                                 $maximumfrequency,$graceperiodnumber,
                               
                                 $product_id,$submit));

    }
}