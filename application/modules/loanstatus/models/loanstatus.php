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
class Loanstatus_Model_loanstatus extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

	public function fetchAllStatus($accountStatusId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_record_status'),array('recordstatus_id'))
			->where('a.recordstatus_id = ?',$accountStatusId);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchloanStatusDetails($accountStatusId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_record_status'),array('recordstatus_id'))
			->where('a.recordstatus_id != ?',$accountStatusId)
			->where('a.recordstatus_id != 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function updatemainaccountstatus($account,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$account."'";
		$result = $this->db->update('ob_accounts',$input,$where);
	}

	public function updateloanaccountstatus($account,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$account."'";
		$result = $this->db->update('ob_loan_accounts',$input,$where);
	}
}
