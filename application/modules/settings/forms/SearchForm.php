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
class settings_Form_SearchForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
            $this->setName('Search Staff');
            $offerproductname = new Zend_Form_Element_Text('offerproductname');
            $offerproductname->setAttrib('class', 'textfield');

            $offerproductshortname = new Zend_Form_Element_Text('offerproductshortname');
            $offerproductshortname->setAttrib('class', 'textfield');

            $minimumloaninterest = new Zend_Form_Element_Text('minimumloaninterest');
            $minimumloaninterest->setAttrib('class', 'textfield');

            $maximunloanamount = new Zend_Form_Element_Text('maximunloanamount');
            $maximunloanamount->setAttrib('class', 'textfield');

            $submit = new Zend_Form_Element_Submit('Search');
            $submit->setAttrib('class', 'NormalBtn');

            $this->addElements(array($offerproductname,$offerproductshortname,$minimumloaninterest,$maximunloanamount,$submit));
        }
}
