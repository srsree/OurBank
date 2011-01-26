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
class Transaction_Model_Payments extends Zend_Db_Table {
	protected $_name = 'ourbank_Expenditure';


	public function addpaymentsfromaccounts($tablenamefrom,$bankIDfrom,$fromglsubcodeid,$toglsubcodeid,$transaction_id,$amount) {

		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('bank_id'=> $bankIDfrom,
				'glsubcode_id_to'=>$fromglsubcodeid,
				'tranasction_number'=>$transaction_id,
				'credit'=>'',
				'debit'=>$amount,
				'record_status'=>'3');
		return $this->db->insert($tablenamefrom,$data);
	}


	public function addpaymentstoaccounts($tablenameto,$bankIDto,$fromglsubcodeid,$toglsubcodeid,$transaction_id,$amount) {

		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('bank_id'=> $bankIDto,
				'glsubcode_id_to'=>$toglsubcodeid,
				'tranasction_number'=>$transaction_id,
				'credit'=>$amount,
				'debit'=>'',
				'record_status'=>'3');
		return $this->db->insert($tablenameto,$data);
	}
}
