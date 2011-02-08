<?php
class Management_Model_Fee extends Zend_Db_Table {
     protected $_name = 'ourbank_feedetails';


     public function getFeeDetails() {
        $result = $this->fetchAll( "recordstatus_id = '3'"  );
        return $result;
        }

}
