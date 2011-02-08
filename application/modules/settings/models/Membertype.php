<?php
class Management_Model_Membertype extends Zend_Db_Table {
     protected $_name = 'ourbank_membertypes';
        public function getMembertypeDetails() {
        $result = $this->fetchAll();
        return $result;
        }
     
}
