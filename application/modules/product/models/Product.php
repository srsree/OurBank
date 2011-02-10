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
class Product_Model_Product extends Zend_Db_Table {
	protected $_name = 'ourbank_category';

	public function getCategoryDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_product'),array('a.id'))
						->join(array('b'=>'ourbank_category'),'a.category_id = b.id',array('b.name as categoryname') );

		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function getProductinformation() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ourbank_product'),array('id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
die($select->__toString($select));
	}

	public function viewCategory($category_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_category'),array('id'))
			->where('a.id = ?',$category_id);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getProduct($id) {
		$select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_product'),array('id'))
                ->where('a.id=?',$id)
			->join(array('b'=>'ourbank_category'),'a.category_id = b.id',array('b.name as categoryname') );

		// die($select->__toString($select));
        $result=$this->fetchAll($select);
        return $result->toArray();
	}

	

	public function SearchProduct($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_product'),array('id'))
			->where('a.name like "%" ? "%"',$post['name'])
			->where('a.description like "%" ? "%"',$post['description'])
			->where('a.category_id like "%" ? "%"',$post['category_id'])
			->where('a.shortname like "%" ? "%"',$post['shortname'])
			->join(array('b'=>'ourbank_category'),'a.category_id = b.id',array('b.name as categoryname') );

		$result = $this->fetchAll($select);
		return $result->toArray();
	}

                public function mysqlformat($nformat) {
                    $ndate = new Zend_Date($nformat, 'dd/mm/yyyy');
                   
                }
	
	



	
}
