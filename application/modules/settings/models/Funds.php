<?php 
class Management_Model_Funds extends Zend_Db_Table_Abstract
{
    protected $_name='jobs';
    public function getJobsData()
    {
        $select = $this->_db->select()
                        ->from($this->_name);
        $results = $this->getAdapter()->fetchAll($select);
        return $results;
    }
}
