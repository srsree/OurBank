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
	class Management_Form_bank extends Zend_Form {

	public function init() {

		$bank_id = new Zend_Form_Element_Hidden('bank_id');
		$bank_id->setAttrib('class', 'txt_put');

		$bankname = new Zend_Form_Element_Text('bankname');
		$bankname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_bankaddress','bankname'));
		$bankname->setAttrib('class', 'txt_put')
					->setLabel('Bank Name');
		$bankname->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));



		$bankshortname= new Zend_Form_Element_Text('bankshortname');
		$bankshortname->setAttrib('class', 'txt_put')
						->setLabel('Short Name');
		$bankshortname->setRequired(true)
						->addValidators(array(array('NotEmpty'),array('stringLength', false, array(1, 3))))
						->setDecorators(array('ViewHelper',
							array('Description',array('tag'=>'','escape'=>false)),'Errors',
							array(array('data'=>'HtmlTag'), array('tag' => 'td')),
							array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
							array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$address1 = new Zend_Form_Element_Text('address1');
		$address1->setAttrib('class', 'txt_put')
					->setLabel('Address1');
		$address1->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$address2 = new Zend_Form_Element_Text('address2');
		$address2->setAttrib('class', 'txt_put')
					->setLabel('Address2');
		$address2->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$address3 = new Zend_Form_Element_Text('address3');
		$address3->setAttrib('class', 'txt_put')
					->setLabel('Address3');
		$address3->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$city = new Zend_Form_Element_Text('city');
		$city->setAttrib('class', 'txt_put')
					->setLabel('city');
		$city->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$state = new Zend_Form_Element_Text('state');
		$state->setAttrib('class', 'txt_put')
					->setLabel('state');
		$state->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$country = new Zend_Form_Element_Text('country');
		$country->setAttrib('class', 'txt_put')
					->setLabel('country');
		$country->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));


		$pincode = new Zend_Form_Element_Text('pincode');
		$pincode->setAttrib('class', 'txt_put')
					->setLabel('pincode');
		$pincode->setRequired(true)
					->addValidators(array(array('Digits')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$phone = new Zend_Form_Element_Text('phone');
		$phone->setAttrib('class', 'txt_put')
					->setLabel('phone');
		$phone->setRequired(true)
					->addValidators(array(array('Digits')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$fax = new Zend_Form_Element_Text('fax');
		$fax->setAttrib('class', 'txt_put')
					->setLabel('fax');
		$fax->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$email_Id = new Zend_Form_Element_Text('email_Id');
		$email_Id->setAttrib('class', 'txt_put')
					->setLabel('Email_Id');
		$email_Id->setRequired(true)
					->addValidators(array(array('EmailAddress')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$bankdescription= new Zend_Form_Element_Textarea('bankdescription', array('rows' => 3,'cols' => 20,));
		$bankdescription->setAttrib('class', '')
							->setLabel('Description');
		$bankdescription->setRequired(true)
							->addValidators(array(array('NotEmpty')))
							->setDecorators(array('ViewHelper',
								array('Description',array('tag'=>'','escape'=>false)),'Errors',
								array(array('data'=>'HtmlTag'), array('tag' => 'td')),
								array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
								array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$contactperson = new Zend_Form_Element_Text('contactperson');
		$contactperson->setAttrib('class', 'txt_put')
					->setLabel('contact person');
		$contactperson->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$contactperson_phone1 = new Zend_Form_Element_Text('contactperson_phone1');
		$contactperson_phone1->setAttrib('class', 'txt_put')
					->setLabel('Contactperson phone1');
		$contactperson_phone1->setRequired(true)
					->addValidators(array(array('Digits')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$contactperson_phone2 = new Zend_Form_Element_Text('contactperson_phone2');
		$contactperson_phone2->setAttrib('class', 'txt_put')
					->setLabel('Contactperson_phone2');
		$contactperson_phone2->setRequired(true)
					->addValidators(array(array('Digits')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$contactperson_email = new Zend_Form_Element_Text('contactperson_email');
		$contactperson_email->setAttrib('class', 'txt_put')
					->setLabel('Contactperson_email');
		$contactperson_email->setRequired(true)
					->addValidators(array(array('EmailAddress')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));


		$this->addElements(array($institution_id,$bankname,$bankshortname,$address1,$address2,$address3,$city,$state,$country,$pincode,$phone,$fax,$email_Id,$bankdescription,$contactperson,$contactperson_phone1,$contactperson_phone2,$contactperson_email));

		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('id', 'Submit')
				->setDecorators(array('ViewHelper',
					array('Description',array('tag'=>'','escape'=>false)),'Errors',
					array(array('data'=>'HtmlTag'), array('colspan' => '8 ')),
					array(array('data'=>'HtmlTag'), array('tag' => 'td ', 'colspan'=>'8')),
					array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$this->addElements(array($submit));
	}
}