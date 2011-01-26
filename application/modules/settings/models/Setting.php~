<?php 
class settings_Model_Setting extends Zend_Db_Table 
{ 
     protected $_name='ourbank_language'; 
    public function fetchAllLanguage() 
    {
        $select = $this->select()
			->join(array('a' => 'ourbank_language'),array('language_id'))
			->order(array('language_id'));
          $result = $this->fetchAll($select);
          return $result->toArray();
     //  die($select->__toString($select));
//         $this->db = Zend_Db_Table::getDefaultAdapter();
//         $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
//         $result = $this->db->fetchAll('SELECT * FROM ourbank_language ORDER BY language_id');
//         return $result;
    }
}