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
class Penalty_Model_Penalty extends Zend_Db_Table {
	protected $_name = 'ob_penalty_details';
	
	public function insertpenalty($post) {
		$data = array('penalty_id'=> '',
					'creditline_id' => $post['creditlinename'],
					'penalty_name'=>$post['penaltyname'],
					'penalty_description'=> 'Description',
					'penalty_per_month'=>$post['penalty_per_month'],
					'penalty_per_day'=>$post['penalty_per_day'],
					'unitPenalty_per_month'=>$post['unit_per_month'],
					'unitPenalty_per_day'=>$post['unit_per_day'],
					'penalty_status'=>$post['status'],
					'created_by' => 'adimin',
					'created_date' => date('Y-m-d'),
					'recordstatus_id'=>3);
		$this->insert($data);
	}
// 	public function fetchAllpenaltydetails() {
// 		$select = $this->select()
// 			->where('recordstatus_id = 3');
// 		$result = $this->fetchAll($select);
// 		return $result->toArray();
// 	}
// 	public function fetchpenaltydetailsforID($penalty_id) {
// 		$select = $this->select()
// 			->where('recordstatus_id = 3')
// 			->where('penalty_id = '.$penalty_id);
// 		$result = $this->fetchAll($select);
// 		return $result->toArray();
// 	}
// 
// 	public function fetchpenaltydetailsforCrditlineID($creditline_id) {
// 		$select = $this->select()
// 			->where('recordstatus_id = 3')
// 			->where('creditline_id = '.$creditline_id);
// 		$result = $this->fetchAll($select);
// 		return $result->toArray();
// 	}
// 
// 	public function updatePenalty($penalty_id,$post) {
// 		
// 		$where = 'penalty_id = '.$penalty_id;
// 		$this->update($post , $where );
// 	}
// 	
// 	public function deletepenaltyinfo($penalty_id) {
// 		$post = array('recordstatus_id' => 5);
// 		$where = 'penalty_id = '.$penalty_id;
// 		$this->update($post , $where );
// 	}
}
