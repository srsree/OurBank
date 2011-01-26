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
class Management_Form_Office extends Zend_Form{

 public function init() {
        Zend_Dojo::enableForm($this);
    }
        public function __construct($path) {
     //   Zend_Dojo::enableForm($this);
      //  parent::__construct($options);

        $officeupdates_id = new Zend_Form_Element_Hidden('officeupdates_id');

        $office_id = new Zend_Form_Element_Hidden('office_id');
        $office_id->setAttrib('class', 'txt_put');

        $office_name = new Zend_Form_Element_Text('office_name');
        $office_name->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $office_name->setAttrib('class', 'txt_put');
        $office_name->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_officenames', 'office_name'));

        $officeshort_name = new Zend_Form_Element_Text('officeshort_name');
        $officeshort_name->setAttrib('class', 'txt_put');
	$officeshort_name->setRequired(true)
		 	->addValidators(array(array('NotEmpty'),array('stringLength', false, array(3,3))));


        $officeaddress1=new Zend_Form_Element_Text('officeaddress1');
        $officeaddress1->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $officeaddress1->setAttrib('class', 'txt_put');

        $officeaddress2=new Zend_Form_Element_Text('officeaddress2');
        $officeaddress2->setAttrib('class', 'txt_put');

        $officeaddress3=new Zend_Form_Element_Text('officeaddress3');
        $officeaddress3->setAttrib('class', 'txt_put');

        $officecity=new Zend_Form_Element_Text('officecity');
        $officecity->setRequired(true)
                    ->addValidators(array(array('NotEmpty'),array('alpha')));
        $officecity->setAttrib('class', 'txt_put');

        $officestate=new Zend_Form_Element_Text('officestate');
        $officestate->setRequired(true)
                    ->addValidators(array(array('NotEmpty'),array('alpha')));
        $officestate->setAttrib('class', 'txt_put');

        $officecountry=new Zend_Form_Element_Text('officecountry');
        $officecountry->setRequired(true)
                    ->addValidators(array(array('NotEmpty'),array('alpha')));
        $officecountry->setAttrib('class', 'txt_put');

        $officepincode=new Zend_Form_Element_Text('officepincode');
		$officepincode->setRequired(true)
					->addValidators(array(array('Digits'),array('stringLength', false, array(6,6))));
        $officepincode->setAttrib('class', 'txt_put');


        $officephone=new Zend_Form_Element_Text('officephone');
		$officephone->setRequired(true)
					->addValidators(array(array('Digits'),array('stringLength', false, array(10,11))));
        $officephone->setAttrib('class', 'txt_put');

        $office_fax=new Zend_Form_Element_Text('office_fax');
        $office_fax->setAttrib('class', 'txt_put');


        $office_email_Id=new Zend_Form_Element_Text('office_email_Id');
        $office_email_Id->setAttrib('class', 'txt_put');


        $contactperson=new Zend_Form_Element_Text('contactperson');
        $contactperson->setAttrib('class', 'txt_put');



        $contactperson_phone1=new Zend_Form_Element_Text('contactperson_phone1');
        $contactperson_phone1->setAttrib('class', 'txt_put');

        $contactperson_phone2=new Zend_Form_Element_Text('contactperson_phone2');
        $contactperson_phone2->setAttrib('class', 'txt_put');


        $contactperson_email=new Zend_Form_Element_Text('contactperson_email');
        $contactperson_email->setAttrib('class', 'txt_put');

        $officedescription=new Zend_Form_Element_Text('officedescription');
        $officedescription->setAttrib('class', 'txt_put');


       

        $officetype_id = new Zend_Form_Element_Select('officetype_id');
        $officetype_id->setRequired(true);
        $officetype_id->addMultiOption('','select'.'...');
        $officetype_id->setAttrib('class','selectbutton');
        $officetype_id->setAttrib('onchange', 'getInterests(this.value,"'.$path.'")');




        $parentoffice_id = new Zend_Form_Element_Select('parentoffice_id');
	$parentoffice_id->addMultiOption('','firstSelectOfficeType'.'...');
	$parentoffice_id->setAttrib('class','selectbutton');
        


         $submit = new Zend_Form_Element_Submit('Submit');
         $submit->setAttrib('class', 'officesubmit');
	 $submit->setLabel('Submit');


         $this->addElements(array($officeupdates_id,$office_name,
                                 $officeshort_name,$officeaddress1,
                                 $officeaddress2,$officeaddress3,
                                 $officecity,$officestate,
                                 $officecountry,$officepincode,
                                 $officephone,$office_fax,$office_email_Id,
                                 $contactperson,$contactperson_phone1,
                                 $contactperson_phone2,$contactperson_email,
                                 $submit,$office_id,$officetype_id,$officedescription,$parentoffice_id));
	}
}


/**class end*/
