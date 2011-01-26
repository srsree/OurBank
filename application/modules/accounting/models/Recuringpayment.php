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
class Accounting_Model_Recuringpayment extends Zend_Db_Table {
     protected $_name = 'ourbank_recurring_payment';


    public function Addrecuringpayment($transaction_id,$account_id,$date1,$savings_amount) {
        $data = array('rec_paymentserial_id' => '',
                      'transaction_id' => $transaction_id,
                      'account_id' => $account_id,
                      'rec_payment_number' => 1,
                      'rec_paymentpaid_date' => $date1,
                      'rec_paid_amount' => $savings_amount,
                      'rec_paid_interst' => '',
                      'rec_paid_other_amount' => '',
                      'recordstatus_id' => 3);
       $this->insert($data);
	}
}
