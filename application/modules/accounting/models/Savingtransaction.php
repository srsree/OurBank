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
class Accounting_Model_Savingtransaction extends Zend_Db_Table {
     protected $_name = 'ourbank_savings_transaction';


    public function Addsavingtransaction($transaction_id,$account_id,$createdby,$savings_amount,$interest,$transactionamount,$date1) {
        $data = array('savingtransaction_id' => '',
                      'transaction_id' => $transaction_id,
                      'account_id' => $account_id,
                      'transaction_date' => $date1,
                      'transactiontype_id' => 1,
                      'transaction_amount' => $savings_amount,
                      'paymenttype_id'=> 1,
                      'paymenttype_details' => '',
                      'transaction_description' => '',
                      'transaction_interest' => '',
                      'transaction_by' =>$createdby,
                      'createddate' => date("Y-m-d"),
                      'recordstatus_id' => 3);
       $this->insert($data);
	}
}
