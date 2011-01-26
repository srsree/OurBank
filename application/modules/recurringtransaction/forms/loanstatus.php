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
/**Loan Disbursement Module
This Class will
-Create an disbursement form having 3 fields namely date description n disbursed amount
*/
class Transaction_Form_loanstatus extends Zend_Form
    {
		public function __construct($options = null)
		{
			parent::__construct($options);

			$accountCode= new Zend_Form_Element_Hidden('accountcode');
			$memberId = new Zend_Form_Element_Hidden('membercode');
			$categoryId = new Zend_Form_Element_Hidden('categoryId');

			$newStatus = new Zend_Form_Element_Select('newStatus');
			$newStatus->setAttrib('class', 'NormalBtn');
                        $newStatus->setRequired(true);
                        $newStatus->addMultiOption('','Select...');

			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);

			$newStatus1 = new Zend_Form_Element_Hidden('newStatus1');
			$description1 = new Zend_Form_Element_Hidden('description1');


            $submit = new Zend_Form_Element_Submit('Submit');
            $submit->setAttrib('class', 'officesubmit');

            $Confirm = new Zend_Form_Element_Submit('Confirm');
            $Confirm->setAttrib('class', 'officesubmit');

            $this->addElements( array ($submit,$newStatus,$description,$accountCode,$memberId,$categoryId,$Confirm,$newStatus1,$description1));
        }
    }
