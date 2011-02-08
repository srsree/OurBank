<?php
class Management_Model_holiday extends Zend_Db_Table_Abstract {
     protected $_name = 'ourbank_holiday';

     public function addHoliday() {
            $data = array('holiday_id'=> '');
            $this->insert($data);

       }
}