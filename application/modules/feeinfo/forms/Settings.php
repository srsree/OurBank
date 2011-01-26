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
class Feeinfo_Form_Settings extends  ZendX_JQuery_Form {
public function init() {



$feename = new Zend_Form_Element_Text('feename');
    $feename->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_holidayupdates', 'holidayname'));
    $feename->setAttrib('class', 'txt_put');
    $feename->setRequired(true)
                ->addValidators(array(array('NotEmpty')));

	$feeamount = new Zend_Form_Element_Text('feeamount');
    $feeamount->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_holidayupdates', 'holidayname'));
    $feeamount->setAttrib('class', 'txt_put');
    $feeamount->setRequired(true)
                ->addValidators(array(array('NotEmpty')));


	$feedescription = new Zend_Form_Element_Text('feedescription');
    $feedescription->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_holidayupdates', 'holidayname'));
    $feedescription->setAttrib('class', 'txt_put');
    $feedescription->setRequired(true)
                ->addValidators(array(array('NotEmpty')));

$submit = new Zend_Form_Element_Submit('Submit');
$submit->removeDecorator('DtDdWrapper');
$this->addElements(array($feename,$feeamount,$feedescription,$submit));

}
}