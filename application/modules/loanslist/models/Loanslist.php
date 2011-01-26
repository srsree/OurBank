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
class Loanslist_Model_Loanslist extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

public function fetchAllloanlist() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_accounts'),array('account_id'))
			->where('a.accountstatus_id =1')
			->join(array('c' => 'ob_activity'),'c.id = a.activity_id',array('name'))
			->where('c.status =1')
 			->join(array('b' => 'ob_loan_accounts'),'b.account_id = a.account_id',array('sum(loan_amount) as Lamt','count(loan_amount) as NumberofAC'))
			->where('b.recordstatus_id = 1 or b.recordstatus_id=3')
 			->join(array('d' => 'ob_creditline'),'d.id = b.creditline_id',array('portfolio'))
 			->where('d.status = 1 or d.status=3')
// 			->where('c.recordstatus_id = 1 or c.recordstatus_id=3')
 			->group('c.name');
			//->order(array('account_id DESC'));
		$result = $this->fetchAll($select);
		return $result->toArray();
  //die($select->__toString($select));
	}
	
}
