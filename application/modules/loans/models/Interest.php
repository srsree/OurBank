<?php
class Loans_Model_Interest extends Zend_Db_Table {
    protected $_name = 'ourbank_interest_periods';

    public function Addinterestdetails($From,$To,$Rate,$period_ofrange_description,$offerproduct_id) {
        $data = array(
                    'id'=>'',
                    'period_ofrange_monthfrom'=>$From,
                    'period_ofrange_monthto'=>$To,
                    'period_ofrange_description'=>$period_ofrange_description,
                    'offerproduct_id'=> $offerproduct_id,
                    'Interest'=>$Rate,
                    'intereststatus_id'=> 3);
        $this->insert($data);
    }

    public function Getinterestdetail($offerproduct_id) {
        $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ourbank_interest_periods'),array('id'))
                    ->where('a.offerproduct_id = ?',$offerproduct_id);
//         die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
}
}
