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
class Management_Form_Funders extends ZendX_JQuery_Form {
    public function init() {

        $fundername = new Zend_Form_Element_Text('fundername');
        $fundername->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_funderdetails', 'fundername',
                                                                      'recordstatus_id = 3'));
        $fundername->setAttrib('class', 'txt_put');
        $fundername->setRequired(true)
                        ->addValidators(array(array('NotEmpty')));

        $fundershortname = new Zend_Form_Element_Text('fundershortname');
        $fundershortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_funderdetails', 'fundershortname','recordstatus_id = 3'));
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
                   ->addValidators(array('NotEmpty','Alpha'));

        $funderstate  = new Zend_Form_Element_Text('funderstate');
        $funderstate->setAttrib('class', 'txt_put');
        $funderstate->setRequired(true)
                   ->addValidators(array('NotEmpty','Alpha'));

        $fundercountry  = new Zend_Form_Element_Text('fundercountry');
        $fundercountry->setAttrib('class', 'txt_put');
        $fundercountry->setRequired(true)
                   ->addValidators(array('NotEmpty','Alpha'));

        $funderpincode  = new Zend_Form_Element_Text('funderpincode');
        $funderpincode->setAttrib('class', 'txt_put');
        $funderpincode->setRequired(true)
                   ->addValidators(array('Digits'));

        $funderphone  = new Zend_Form_Element_Text('funderphone');
        $funderphone->setAttrib('class', 'txt_put');
        $funderphone->setRequired(true)
                   ->addValidators(array('Digits'));



// #
// 'digits',
// #
//         'messages' => 'A month must consist only of digits'

        $emailaddress = new Zend_Form_Element_Text('emailaddress');
        $emailaddress->setAttrib('class', 'txt_put');
        $emailaddress->setRequired(true)
                   ->addValidators(array('EmailAddress'));

        $funderaddress_id = new Zend_Form_Element_Hidden('funderaddress_id');
        $funder_id= new Zend_Form_Element_Hidden('funder_id');

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->removeDecorator('DtDdWrapper');

        $this->addElements(array($fundername,$fundershortname,
                                 $funderaddress1,$funderaddress2,
                                 $funderaddress3,$fundercity,
                                 $funderstate,$fundercountry,
                                 $funderpincode,$funderphone,
                                 $emailaddress,$funderaddress_id,$funder_id,$submit));

    }


}