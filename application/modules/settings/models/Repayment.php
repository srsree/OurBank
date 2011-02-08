<?php
class Management_Model_Repayment extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_holidayrepayment';
    public function getRepayment() {
        $result = $this->fetchAll();
        return $result->toArray();
    }
}