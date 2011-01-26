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
	class Creditline_Form_Creditline extends Zend_Form {

	public function init()
	{
		Zend_Dojo::enableForm($this);
	}

	public function __construct($options = null)
	{
		Zend_Dojo::enableForm($this);
		parent::__construct($options);

		$creditlinename = new Zend_Form_Element_Text('creditlinename');
		$creditlinename->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_creditline1','name'));
		$creditlinename->setAttrib('class', 'txt_put');
		$creditlinename->setAttrib('id', 'creditlinename');
		$creditlinename->setLabel('creditlinename')
				->setRequired(true)
				->addValidators(array(array('NotEmpty')));


		$protfoliovalue = new Zend_Form_Element_Text('portfoliovalue');
		$protfoliovalue->setAttrib('class', 'txt_put');
		$protfoliovalue->setAttrib('id', 'protfoliovalue');
		$protfoliovalue->setRequired(true)
				->addValidators(array(array('NotEmpty'),array('Float')));

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
		
		$status = new Zend_Form_Element_Checkbox('status');
		$status->setAttrib('class', 'txt_put');
		$status->setAttrib('id', 'status');
		$status->setLabel('Active')
					->setRequired(true);

		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('class', 'officesubmit');
		$submit->setlabel('Submit');

		$this->addElements( array ($protfoliovalue,$status,$creditlinefrom,$creditlineto,$submit,$creditlinename));

//===================================================================================================================================
	}
}