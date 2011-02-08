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
