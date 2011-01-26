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
class  Commonviewfee_Form_Feedetails extends Zend_Form {

    	public function init() {
			$fee_id = new Zend_Form_Element_Hidden('fee_id');
			
			$membertype = new Zend_Form_Element_Select('membertype');
			$membertype->addMultiOption('','Select...');
			$membertype->setAttrib('class', 'txt_put');
			$membertype->setRequired(true)
			->addValidators(array(array('NotEmpty')));
			
			$feename = new Zend_Form_Element_Text('feename');
			$feename->setAttrib('class', '');
			$feename->setAttrib('size', '10');
		
			$feedescription = new Zend_Form_Element_Text('feedescription');
			$feedescription->setAttrib('class', '');
			$feedescription->setAttrib('size', '10');
			
			$feeamount = new Zend_Form_Element_Text('feeamount');
			$feeamount->setAttrib('class', '');
			$feeamount->setAttrib('size', '10');
                       

                        $submit = new Zend_Form_Element_Submit('Submit');
			$back= new Zend_Form_Element_Submit('Back');
			$update = new Zend_Form_Element_Submit('Update');

		        $this->addElements(array($update,$fee_id,$back,$feename,$feedescription,$feeamount,$submit,$membertype));

    }
}
