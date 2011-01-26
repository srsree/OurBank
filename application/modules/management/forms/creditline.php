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
	class Management_Form_creditline extends Zend_Form {

	public function init()
	{
		Zend_Dojo::enableForm($this);
	}

	public function __construct($options = null)
	{
		Zend_Dojo::enableForm($this);
		parent::__construct($options);
		$creditline_id = new Zend_Form_Element_Text('creditline_id');
		$institution_id = new Zend_Form_Element_Text('institution_id');

		$institutionName = new Zend_Form_Element_Select('institutionname');
		$institutionName->setAttrib('class', 'txt_put');
		$institutionName->setAttrib('id', 'institutionname');
		$institutionName->setLabel('institutionname') ->setRequired(true);
		$institutionName->addMultiOption('','Select...');
		$institutionName->setAttrib('onchange','getState(this.value)');

		$institutionNames = new Zend_Form_Element_Text('institutionnames');
		$institutionNames->setAttrib('class', 'txt_put');
		$institutionNames->setAttrib('readonly', 'true');

		$instituteamount = new Zend_Form_Element_Text('instituteamount');
		$instituteamount->setAttrib('class', 'txt_put');
		$instituteamount->setAttrib('readonly', 'true');
	

		$institutionamount = new Zend_Form_Element_Text('institutionamount');
		$institutionamount->setAttrib('class', 'txt_put');
		$institutionamount->setAttrib('readonly', 'true');


		$maxcreditlinelimit = new Zend_Form_Element_Text('maxcreditlinelimit');
		$maxcreditlinelimit->setAttrib('class', 'txt_put');
		$maxcreditlinelimit->setAttrib('readonly', 'true');



		$creditlinename = new Zend_Form_Element_Text('creditlinename');
		$creditlinename->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_creditlineinformation','creditlinename'));
		$creditlinename->setAttrib('class', 'txt_put');
		$creditlinename->setAttrib('id', 'creditlinename');
		$creditlinename->setLabel('creditlinename')
					->setRequired(true)
					->addValidators(array(array('NotEmpty')));

		$creditlineshortname = new Zend_Form_Element_Text('creditline_shortname');
		$creditlineshortname->setAttrib('class', 'txt_put');
		$creditlineshortname->setAttrib('id', 'creditline_shortname');
		$creditlineshortname->setLabel('creditline_shortname')
						->setRequired(true)
						->addValidators(array('NotEmpty'));

		$creditlineamount = new Zend_Form_Element_Text('creditlineamount');
		$creditlineamount->setAttrib('class', 'txt_put');
		$creditlineamount->setAttrib('id', 'creditlineamount');
        $creditlineamount->setRequired(true)
				       ->addValidators(array(array('NotEmpty'),array('Float')));

		$creditlineinterest = new Zend_Form_Element_Text('creditlineinterest');
		$creditlineinterest->setAttrib('class', 'txt_put');
		$creditlineinterest->setAttrib('id', 'creditlineinterest');
        $creditlineinterest->setRequired(true)
				       ->addValidators(array(array('NotEmpty'),array('stringLength', false, array(1, 3)),array('Digits')));


		$creditlinefrom = new ZendX_JQuery_Form_Element_DatePicker('creditline_beginingdate');
		$creditlinefrom->setJQueryParam('dateFormat', 'yy-mm-dd');
		$creditlinefrom->setRequired(true)
						->addValidators(array(array('Date')));
		$creditlinefrom->setAttrib('class', 'txt_put');
		$creditlinefrom->setAttrib('id', 'creditline_beginingdate');

		$creditlineto = new ZendX_JQuery_Form_Element_DatePicker('creditline_closingdate');
		$creditlineto->setJQueryParam('dateFormat', 'yy-mm-dd');
		$creditlineto->setRequired(true)
						->addValidators(array(array('Date')));
		$creditlineto->setAttrib('class', 'txt_put');
		$creditlineto->setAttrib('id', 'creditline_closingdate');




		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('class', 'officesubmit');
		$submit->setlabel('Submit');

		$this->addElements( array ($creditline_id,$institutionName,$creditlinename,$creditlineshortname,$creditlineamount,$creditlineinterest,$creditlinefrom,$creditlineto,$submit,$institutionamount,$instituteamount,$institutionNames,$institution_id,$maxcreditlinelimit));
	}
}