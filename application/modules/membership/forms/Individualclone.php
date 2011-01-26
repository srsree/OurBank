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

class Membership_Form_Individualclone extends Zend_Form
{
    public function init() {
        Zend_Dojo::enableForm($this);
    }

    public function __construct($app,$value) {
        Zend_Dojo::enableForm($this);
        parent::__construct($app);
        parent::__construct($value);

        $membertitle = new Zend_Form_Element_Select('membertitle');
        $membertitle->setAttrib('class', 'txt_put');        
        $membertitle->setAttrib('id', 'membertitle');
        $membertitle->setAttrib('tabindex', '3');
        $membertitle->setAttrib($value,'true');

        $memberfirstname = new Zend_Form_Element_Text('memberfirstname');
        $memberfirstname->setAttrib('class', '');
        $memberfirstname->setAttrib('size', '10');
        $memberfirstname->setAttrib('id', 'memberfirstname');



        $memberaddressline1 = new Zend_Form_Element_Text('memberaddressline1');
        $memberaddressline1->setAttrib('class', 'txt_put');
        $memberaddressline1->setAttrib('id', 'memberaddressline1');
        $memberaddressline1->setAttrib('tabindex','13');
        $memberaddressline1->setAttrib($value,'true');



        $memberaddressline2 = new Zend_Form_Element_Text('memberaddressline2');
        $memberaddressline2->setAttrib('class', 'txt_put');
        $memberaddressline2->setAttrib('id', 'memberaddressline2');
        $memberaddressline2->setAttrib('tabindex', '14');
        $memberaddressline2->setAttrib($value,'true');

      

        $memberaddressline3  = new Zend_Form_Element_Text('memberaddressline3');
        $memberaddressline3->setAttrib('class', 'txt_put');
        $memberaddressline3->setAttrib('id', 'memberaddressline3');
        $memberaddressline3->setAttrib('tabindex', '15');
        $memberaddressline3->setAttrib($value,'true');

   
        $membercity = new Zend_Form_Element_Text('membercity');
        $membercity->setAttrib('class', 'txt_put');
        $membercity->setAttrib('id', 'membercity');
        $membercity->setAttrib('tabindex', '16');
        $membercity->setAttrib($value,'true');

        $familymembername = new Zend_Form_Element_Text('familymembername');
        $familymembername->setAttrib('class', 'txt_put');
        $familymembername->setAttrib('size', '10');
        $familymembername->setAttrib('id', 'familymembername');

        $memberId = new Zend_Form_Element_Text('member_id');
        $memberId->setAttrib('class', 'txt_put');
        $memberId->setAttrib('readonly', 'true');
        $memberId->setAttrib('size', '10');

        $OFFICE_TYPE = new Zend_Form_Element_Select('officeType');
        $OFFICE_TYPE->addMultiOption('','Select');
        $OFFICE_TYPE->setAttrib('class','txt_put');
        $OFFICE_TYPE->setAttrib('onchange', 'getBranch(this.value,"'.$app.'")');
        $OFFICE_TYPE->setAttrib('tabindex', '1');
        $OFFICE_TYPE->setAttrib($value,'true');

        $SUB_OFFICE = new Zend_Form_Element_Select('subOffice');
        $SUB_OFFICE->setAttrib('class','txt_put');
        $SUB_OFFICE->setAttrib('tabindex', '2');
        $SUB_OFFICE->setAttrib($value,'true');

        $submit = new Zend_Form_Element_Submit('Save');
        $submit->setAttrib('id', 'save');

        $this->addElements( array ($OFFICE_TYPE,
                                $SUB_OFFICE,
                                $memberfirstname,
                                $familymembername,
                                $membertitle,
                                $memberaddressline1,
                                
                                $memberaddressline2,
             
                                $memberaddressline3,
                                $membercity,
                                $submit,
                                $memberId));

        $memberId = new Zend_Form_Element_Hidden('memberId');
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setAttrib('class', 'officesubmit');
        $this->addElements(array($submit,$memberId));
    }
}

