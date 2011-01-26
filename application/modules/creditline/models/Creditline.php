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
	protected $_name = 'ob_creditline';


	public function SearchCreditline($post) {

		$convertdate = new Creditline_Model_dateConvertor();

		if($post['searchCreditline'] && $post['search_from_credit'] && $post['search_to_credit']) {
			$search_from_credit=$convertdate->phpmysqlformat($post['search_from_credit']);
			$search_to_credit=$convertdate->phpmysqlformat($post['search_to_credit']);
			$select = $this->select()
					->setIntegrityCheck(false)  
					->from('ob_creditline')
					
					->where('name like "%" ? "%" ',$post['searchCreditline'])
					->where('start_date >="'. $search_from_credit.'" AND end_date <= "'.$search_to_credit.'"');
			$result = $this->fetchAll($select);
			return $result->toArray();
		}
		if(!$post['searchCreditline'] && !$post['search_from_credit'] && !$post['search_to_credit']) {
			$select = $this->select()
				->setIntegrityCheck(false)
				->from('ob_creditline')
				
				->order(array('id DESC'));
			$result = $this->fetchAll($select);
			return $result->toArray();
		}
		if($post['searchCreditline'] && !$post['search_from_credit'] && !$post['search_to_credit']) {
			$select = $this->select()
				->setIntegrityCheck(false)  
				->from('ob_creditline')
				
				->where('name like "%" ? "%" ',$post['searchCreditline']);
			$result = $this->fetchAll($select);
			return $result->toArray();
		}
		if(!$post['searchCreditline'] && $post['search_from_credit'] && $post['search_to_credit']) {
			$search_from_credit=$convertdate->phpmysqlformat($post['search_from_credit']);
		$search_to_credit=$convertdate->phpmysqlformat($post['search_to_credit']);
			$select = $this->select()
				->setIntegrityCheck(false)  
				->from('ob_creditline')
				
				->where('start_date >="'. $search_from_credit.'" AND end_date <= "'.$search_to_credit.'"');
			$result = $this->fetchAll($select);
			return $result->toArray();
		}
       }
}
