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

class Management_Form_Subledger extends Zend_Form
{
    public function init()
    {
        Zend_Dojo::enableForm($this);
    }

    public function __construct($options = null)
    {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);


	$subheader = new Zend_Form_Element_Text('subheader');
        $subheader->setAttrib('class', 'txt_put');
        $subheader->setAttrib('id', 'subheader');
	$subheader->setRequired(true)
		->addValidators(array(array('NotEmpty')));

	$glsubaccountdescription = new Zend_Form_Element_Textarea
        ('glsubaccountdescription', array('rows' => 3,'cols' => 25,));
        $glsubaccountdescription->setAttrib('id', 'glsubaccountdescription');
	$glsubaccountdescription->setRequired(true)
		->addValidators(array(array('NotEmpty')));

        $submit = new Zend_Form_Element_Submit('Save');
        $submit->setAttrib('id', 'save');
        $submit->setAttrib('class', 'holiday1');
        $this->addElements( array ($subheader,$glsubaccountdescription));

        $glcodeUpdateId = new Zend_Form_Element_Hidden('glcodeUpdateId');
	$glsubcodeupdate_id = new Zend_Form_Element_Hidden('glsubcodeupdate_id');

        $this->addElements(array($submit,$glcodeUpdateId,$glsubcodeupdate_id));
    }
}
