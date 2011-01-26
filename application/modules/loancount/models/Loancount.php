<?php
class Loancount_Model_Loancount extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

	
	public function countofloanaccount(){

		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','count(account_number) as Account'))
			->group('a.member_id')
			->join(array('b' => 'ob_member'),'a.member_id = b.id');
		$result = $this->fetchAll($select);
		return $result->toArray();
		//die($select->__toString($select));
	}


}
