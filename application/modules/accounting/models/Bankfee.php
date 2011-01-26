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
class Accounting_Model_Bankfee extends Zend_Db_Table {
     protected $_name = 'ourbank_bankfeeaccount';

    public function Addbankfee($branchAccountNumber,$transaction_id,$account_id,$feeTotal) {
        $data = array('bank_id' => '',
                      'bank_account_id' => $branchAccountNumber,
                      'tranasction_number' => $transaction_id,
                      'fee_id' => '',
                      'transaction_date' => date("Y-m-d"),
                      'amount_to_bank' => $feeTotal,
                      'amount_from_bank'=> '',
                      'From_account_number' => $account_id,
                      'is_fund' => '',
                      'record_status' => 1);
       $this->insert($data);
	}
}
