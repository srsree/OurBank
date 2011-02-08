<?php
class Management_Model_Roles extends Zend_Db_Table {
     protected $_name = 'ourbank_grant';

     public function getRoleDetails() {
        $result = $this->fetchAll( "recordstatus_id = '3'"  );
        return $result;
        }


}
