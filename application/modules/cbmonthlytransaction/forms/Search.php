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
class Cbmonthlytransaction_Form_Search extends ZendX_JQuery_Form {
    public function init() {
    Zend_Dojo::enableForm($this);
    }
      public function __construct($options = null) {
        Zend_Dojo::enableForm($this);
        parent::__construct($options);


        

       		$field1 = new Zend_Form_Element_Select('field1');
               $field1->addMultiOption('','Month...');
               $field1->addMultiOptions(array(	'01'=>'January',
						'02'=>'February',
						'03'=>'March',
						'04'=>'April',
						'05'=>'May',
						'06'=>'June',
						'07'=>'July',
						'08'=>'August',
						'09'=>'September',
						'10'=>'October',
						'11'=>'November',
						'12'=>'December'));
               $field1->setAttrib('class', 'txt_put');
               $field1->setAttrib('id', 'unit_per_month');
               $field1->setRequired(true);



 	$field2 = new Zend_Form_Element_Select('field2');
        $field2->addMultiOption('','Year');
	$field2->addMultiOptions(array('2010'=>'2010',
									'2009'=>'2009',
									'2008'=>'2008',
									'2007'=>'2007',
									'2006'=>'2006',
									'2005'=>'2005',
									'2004'=>'2004',
									'2003'=>'2003',
									'2002'=>'2002',
									'2001'=>'2001',
									'2000'=>'2000',
									'1999'=>'1999',
									'1998'=>'1998',
									'1997'=>'1997',
									'1996'=>'1996',
									'1995'=>'1995',
									'1994'=>'1994',
									'1993'=>'1993',
									'1992'=>'1992',
									'1991'=>'1991',
									'1990'=>'1990'));
        $field2->setAttrib('class', 'txt_put');

	$field3 = new Zend_Form_Element_Select('field3');
        $field3->addMultiOption('','Select');
        $field3->setAttrib('class', 'txt_put');

        $submit = new Zend_Form_Element_Submit('Search');

        $pdf=new Zend_Form_Element_Submit('PDF');

        $this->addElements(array($field1,$field2,$field3,$submit,$pdf));

    }
}
