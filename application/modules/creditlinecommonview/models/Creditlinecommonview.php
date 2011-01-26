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
class Creditline_Model_Creditline extends Zend_Db_Table {
	protected $_name = 'ourbank_creditline1';



	public function insertCreditline($post) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('creditline_id'=> '',
					'name'=>$post['creditlinename'],
					'protfolio_value'=>$post['portfoliovalue'],
					'start_date'=>$post['creditline_beginingdate'],
					'end_date'=>$post['creditline_closingdate'],
					'status'=>$post['status'],
					'recordstatus_id'=>3);
		$this->db->insert('ourbank_creditline1',$data);
	}

	public function fetchAllcreditlinedetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ourbank_creditline1')
			->where('recordstatus_id = 3');

		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchCreditline($creditline_id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ourbank_creditline1')
			->where('recordstatus_id = 3')
			->where('creditline_id = '.$creditline_id);
			

		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function updateCreditline($creditline_id,$post) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where = 'creditline_id = '.$creditline_id;
		$this->db->update('ourbank_creditline1',$post , $where );
	}

	public function deletecreditlineinfo($creditline_id) {
	$this->db = Zend_Db_Table::getDefaultAdapter();
		$post = array('recordstatus_id' => 2);
		$where = 'creditline_id = '.$creditline_id;
		$this->db->update('ourbank_creditline1',$post , $where );
	}
}
