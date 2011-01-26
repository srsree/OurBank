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
class Graceperiod_Model_Graceperiod extends Zend_Db_Table {
	protected $_name = 'ob_graceperiod';

	public function fetchgraceperiod() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a'=>'ob_graceperiod'),array('id'))
			->join(array('b'=>'ob_creditline'),'b.id = a.creditline_id',array('name as creditline_name'))
			->order(array('a.id desc'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	
	public function fetchgraceperiodforID($id) {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a'=>'ob_graceperiod'),array('id'))
			->where('a.id = '.$id)
			
			->join(array('b'=>'ob_creditline'),'b.id = a.creditline_id',array('name as creditline_name'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	
	public function SearchGraceperiod($post) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a'=>'ob_graceperiod'),array('id'))
			->where('a.name like "%" ? "%"',$post['search_gracename'])
			->where('a.days like "%" ? "%"',$post['search_days'])
			->where('a.creditline_id like "%" ? "%" ',$post['search_credit_grace'])
			->join(array('b'=>'ob_creditline'),'b.id = a.creditline_id',array('name as creditline_name'));		
		$result = $this->fetchAll($select);
               return $result->toArray();
	}
}
