<?php
class Management_Form_Insurance extends ZendX_JQuery_Form {
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



        $offerproductname = new Zend_Dojo_Form_Element_TextBox('offerproductname');
        $offerproductname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductname'));
        $offerproductname->setAttrib('class', 'txt_put');
        $offerproductname->setRequired(true)
                         ->addValidators(array(array('NotEmpty')));

        $offerproductshortname = new Zend_Dojo_Form_Element_TextBox('offerproductshortname');
        $offerproductshortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productsofferdetails', 'offerproductshortname'));
        $offerproductshortname->setAttrib('class', 'txt_put');
        $offerproductshortname->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $offerproduct_description= new Zend_Dojo_Form_Element_SimpleTextarea('offerproduct_description', array('rows' => 3,'cols' => 20,));
        $offerproduct_description->setAttrib('class', '');
        $offerproduct_description->setRequired(true)
                                 ->addValidators(array(array('NotEmpty',)));

        $begindate = new Zend_Dojo_Form_Element_DateTextBox('begindate');
        $begindate->setLabel('Birthday');



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





        $maximunloanamount  = new Zend_Dojo_Form_Element_TextBox('maximunloanamount');
        $maximunloanamount->setAttrib('class', 'txt_put');
        $maximunloanamount->setRequired(true);
        $validator=new Zend_Validate_Digits();
        $maximunloanamount->addValidator($validator,true);


        $minimumfrequency  = new Zend_Dojo_Form_Element_TextBox('minimumfrequency');
        $minimumfrequency->setAttrib('class', 'txt_put');
        $minimumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));

        $maximumfrequency  = new Zend_Dojo_Form_Element_TextBox('maximumfrequency');
        $maximumfrequency->setAttrib('class', 'txt_put');
        $maximumfrequency->setRequired(true)
                              ->addValidators(array(array('NotEmpty',))); 

        $graceperiodnumber  = new Zend_Dojo_Form_Element_TextBox('graceperiodnumber');
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