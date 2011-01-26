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
	class Management_Form_category extends Zend_Form {
		public function init() {
			Zend_Dojo::enableForm($this);
		}

		public function __construct($options = null) {
			Zend_Dojo::enableForm($this);
			parent::__construct($options);

			$categoryname = new Zend_Form_Element_Text('categoryname');
			$categoryname->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_categorydetails', 'categoryname'));
			$categoryname->setAttrib('class', 'txt_put');
			$categoryname->setAttrib('id', 'categoryname')
						->setLabel('Category  Name');
			$categoryname->setRequired(true)
						->addValidators(array(array('NotEmpty')))
						->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

			$category_id = new Zend_Form_Element_Hidden('category_id');
			$category_id->setAttrib('class', 'txt_put');
			$category_id->setAttrib('id', 'category_id')
						->setLabel('');


			$categorydescription= new Zend_Form_Element_Textarea('categorydescription', array('rows' => 3,'cols' => 20,));
			$categorydescription->setAttrib('id', 'categorydescription')
								->setLabel('Category  Description');
			$categorydescription->setRequired(true)
								->addValidators(array(array('NotEmpty')))
								->setDecorators(array('ViewHelper',
			array('Description',array('tag'=>'','escape'=>false)),'Errors',
			array(array('data'=>'HtmlTag'), array('tag' => 'td')),
			array('Label', array('tag' => 'td')),
			array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

			$this->addElements(array($categoryname,$categorydescription,$category_id));

// 			$cust = new settings_Model_Customization();
// 			$sample = $cust->fetchcustomized("ourbank_customizingform",1);
// 			foreach($sample as $cust1) {
// 				switch($cust1['feild_type']) {
// 					case "text" : $Instance = new Zend_Form_Element_Text($cust1['feild_name']);
// 						$Instance->setLabel($cust1['display_name']);
// 						$Instance->setAttrib('size','8');
// 						if ($cust1['feild_name'])
// 							$Instance->setRequired(true)
// 									->setDecorators(array('ViewHelper',
// 									array('Description',array('tag'=>'','escape'=>false)),'Errors',
// 									array(array('data'=>'HtmlTag'), array('tag' => 'td')),
// 									array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
// 									array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
// 					break;
// 
// 					case "radio" :  $Instance = new Zend_Form_Element_Radio($cust1['feild_name']);
// 						$Instance->setLabel($cust1['display_name']);
// 						$appliesTo = $cust->getTableInfo($cust1['table_name']);
// 						foreach ($appliesTo as $gracePeriodRow) {
// 							$radioValues[current($gracePeriodRow)] = end($gracePeriodRow);
// 						}
// 						$Instance->setMultiOptions($radioValues);
// 						unset($radioValues);
// 						if ($cust1['feild_name'])
// 							$Instance->setRequired(true)
// 									->setDecorators(array('ViewHelper',
// 									array('Description',array('tag'=>'','escape'=>false)),'Errors',
// 									array(array('data'=>'HtmlTag'), array('tag' => 'td')),
// 									array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
// 									array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
// 					break;
// 
// 					case "select" : $Instance = new Zend_Form_Element_Select($cust1['feild_name']);
// 						$Instance->setLabel($cust1['display_name']);
// 						$appliesTo = $cust->getTableInfo($cust1['table_name']);
// 						foreach ($appliesTo as $gracePeriodRow) {
// 							$radioValues[current($gracePeriodRow)] = end($gracePeriodRow);
// 						}
// 						$Instance->setMultiOptions($radioValues);
// 						unset($radioValues);
// 						if ($cust1['feild_name'])
// 							$Instance->setRequired(true)
// 									->setDecorators(array('ViewHelper',
// 									array('Description',array('tag'=>'','escape'=>false)),'Errors',
// 									array(array('data'=>'HtmlTag'), array('tag' => 'td')),
// 									array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
// 									array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
// 					break;
// 
// 					case "description" : $Instance = new Zend_Form_Element_Textarea($cust1['feild_name'], array('rows' => 3,'cols' => 20,));
// 						$Instance->setLabel($cust1['display_name']);
// 						if ($cust1['feild_name'])
// 							$Instance->setRequired(true)
// 									->setDecorators(array('ViewHelper',
// 									array('Description',array('tag'=>'','escape'=>false)),'Errors',
// 									array(array('data'=>'HtmlTag'), array('tag' => 'td')),
// 									array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
// 									array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
// 					break;
// 
// 					case "checkbox" : $Instance = new Zend_Form_Element_MultiCheckbox($cust1['feild_name']);
// 						$Instance->setLabel($cust1['display_name']);
// 						$appliesTo = $cust->getTableInfo($cust1['table_name']);
// 						foreach ($appliesTo as $gracePeriodRow) {
// 							$radioValues[current($gracePeriodRow)] = end($gracePeriodRow);
// 						}
// 						$Instance->setMultiOptions($radioValues);
// 						unset($radioValues);
// 						if($cust1['feild_name'])
// 							$Instance->setRequired(true)
// 									->setDecorators(array('ViewHelper',
// 									array('Description',array('tag'=>'','escape'=>false)),'Errors',
// 									array(array('data'=>'HtmlTag'), array('tag' => 'td')),
// 									array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
// 									array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
// 					break;
// 				}
// 				$this->addElements(array($Instance));
// 			}

			$submit = new Zend_Form_Element_Submit('Submit');
			$submit->setAttrib('id', 'save')
					->setDecorators(array('ViewHelper',
					array('Description',array('tag'=>'','escape'=>false)),'Errors',
					array(array('data'=>'HtmlTag'), array('colspan' => '8 ')),
					array(array('data'=>'HtmlTag'), array('tag' => 'td ', 'colspan'=>'8')),
					array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

			$this->addElements(array($submit));
		}
	}