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
class Accounting_Model_fixaccounts extends Zend_Db_Table {

     protected $_name = 'ourbank_fixedaccounts';


    public function Addfixedaccounts($account_id,$date1,$createby,$matureDates,$savings_amount,$interest) {
        $data = array('fixedaccount_id' => '',
                      'account_id' =>$account_id,
                      'begin_date' =>$date1,
                      'mature_date' => $matureDates,
                      'fixed_amount' => $savings_amount,
                      'timefrequncy_id' => 1,
                      'fixed_interest' => $interest,
                      'premature_interest' => '',
                      'fixedaccountstatus_id' => 3,
                      'created_by' => $createby,
                      'created_date' => date('Y-m-d'),
                      'modified_by' => '',
                      'modified_date' => '',
                      'recordstatus_id' => 3
                      ); 
       $this->insert($data);
    }
}
