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
	
	public function addInterestDetails($post,$interest_id,$startRange,$endRange,$interestRates,$fee_rates,$interestBillet,$created_by,$table) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array(	'id'=>$interest_id,
					'name'=>$post['interestname'],
					'creditline_id'=>$post['creditlinename'],
					'start_range'=>$startRange,
					'end_range'=>$endRange,
					'rate'=>$interestRates,
					'fee'=> $fee_rates,
					'ballet'=> $interestBillet,
					'status' => $post['status'],
					'created_by'=> $created_by);
		$this->db->insert($table,$data);
	}


	public function fetchAllinterestdetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a'=>'ob_interest_rates'),array('id'))
			->join(array('b'=>'ob_creditline'),'a.creditline_id = b.id',array('name as creditline_name'))
			->order(array('a.id DESC'))
			->order(array('a.start_range ASC'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchinterestdetailsforID($id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a'=>'ob_interest_rates'),array('id'))
			->where('a.id = '.$id)
			->join(array('b'=>'ob_creditline'),'a.creditline_id = b.id',array('name as creditline_name'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchinterestforcreditlineID($creditline_id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_interest_rates')
			->where('creditline_id = '.$creditline_id);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	
	public function SearchInterestrates($post) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a'=>'ob_interest_rates'),array('id'))
			->where('a.name like "%" ? "%"',$post['search_interest_name'])
			->join(array('b'=>'ob_creditline'),'a.creditline_id = b.id',array('name as creditline_name'))
			->where('b.id like "%" ? "%"',$post['search_credit_interest']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
}
