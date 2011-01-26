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
class Accounting_Model_Reccuringtransaction extends Zend_Db_Table {
     protected $_name = 'ourbank_recurringaccounts';


    public function Addrecuring($account_id,$date1,$matureDates,$amount,$interest,$createby) {
        $data = array('recurringaccount_id' => '',
                      'account_id' => $account_id,
                      'begin_date' => $date1,
                      'mature_date' => $matureDates,
                      'recurring_amount' => $amount,
                      'timefrequncy_id' => '',
                      'fixed_interest'=> $interest,
                      'premature_interest' => '',
                      'fixedaccountstatus_id' => 1,
                      'created_by' => $createby,
                      'created_date' => date('Y-m-d'),
                      'modified_by' => '',
                      'modified_date' =>'',
                      'recordstatus_id' =>3);
       $this->insert($data);
	}
}
