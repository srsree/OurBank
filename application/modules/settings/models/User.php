<?php
class Management_Model_User extends Zend_Db_Table {
     protected $_name = 'ourbank_categorydetails';

     public function getUserDetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_usernamesupdates'),array('user_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_useraddressupdates'),'a.user_id = b.user_id')
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
        }

}
