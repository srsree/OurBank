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
class Accounting_Model_Loanaccounts extends Zend_Db_Table {
     protected $_name = 'ourbank_loanaccounts';


    public function Addloanaccounts($account_id,$date1,$savings_amount,$period,$interest,$createdby) {
        $data = array('loanaccount_id' => '',
                      'account_id' => $account_id,
                      'loanstatus_id' => 1,
                      'loansanctioned_date' => $date1,
                      'loanbegin_date' => date("Y-m-d"),
                      'loan_amount' => $savings_amount,
                      'loan_installments'=> $period,
                      'timefrequncy_id' => '',
                      'loan_interest' => $interest,
                      'savingsaccount_id' => '',
                      'tieup_flag' => 0,
                      'recordstatus_id' => 3,
                      'transacted_by' => $createdby);
       $this->insert($data);
	}
}
