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
class Accounting_Model_Savingaccounttransaction extends Zend_Db_Table {
     protected $_name = 'ourbank_savingsaccounts';
 
   public function Addsavingaccounttransaction($account_id,$date1,$savings_amount,$createdby,$interest) {

        $data = array('savingsaccount_id' => '',
                      'account_id' => $account_id,
                      'savingsaccountstatus_id' => 1,
                      'approved_date' => $date1,
                      'savingsbegin_date' => date("Y-m-d"),
                      'savingsmature_date' => '',
                      'savings_amount'=> $savings_amount,
                      'savings_rateofinterest' => '',
                      'savings_period_frequency' => '',
                      'savings_description' => '',
                      'recordstatus_id' => 3);
       $this->insert($data);
	}
}