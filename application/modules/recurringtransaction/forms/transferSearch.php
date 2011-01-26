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
    class Recurringtransaction_Form_transferSearch extends Zend_Form
    {
    public function __construct($options = null)
        {
            parent::__construct($options);
            $this->setName('Search Staff');
            $accountNumber= new Zend_Form_Element_Text('account_number');
            $accountNumber->setAttrib('class', 'txt_put');
			$accountNumber->setRequired(true);

			$amount= new Zend_Form_Element_Text('matured');
            $amount->setAttrib('class', 'txt_put');
			$amount->setAttrib('size', '8');
			$amount->setAttrib('readonly', 'true');

            $submit = new Zend_Form_Element_Submit('Transfer');
            $submit->setLabel('Transfer');

            $Confirm = new Zend_Form_Element_Submit('Confirm');
            $Confirm->setLabel('Confirm');

			$account_number1= new Zend_Form_Element_Hidden('account_number1');
			$matured1= new Zend_Form_Element_Hidden('matured1');

			$accountId= new Zend_Form_Element_Hidden('accountId');
			$productId= new Zend_Form_Element_Hidden('productId');
			
            $this->addElements(array($accountNumber,$submit,$amount,$accountId,$productId,$Confirm,$account_number1,$matured1));
         }
    }
