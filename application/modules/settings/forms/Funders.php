<?php
class Management_Form_Funders extends ZendX_JQuery_Form {
    public function init() {

        $fundername = new Zend_Form_Element_Text('fundername');
        $fundername->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_funderdetails', 'fundername'));
        $fundername->setAttrib('class', 'txt_put');
        $fundername->setRequired(true)
                        ->addValidators(array(array('NotEmpty')));

        $fundershortname = new Zend_Form_Element_Text('fundershortname');
        $fundershortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_funderdetails', 'fundershortname'));
        $fundershortname->setAttrib('class', 'txt_put');
        $fundershortname->setRequired(true)
                              ->addValidators(array(array('NotEmpty')));

        $funderaddress1 = new Zend_Form_Element_Text('funderaddress1');
        $funderaddress1->setAttrib('class', 'txt_put');
        $funderaddress1->setRequired(true)
                       ->addValidators(array(array('NotEmpty',)));

        $funderaddress2 = new Zend_Form_Element_Text('funderaddress2');
        $funderaddress2->setAttrib('class', 'txt_put');

        $funderaddress3 = new Zend_Form_Element_Text('funderaddress3');
        $funderaddress3->setAttrib('class', 'txt_put');

        $fundercity  = new Zend_Form_Element_Text('fundercity');
        $fundercity->setAttrib('class', 'txt_put');
        $fundercity->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $funderstate  = new Zend_Form_Element_Text('funderstate');
        $funderstate->setAttrib('class', 'txt_put');
        $funderstate->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $fundercountry  = new Zend_Form_Element_Text('fundercountry');
        $fundercountry->setAttrib('class', 'txt_put');
        $fundercountry->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $funderpincode  = new Zend_Form_Element_Text('funderpincode');
        $funderpincode->setAttrib('class', 'txt_put');
        $funderpincode->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $funderphone  = new Zend_Form_Element_Text('funderphone');
        $funderphone->setAttrib('class', 'txt_put');
        $funderphone->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $emailaddress = new Zend_Form_Element_Text('emailaddress');
        $emailaddress->setAttrib('class', 'txt_put');
        $emailaddress->setRequired(true)
                   ->addValidators(array(array('NotEmpty',)));

        $funderaddress_id = new Zend_Form_Element_Hidden('funderaddress_id');

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->removeDecorator('DtDdWrapper');

        $this->addElements(array($fundername,$fundershortname,
                                 $funderaddress1,$funderaddress2,
                                 $funderaddress3,$fundercity,
                                 $funderstate,$fundercountry,
                                 $funderpincode,$funderphone,
                                 $emailaddress,$funderaddress_id,$submit));

    }


}