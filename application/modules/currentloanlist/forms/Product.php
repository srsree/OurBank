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
	class Sectors_Form_Product extends Zend_Form {

	public function init() 
        {
// 		$sectortname = new Zend_Form_Element_Text('productname');
// 		$sectortname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_productdetails', 'productname'));
// 		$sectortname->setAttrib('class', 'txt_put')
// 					->setLabel('Sector Name');
// 		$sectortname->setRequired(true);

		


		$testingform = new Sectors_Form_Testing();

                $sectortname = $testingform->testingtextbox('productname','ourbank_productdetails','productname','txt_put','Sector Name',true);

		$sectortname2 = $testingform->testingtextbox('activity','ourbank_productdetails','productname','txt_put','activity',false);

		//print_r($sectortname);

		$product_id = new Zend_Form_Element_Hidden('product_id');
		$product_id->setAttrib('class', 'txt_put');


		$sector_description= new Zend_Form_Element_Textarea('product_description', array('rows' => 3,'cols' => 20,));
		$sector_description->setAttrib('class', '')
				   ->setLabel('Sector description');
		$sector_description->setRequired(true)
				   ->addValidators(array(array('NotEmpty')));

		$active_id = new Zend_Form_Element_Checkbox('active_id');
		$active_id->setAttrib('class', 'txt_put')
					->setLabel('Active');
		$active_id->setRequired(true)
					->addValidators(array(array('NotEmpty')))
					->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$submit = new Zend_Form_Element_Submit('Submit');
		$submit->setAttrib('id', 'Save')
				->setLabel('Save')
				->setDecorators(array('ViewHelper',
					array('Description',array('tag'=>'','escape'=>false)),'Errors',
					array(array('data'=>'HtmlTag'), array('colspan' => '8 ')),
					array(array('data'=>'HtmlTag'), array('tag' => 'td ', 'colspan'=>'8')),
					array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

		$this->addElements(array($sectortname,$sectortname2,$sector_description,$product_id,$active_id,$submit));


			

	}
}