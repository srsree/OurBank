<?php
class Management_Model_categoryi extends Zend_Db_Table_Abstract {
     protected $_name = 'ourbank_category';

     public function addCategoryi() {
            $data = array('category_id'=> '');
            $this->insert($data);

       }
    

}
