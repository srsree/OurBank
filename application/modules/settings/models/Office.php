<?php
class Management_Model_Office extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_officenames';

    public function getOffice() {
        $result = $this->fetchAll("recordstatus_id = '3'");
        return $result->toArray();
    }

    public function viewOffice() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_officenames'),array('a.office_name,a.officeshort_name'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_officeaddress'),'a.office_id = b.office_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_officehierarchy'),'a.officetype_id = c.officetype_id','c.officetype');
       //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function SearchOffice($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_officenames'),array('officeupdates_id'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.office_name like "%" ? "%"',$post['field2'])
                       ->where('a.officeshort_name like "%" ? "%"',$post['field2'])
                       ->join(array('b'=>'ourbank_officeaddress'),'a.office_id = b.office_id')
                       ->where('b.recordstatus_id = 3')
                       ->where('b.officecity like "%" ? "%"',$post['field3'])
                       ->join(array('c'=>'ourbank_officehierarchy'),'a.officetype_id = c.officetype_id','c.officetype')
                       ->where('c.officetype like "%" ? "%"',$post['field4']);

       $result = $this->fetchAll($select);
       return $result->toArray();
    }



}
