<?php
class Management_Model_Glsubcode extends Zend_Db_Table {
     protected $_name = 'ourbank_glsubcodeupdates';


     public function getGlsubcode() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_glsubcodeupdates'),array('glsubcode_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_glsubcode'),'a.glsubcode_id = b.glsubcode_id');
                        //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }


     
}
