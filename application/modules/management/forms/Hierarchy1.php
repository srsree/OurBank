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
class Management_Form_Hierarchy1 extends Zend_Form {

    public function __construct($options,$levelno) {
        if($options==0) {
            $ZendTranslate=Zend_Registry::get('Zend_Translate');
            $officeNo = new Zend_Form_Element_Select('officeNo');
            $officeNo->setRequired(true);
            $officeNo->addMultiOption('',$ZendTranslate->_('select').'...');
            $officeNo->addMultiOption('2','2');
            $officeNo->addMultiOption('3',' 3');
            $officeNo->addMultiOption('4',' 4');
            $officeNo->addMultiOption('5',' 5');
            $officeNo->addMultiOption('6',' 6');
            $officeNo->addMultiOption('7',' 7');
            $officeNo->addMultiOption('8',' 8');
            $officeNo->addMultiOption('9',' 9');
            $officeNo->addMultiOption('10',' 10');
            $officeNo->setAttrib('class','selectbutton');

            $officeType = new Zend_Form_Element_Text('officeType1');
            $officeType->setRequired(true)
                       ->addValidators(array(array('NotEmpty')));
            $officeType->setAttrib('class', 'txt_put');
            $officeType->setAttrib('id', 'officeType1');

            $officeCode = new Zend_Form_Element_Text('officeCode1');
            $officeCode->setRequired(true)
                       ->addValidators(array(array('NotEmpty')));
            $officeCode->setAttrib('class', 'txt_put');
            $officeCode->setAttrib('id', 'officeCode1')
                       ->setAttrib('size', '2');

            $this->addElements(array($officeType,$officeCode));

            for($i=2;$i<=$levelno;$i++) {
                $id = new Zend_Form_Element_Hidden('id'.$i);
                $officeType = new Zend_Form_Element_Text('officeType'.$i);
                $officeType->setRequired(true)
                           ->addValidators(array(array('NotEmpty')));
                $officeType->setAttrib('class', 'txt_put');
                $officeType->setAttrib('id', 'officeType'.$i);

                $officeCode = new Zend_Form_Element_Text('officeCode'.$i);
                $officeCode->setRequired(true)
                           ->addValidators(array(array('NotEmpty')));
                $officeCode->setAttrib('class', 'txt_put');
                $officeCode->setAttrib('id', 'officeCode'.$i)
                           ->setAttrib('size', '2');

                $this->addElements(array($id,$officeType,$officeCode));
            }

                $submit = new Zend_Form_Element_Submit('Edit');
                $submit->setAttrib('class', 'officesubmit');
                $submit->setLabel('edit');
                $this->addElements(array($submit));
                $this->addElements(array($officeNo));
                } else {
                    /**this create form to display existed Office hierarchy*/
                    for($i=1;$i<=$options;$i++) {
                        $db_lookup_validator = new Zend_Validate_Db_NoRecordExists('ourbank_officehierarchy', 'officetype'); 
                        $id = new Zend_Form_Element_Hidden('id'.$i);
                        $hierarchyLevel = new Zend_Form_Element_Hidden('hierarchyLevel'.$i);
                        $officeType = new Zend_Form_Element_Text('officeType'.$i);
                        $officeType->setRequired(true)
                                   ->addValidators(array(array('NotEmpty'),
                                                   array('stringLength', false, array(4, 50))));
                        $officeType->setAttrib('class', 'txt_put');
                        $officeType->setAttrib('id', 'officeType'.$i);

                        $officeCode = new Zend_Form_Element_Text('officeCode'.$i);
                        $officeCode->setRequired(true)
                                   ->addValidators(array(array('NotEmpty'),
                                                   array('stringLength', false, array(2, 2))));
                         $officeCode->setAttrib('class', 'txt_put');
                         $officeCode->setAttrib('id', 'officeCode'.$i)
                                    ->setAttrib('size', '2');

                         $this->addElements(array($id,$officeType,$officeCode,$hierarchyLevel));
            }

                        $officeNo = new Zend_Form_Element_Hidden('officeNo');
                        $OfficeLevel = new Zend_Form_Element_Text('officeLevel');

                        $OfficeLevel->setAttrib('size', '2');
                        $OfficeLevel->setAttrib('id', 'officeLevel');
                        $OfficeLevel->setAttrib('class', 'txt_put');
                        $OfficeLevel->addDecorators(array('ViewHelper','Errors',
                                                    array('HtmlTag', array('tag' => 'h')),
                                                    array('Label', array('tag' => 'h')),));

                        $submit = new Zend_Form_Element_Submit('Edit');
                        $submit->setAttrib('class', 'officebutton');
                        $submit->setLabel('edit');
                        $next = new Zend_Form_Element_Submit('Next');
                        $next->setAttrib('class', 'officesubmit');
                        $next->setLabel('Next');
                        $this->addElements(array($submit,$officeNo,$OfficeLevel,$next));
                }
    }
 }