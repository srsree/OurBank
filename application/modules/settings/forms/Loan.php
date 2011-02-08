<?php
class Management_Form_Loan extends ZendX_JQuery_Form {
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


       $begindate = new Zend_Dojo_Form_Element_DateTextBox('begindate');
       $begindate->setAttrib('class', 'txt_put');
       $begindate->setRequired(true)
                   ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'),true);

        $closedate = new Zend_Dojo_Form_Element_DateTextBox('closedate');
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
        $minmumloanamount->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));

        $maximunloanamount  = new Zend_Form_Element_Text('maximunloanamount');
        $maximunloanamount->setAttrib('class', 'txt_put');
        $maximunloanamount->setRequired(true);


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
        $penal_Interest->setRequired(true)
                              ->addValidators(array(array('NotEmpty',)));


        $submit = new Zend_Form_Element_Submit('Submit');

        $this->addElements(array($offerproductname,$offerproductshortname,
                                 $offerproduct_description,
                                 $begindate,$closedate,$penal_Interest,
                                 $applicableto,$minmumloanamount,
                                 $maximunloanamount,$minimumfrequency,
                                 $maximumfrequency,$graceperiodnumber,
                                 $fund_id,$product_id,$submit));

    }
}