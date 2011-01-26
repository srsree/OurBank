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
class Loanactivitywise_Model_Loanactivitywise extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

		public function loanaccountname(){
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','activity_id'))
			->where('a.accountstatus_id = 1')
 			->join(array('b' => 'ob_member_details'),'b.member_id = a.member_id')
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3')
  			->join(array('c' => 'ob_activity_details'),'c.activity_id = a.activity_id',array('activity_name'))
			->where('c.recordstatus_id = 1 or c.recordstatus_id =3')
			->join(array('d' => 'ob_loan_accounts'),'d.account_id = a.account_id')
			->where('d.recordstatus_id = 1 or d.recordstatus_id = 3')
// 			->group('c.activity_name')
			->group('a.account_id');
 //die($select->__toString($select));
 		$result = $this->fetchAll($select);
  		return $result->toArray();

	}


}
