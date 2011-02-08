<?php 
class settings_Model_Dropdown extends Zend_Db_Table 
{
     protected $_name='ourbank_master_gender';
    public function tableContent($tableName) 
    {        $select = $this->select()
                        ->setIntegrityCheck(false)
			->from(array('a' => $tableName));
       $result = $this->fetchAll($select);
       return $result->toArray();
     // die($select->__toString($select));
    }
    
    public function insertContent($tName,$input = array())
    {
       $db = $this->getAdapter();
	$db->insert("$tName",$input);
	return '1';
      
    }
public function getdetails($tName,$id) {
		 $select = $this->select()
                        ->setIntegrityCheck(false)
			->from(array('a' => $tName),array('id','name'))
			->where('a.id = ?',$id);

//die($select->__toString($select));


       $result = $this->fetchAll($select);
       return $result->toArray();
	}

}
    