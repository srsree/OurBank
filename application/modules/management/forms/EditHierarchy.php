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
/**
	*this clas for creating a form for office hierarchy
	*all vaildated
**/

class Management_Form_EditHierarchy extends Zend_Form
{
    public function __construct($options = null)
    {
    	parent::__construct($options);
		$id = new Zend_Form_Element_Hidden('id');
		$hierarchyLevel = new Zend_Form_Element_Hidden('hierarchyLevel');
    	$officeType = new Zend_Form_Element_Text('officeType');
        $officeType->setRequired(true)
					->addValidators(array(array('NotEmpty'),
									array('stringLength', false, array(4, 50))
							        )
								);
		// $officeType->addValidator($db_lookup_validator); 
		$officeType->setAttrib('class', 'txt_put');
		$officeType->setAttrib('id', 'officeType');
	  	$officeCode = new Zend_Form_Element_Text('officeCode');
	   	$officeCode->setRequired(true)
				->addValidators(array(array('NotEmpty'),
										array('stringLength', false, array(2, 2))
										)
									);
		$officeCode->setAttrib('class', 'txt_put');
		$officeCode->setAttrib('id', 'officeCode')
						->setAttrib('size', '2');
   		$this->addElements(array($id,$officeType,$officeCode,$hierarchyLevel));

        	$submit = new Zend_Form_Element_Submit('Edit');
                $submit->setAttrib('class', 'officebutton');
                $submit->setLabel('edit');
                $submit->removeDecorator('DtDdWrapper');

			$next = new Zend_Form_Element_Submit('Next');
			$next->setAttrib('class', 'officesubmit');
			$next->setLabel('Next');
	
    	    $this->addElements(array($submit,$next));
		}
 }


/**class end*/
