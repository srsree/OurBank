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
class Loandisbursereport_Model_Loandisbursereport extends Zend_Db_Table {
	protected $_name = 'ob_meeting';
	
	public function getLoanDisburseall($creditline_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  

			->join(array('a'=>'ob_loan_disbursement'),array('SUM(amount_disbursed) as amount_disbursed'))
			->where('a.recordstatus_id = 3')
			//->group('a.amount_disbursed')

			->join(array('b'=>'ob_accounts'),'a.account_id = b.account_id')
			->where('b.creditline_id = '.$creditline_id)
			->where('b.accountstatus_id  = 3 OR b.accountstatus_id  = 1')
// 			->group('b.activity_id')
			
			->join(array('c'=>'ob_creditline_details'),'c.creditline_id = b.creditline_id',array('creditline_id','creditline_name','creditline_portfolio'))
			->where('c.recordstatus_id = 3');

// 			->join(array('d'=>'ob_activity_details'),'d.activity_id = b.activity_id',array('activity_id','sector_id'))
// 			->where('d.recordstatus_id = 1')
// 
// 			->join(array('e'=>'ob_sector_details'),'e.sector_id = d.sector_id',array('sector_id','sector_name'))
// 			->where('e.recordstatus_id = 1');
// // 			/*->group('a.transaction_id')*/;
			
// 				die($select->__toString($select));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	
	public function SearchPenalty($post) {
               $select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_penalty_details')
			->where('recordstatus_id = 3')
			->where('penalty_name like "%" ? "%"',$post['field2'])
			->where('penalty_per_month >= ?',$post['field3'])
			->where('penalty_per_day >= ?',$post['field4']);
               $result = $this->fetchAll($select);
               return $result->toArray();
       }
}
