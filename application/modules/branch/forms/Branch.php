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

<!--
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
!-->
<?php
class  Branch_Form_Branch extends Zend_Form {

    public function init() {

    }

    //This function setup the form elements
    public function __construct($options = null) {

        Zend_Dojo::enableForm($this);
        parent::__construct($options);
        
        $office = new Zend_Form_Element_Select('office');
        $office->setAttrib('class', 'txt_put');
        $office->setAttrib('id', 'office')
                ->setLabel('Office');
        $office->setDecorators(array('ViewHelper',
                                array('Description',array('tag'=>'','escape'=>false)),'Errors',
                                array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                                array('Label', array('tag' => 'td','requiredSuffix' => ' *',)),
                                array(array('row'=>'HtmlTag'),array('tag'=>'tr'))));
        
        $type_id = new Zend_Form_Element_Hidden('type_id');
        $type_id->setAttrib('class', 'txt_put');
        $type_id->setAttrib('id', 'type_id')
                                ->setLabel('');
        
        $submit = new Zend_Form_Element_Submit('Submit');
        $back= new Zend_Form_Element_Submit('Back');
        
        $this->addElements(array($office,$type_id,$submit,$back));

    }
}
