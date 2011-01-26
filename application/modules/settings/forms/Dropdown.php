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
class settings_Form_Dropdown extends  ZendX_JQuery_Form 
{
    public function init() 
    {
        $text_value = new Zend_Form_Element_Text('textvalue');
        $text_value->setAttrib('class', 'txt_put');
        $text_value->addValidators(array(array('NotEmpty')))
                    ->setRequired(true);

        $table_name = new Zend_Form_Element_Hidden('table_name');
        $id = new Zend_Form_Element_Hidden('id');
        $attr = new Zend_Form_Element_Hidden('attr');

        $submit=new Zend_Form_Element_Submit('Add');

        $this->addElements(array($text_value,$table_name,$id,$attr,$submit));
    }
}