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
class settings_Form_LoanForm extends Zend_Form
{

         public function __construct($options= null)
        {
            Zend_Dojo::enableForm($this);
            parent::__construct();
            $cust = new settings_Model_Customization();

            $sample = $cust->fetchcustomized();  
            foreach($sample as $cust1) {
            
            switch($cust1['feild_type']) {

            case "text" : $Instance = new Zend_Form_Element_Text($cust1['feild_name']);
                          $Instance->setLabel($cust1['display_name']);
                          $Instance->setAttrib('size','8');
                          if($cust1['feild_name'])

                          $Instance->setRequired(true)
                                            ->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

                          break;

            case "radio" : $Instance = new Zend_Form_Element_Radio($cust1['feild_name']);
                          $Instance->setLabel($cust1['display_name']);
                            $appliesTo = $cust->getTableInfo($cust1['table_name']);
                            foreach($appliesTo as $appliesTo1) {
                            foreach($appliesTo as $key => $value) {
                            $i =1;
                            foreach($value as $key1 => $value1) {
                                if($i%2 == 0) { //faltu start

                                $f2 = $appliesTo1[$key1];
                                } else {
                                $f1 = $appliesTo1[$key1];
                                }
                                 $Instance->addMultiOption($f1,$f2);
                                $i++;
                                 } //faltu end

                            }
                            }
                          if($cust1['feild_name'])


                          $Instance->setRequired(true)
                          ->addValidators(array(array('NotEmpty')))
                         ->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));

                              break;

            case "select" : $Instance = new Zend_Form_Element_Select($cust1['feild_name']);
                            $Instance->setLabel($cust1['display_name']);

                            $appliesTo = $cust->getTableInfo($cust1['table_name']);
                            foreach($appliesTo as $appliesTo1) {
                            foreach($appliesTo as $key => $value) {
                            $i =1;
                            foreach($value as $key1 => $value1) {
                                if($i%2 == 0) { //faltu start

                                $f2 = $appliesTo1[$key1];
                                } else {
                                $f1 = $appliesTo1[$key1];
                                }
                                 $Instance->addMultiOption($f1,$f2);
                                $i++;
                                 } //faltu end

                            }
                            }
                            if($cust1['feild_name'])
                            $Instance->setRequired(true)
                           ->addValidators(array(array('NotEmpty')))
                           ->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
                            break;

            case "description" : $Instance = new Zend_Form_Element_Textarea($cust1['feild_name'], array('rows' => 3,'cols' => 20,));
                                 $Instance->setLabel($cust1['display_name']);

                                 if($cust1['feild_name'])
                                 $Instance->setRequired(true)

                                ->addValidators(array(array('NotEmpty')))
                                ->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
                            break;

           case "checkbox" : $Instance = new Zend_Form_Element_MultiCheckbox($cust1['feild_name']);
                                 $Instance->setLabel($cust1['display_name']);

                            $appliesTo = $cust->getTableInfo($cust1['table_name']);

                            foreach($appliesTo as $appliesTo1) {
                            foreach($appliesTo as $key => $value) {
                            $i =1;
                            foreach($value as $key1 => $value1) {
                                if($i%2 == 0) { //faltu starta

                                $f2 = $appliesTo1[$key1];
                                } else {
                                $f1 = $appliesTo1[$key1];
                                } 
                                 $Instance->addMultiOption($f1,$f2);
                                $i++;
                                 } //faltu end

                            }
                            }

                                 if($cust1['feild_name'])
                                 $Instance->setRequired(true)

                                ->addValidators(array(array('NotEmpty')))
                                ->setDecorators(array('ViewHelper',
						array('Description',array('tag'=>'','escape'=>false)),'Errors',
						array(array('data'=>'HtmlTag'), array('tag' => 'td')),
						array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
						array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
                            break;
            }
            $this->addElements(array($Instance));
    }
}
}
