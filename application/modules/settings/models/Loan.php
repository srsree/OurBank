<?php
class Management_Model_Loan extends Zend_Db_Table {
     protected $_name = 'ourbank_productsofferdetails';

    public function getLoan() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                       ->where('c.category_id = 2')
                       ->where('c.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function getSaving() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                       ->where('c.category_id = 1')
                       ->where('c.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function getInsurance() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                       ->where('c.category_id = 3')
                       ->where('c.recordstatus_id = 3');
                        //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function viewLoan($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id') 
                       ->join(array('c' => 'ourbank_membertypes'),'c.membertype_id = a.applicableto')
                       ->join(array('d' => 'ourbank_glsubcodeupdates'),'d.glsubcode_id = a.capital_glsubcode_id')
                       ->join(array('e' => 'ourbank_glsubcode'),'e.glsubcode_id = d.glsubcode_id')
                       ->join(array('f' => 'ourbank_productdetails'),'f.product_id = a.product_id')
                       ->where('f.recordstatus_id = 3')
                       ->where('d.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function viewLoan1($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productfee'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->join(array('c' => 'ourbank_feedetails'),'b.fee_id = c.fee_id')
                       ->where('b.feestatus_id = 3')
                       ->where('c.recordstatus_id = 3');
        $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function viewLoan2($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productfund'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->join(array('c' => 'ourbank_funderdetails'),'b.fund_id = c.funder_id')
                       ->where('b.fundstatus_id = 3')
                       ->where('c.recordstatus_id = 3');
        $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function viewLoan3($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_interest_periods'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->where('b.intereststatus_id = 3');
        $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function viewLoan4($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_glsubcodeupdates'),'a.Interest_glsubcode_id = b.glsubcode_id')
                       ->join(array('c' => 'ourbank_glsubcode'),'b.glsubcode_id = c.glsubcode_id') 
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function viewLoan5($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_glsubcodeupdates'),'a.fee_glsubcode_id = b.glsubcode_id')
                       ->join(array('c' => 'ourbank_glsubcode'),'b.glsubcode_id = c.glsubcode_id') 
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function editloan($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productfee'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->where('b.feestatus_id = 3');
                        //die($select->__toString());

       $result = $this->fetchAll($select);
       return $result;
        }


}
