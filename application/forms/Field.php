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
class App_Form_Field extends Zend_Form 
    {
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	public function field($fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value) 
	{
            $fieldtype = "Zend_Form_Element_".$fieldtype;
		
            if($fieldtype=='Zend_Form_Element_Textarea')    {
                $formVariable = new $fieldtype($fieldname, array('rows' => $rows,'cols' => $cols,));
            } else if($fieldtype=='Zend_Form_Element_Select')   { 
                $formVariable = new $fieldtype($fieldname); $formVariable->addMultiOption('','Select');
            } else { $formVariable = new $fieldtype($fieldname); }
            
            if ($table) {
                $formVariable->addValidator(new Zend_Validate_Db_NoRecordExists($table,$columnname));
            }

            $formVariable->setAttrib('class',$cssname);
            $formVariable->setAttrib('id',$fieldname);

            if($required){$formVariable->setRequired($required);}

            $counttype=count($validationtype);

            if($validationtype){

                for($i=0;$i<$counttype;$i++)
                {
                    if($validationtype[$i]=='StringLength') {
                        $formVariable->addValidator($validationtype[$i], false, array(4, 15));
                    }
                    if($validationtype[$i]!='StringLength') {
                        $formVariable->addValidators(array(array($validationtype[$i],true)));
                    }
                }

            }

				
            if ($decorator) {
				$translator = $this->getTranslator();
                $formVariable->setLabel($translator->translate($labelname));
                $formVariable->setDecorators(array('ViewHelper',
							array('Description',array('tag'=>'','escape'=>false)),'Errors',
							array(array('data'=>'HtmlTag'), array('tag' => 'td')),
							array('Label', array('tag' => 'td','class' => $cssname)),
							array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
            } else {
                $formVariable->removeDecorator('DtDdWrapper'); 
                $formVariable->removeDecorator('HtmlTag');
                $formVariable->removeDecorator('label');
            }

            if ($value) {
                $formVariable->setValue($value);
            }
            return $formVariable;
        }
    }
