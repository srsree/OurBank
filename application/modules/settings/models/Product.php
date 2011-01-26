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
class Management_Model_Product extends Zend_Db_Table {
    protected $_name = 'ourbank_productdetails';
    public function fetchAllProductDetails() {
           $select = $this->select()
                          ->setIntegrityCheck(false)  
                          ->join(array('p' => 'ourbank_productdetails'),array('category_id'))
                          ->where('p.recordstatus_id = 3')
                          ->join(array('c'=>'ourbank_categorydetails'),'p.category_id = c.category_id')
                          ->where('c.recordstatus_id = 3');
           $result = $this->fetchAll($select);
           return $result->toArray();
    }

    public function ProductDetails() {
           $select = $this->select()
                          ->setIntegrityCheck(false)  
                          ->join(array('p' => 'ourbank_productdetails'),array('category_id'))
                          ->where('p.category_id = 2')
                          ->where('p.recordstatus_id = 3');
           $result = $this->fetchAll($select);
           return $result->toArray();
    }

    public function ProductDetailsInsurance() {
           $select = $this->select()
                          ->setIntegrityCheck(false)  
                          ->join(array('p' => 'ourbank_productdetails'),array('category_id'))
                          ->where('p.category_id = 3')
                          ->where('p.recordstatus_id = 3');
           $result = $this->fetchAll($select);
           return $result->toArray();
    }

    public function ProductDetailsSaving() {
           $select = $this->select()
                          ->setIntegrityCheck(false)  
                          ->join(array('p' => 'ourbank_productdetails'),array('category_id'))
                          ->where('p.category_id = 1')
                          ->where('p.recordstatus_id = 3');
           $result = $this->fetchAll($select);
           return $result->toArray();
    }

    public function viewProduct($product_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productdetails'),array('product_id'))
                       ->where('a.product_id = ?',$product_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_categorydetails'),'a.category_id = b.category_id')
                       ->where('b.recordstatus_id = 3');;
        $result = $this->fetchAll($select);
        return $result->toArray();
        }
}
