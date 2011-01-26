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
class Accounting_Model_Fixedpayment extends Zend_Db_Table {
     protected $_name = 'ourbank_fixed_payment';


    public function Addfixedpayment($transaction_id,$account_id,$date1) {
        $data = array('fixed_paymentserial_id' => '',
                      'transaction_id' => $transaction_id,
                      'account_id' => $account_id,
                      'fixed_paymentpaid_date' => $date1,
                      'fixed_amount' => '',
                      'fixed_interst_amount' => '',
                      'fixed_penalty_amount'=> '',
                      'fixed_other_deduction_amount' => '',
                      'recordstatus_id' => 1);
       $this->insert($data);
	}
}
