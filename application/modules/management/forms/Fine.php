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
class Management_Form_Fine extends Zend_Form {
public function init() {
Zend_Dojo::enableForm($this);
}
public function __construct($currencysymbol) {
Zend_Dojo::enableForm($this);
parent::__construct($options);


$finename = new Zend_Form_Element_Text('finename');
$finename->setRequired(true)
->addValidators(array(array('NotEmpty')));
$finename->setAttrib('class', 'txt_put');
$finename->setAttrib('id', 'finename');

$membertype = new Zend_Form_Element_Select('membertype');
$membertype->setAttrib('class', 'selectbutton');
$membertype->setAttrib('id', 'membertype');
$membertype->setRequired(true)
->addValidators(array(array('NotEmpty')));

$finedescription = new Zend_Form_Element_Text('finedescription');
$finedescription->setAttrib('class', 'txt_put');
$finedescription->setAttrib('id', 'finedescription');
$finedescription->setRequired(true)
->addValidators(array(array('NotEmpty')));


$finevalue = new Zend_Form_Element_Text('finevalue');
$finevalue->setAttrib('class', 'txt_put');
$finevalue->setAttrib('id', 'finevalue');
$finevalue->setAttrib('size', '6');
$finevalue->setRequired(true)
->addValidators(array(array('NotEmpty')));



$submit = new Zend_Form_Element_Submit('Save');
$submit->setAttrib('id', 'save');
$this->addElements( array (

$finename,
$finedescription,
$membertype,
$finevalue));

$fineId = new Zend_Form_Element_Hidden('fineId');
$submit = new Zend_Form_Element_Submit('Submit');
$submit->setAttrib('class', 'finesubmit');
$submit->setLabel('submit');
$this->addElements(array($submit,$fineId));
}
}
