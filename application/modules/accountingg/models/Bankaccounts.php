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
class Accounting_Model_Bankaccounts extends Zend_Db_Table {
     protected $_name = 'ourbank_bankaccount_details';


    public function Addbankaccounts($account_id,$savings_amount,$transaction_id,$branchAccountNumber) {
        $data = array('bank_id' => '',
                      'bank_account_id' => $branchAccountNumber,
                      'tranasction_number' => $transaction_id,
                      'transaction_date' => date("Y-m-d"),
                      'amount_to_bank' => $savings_amount,
                      'amount_from_bank' => '',
                      'From_account_number'=> $account_id,
                      'is_fund' => '',
                      'record_status' => 1);
       $this->insert($data);
	}
}
