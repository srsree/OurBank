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
class Meeting_Model_Meeting extends Zend_Db_Table {
	protected $_name = 'ob_meeting';


// 	public function insertCreditlineID($creditline_id) {
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$this->db->insert('ob_creditline',$creditline_id);
// 		$result = $this->db->lastInsertId('creditline_id');
// 		return $result;
// 	}
// 
	public function addmeetings($post) {
		
		$data = array('meeting_id'=> '',
					'meeting_name'=>$post['meeting_name'],
					'office_type'=> 'hi',
					'meeting_group_name'=>$post['group_name'],
					'meeting_group_head'=>$post['group_head'],
					'meeting_place'=>$post['meeting_place'],
					'meeting_time' => $post['meeting_time'],
					'meeting_day' => $post['meeting_day'],
					'created_by' => 'admin',
					'created_date' => date('Y-m-d'),
					'recordstatus_id'=>3);
		$this->insert($data);
	}

	public function fetchAllmeetingdetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_meeting')
			->where('recordstatus_id = 3');
// 			->order(array('creditline_id DESC'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getGroupname() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_member_details')
			->where('recordstatus_id = 3')
			->where('member_type = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

		
	public function getDays() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_weekdays');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

// 	public function fetchCreditline($creditline_id) {
// 		$select = $this->select()
// 			->setIntegrityCheck(false)
// 			->from('ob_creditline_details')
// 			->where('recordstatus_id = 3')
// 			->where('creditline_id = '.$creditline_id);
// 		$result = $this->fetchAll($select);
// 		return $result->toArray();
// 	}
// 
// 	public function updateCreditline($creditline_id,$post) {
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$where = 'creditline_id = '.$creditline_id;
// 		$this->db->update('ob_creditline_details',$post , $where );
// 	}
// 
// 	public function deletecreditlineinfo($creditline_id) {
// 	$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$post = array('recordstatus_id' => 5);
// 		$where = 'creditline_id = '.$creditline_id;
// 		$this->db->update('ob_creditline_details',$post , $where );
// 	}
// 
	public function SearchMeeting($post) {
               $select = $this->select()
			->setIntegrityCheck(false)  
			->from('ob_meeting')
			->where('recordstatus_id = 3')
			->where('meeting_name like "%" ? "%"',$post['field2']);
			
               $result = $this->fetchAll($select);
               return $result->toArray();
       }
}
