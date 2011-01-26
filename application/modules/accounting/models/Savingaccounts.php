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
class Accounting_Model_Savingaccounts extends Zend_Db_Table {
     protected $_name = 'ourbank_transaction';


    public function Addtransaction($post,$account_id,$createdby,$tAmount,$interest) {
        $data = array('transaction_id' => '',
                      'account_id' => $account_id,
                      'transaction_date' => date("Y-m-d"),
                      'amount_to_bank' => $post['amount'],
                      'amount_from_bank' => '',
                      'transaction_amount' => $tAmount,
                      'transaction_interest_amount'=> $interest,
                      'transaction_fine_amount' => '',
                      'transaction_other_amount' => '',
                      'paymenttype_mode' => 1,
                      'transaction_mode_details' => 1,
                      'transaction_type' => 1,
                      'recordstatus_id' =>3,
                      'reffering_vouchernumber' =>'',
                      'transaction_remarks' => '',
                      'balance' => '',
                      'confirmation_flag' =>0,
                      'updated_by' => '',
                      'created_by' => $createdby,
                      'createddate' => date("Y-m-d"));
       $this->insert($data);
	}
}
