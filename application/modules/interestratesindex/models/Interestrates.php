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
class Interestrates_Model_Interestrates extends Zend_Db_Table {
	protected $_name = 'ob_interest_rates';


	public function addActivityId($input = array()) {  
               $this->db = Zend_Db_Table::getDefaultAdapter();
               $this->db->insert('ob_interest_rates',$input);
               $result = $this->db->lastInsertId('interest_id');
               return $result;
       }

	
	public function insertinterest($post,$interest_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('interest_id'=> $interest_id,
					'Interest_name'=>$post['interestname'],
					'creditline_id'=>$post['creditlinename'],
					'Interest_start_range'=>$post['start_range'],
					'Interest_end_range'=>$post['end_range'],
					'interest'=>$post['interest'],
					'created_by'=>'admin',
					'created_date' => date('Y-m-d'),
					'recordstatus_id'=>3);
		$this->db->insert('ob_interest_rates_details',$data);
	}
	public function fetchAllinterestdetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_interest_rates_details')
			->where('recordstatus_id = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	public function fetchinterestdetailsforID($interest_id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_interest_rates_details')
			->where('recordstatus_id = 3')
			->where('interest_id = '.$interest_id);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchinterestforcreditlineID($creditline_id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_interest_rates_details')
			->where('recordstatus_id = 3')
			->where('creditline_id = '.$creditline_id);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function updateInterestrates($interest_id,$post) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where = 'interest_id = '.$interest_id;
		$this->db->update('ob_interest_rates_details',$post , $where );
	}
	
	public function deleteinterestinfo($interest_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$post = array('recordstatus_id' => 5);
		$where = 'interest_id = '.$interest_id;
		$this->db->update('ob_interest_rates_details',$post , $where );
	}

	public function SearchInterestrates($post) {
               $select = $this->select()
			->setIntegrityCheck(false)  
			->from('ob_interest_rates_details')
			->where('recordstatus_id = 3')
			->where('Interest_name like "%" ? "%"',$post['field2'])
			->where('Interest_start_range >= ?',$post['field3'])
			->where('Interest_end_range <= ?',$post['field4']);
               $result = $this->fetchAll($select);
               return $result->toArray();
       }
}
