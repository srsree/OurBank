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
class Loandetails_Model_loandetails extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

	public function loanInstalments($accountId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ob_installmentdetails'),array('Installmentserial_id'))
			->where('A.account_id = ?',$accountId)
			->where('A.recordstatus_id = 3 OR A.recordstatus_id =1')
			->join(array('B' => 'ob_installmentstatus'),'A.installment_status=B.installmentstatus_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
}
