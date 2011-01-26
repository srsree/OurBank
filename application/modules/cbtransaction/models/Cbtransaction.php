<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php 
		class Cbtransaction_Model_Cbtransaction extends Zend_Db_Table { 
 			protected $_name = 'ob_accounts';

 
public function getbankNames() 
		{
         		$select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_institution')
			->where('recordstatus_id=3');
        		return $result = $this->fetchAll($select);
      // die ($select->__toString($select));

    		}
 public function Searchbanktransaction($accountnumber,$date1,$date2,$bank) 
		{


        		$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
        		->where('a.transaction_date >= "'.$date1.'"  AND a.transaction_date <= "'.$date2.'"')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->where('b.account_number="'.$accountnumber.'"')
			->join(array('c'=>'ob_member'),'b.member_id=c.id AND c.bank_id="'.$bank.'"')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));
			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}

public function Searchnullaccounttransaction($bank,$date1,$date2) 
		{


        		$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
        		->where('a.transaction_date >= "'.$date1.'"  AND a.transaction_date <= "'.$date2.'"')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->join(array('c'=>'ob_member'),'b.member_id=c.id AND c.bank_id="'.$bank.'"')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}
 public function Searchbankdatetransaction($date1,$date2) 
		{


        		$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
			->where('a.transaction_date >= "'.$date1.'"  AND a.transaction_date <= "'.$date2.'"')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->join(array('c'=>'ob_member'),'b.member_id=c.id')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}
public function Searchbankwisetransaction($bank) 
		{


        		$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->join(array('c'=>'ob_member'),'b.member_id=c.id AND c.bank_id="'.$bank.'"')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}
public function Searchaccounttransaction($accountnumber) 
		{


        		$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->where('b.account_number="'.$accountnumber.'"')
			->join(array('c'=>'ob_member'),'b.member_id=c.id')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}

public function Searchaccountdatetransaction($accountnumber,$date1,$date2) 
		{


			$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
			->where('a.transaction_date >= "'.$date1.'"  AND a.transaction_date <= "'.$date2.'"')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->where('b.account_number="'.$accountnumber.'"')
			->join(array('c'=>'ob_member'),'b.member_id=c.id')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));
			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}
public function Searchbankacctransaction($accountnumber,$bank) 
		{


			$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')
			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id ')
			->where('b.account_number="'.$accountnumber.'"')
			->join(array('c'=>'ob_member'),'b.member_id=c.id AND c.bank_id="'.$bank.'"')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			
			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();
    		}
public function Searchemptybanktransaction() 
		{
	$select = $this->select()
        		->setIntegrityCheck(false)  
        		->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')

			->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
			->join(array('c'=>'ob_member'),'b.member_id=c.id')
			->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
			->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

			
			//die($select->__toString());
       	 		$result = $this->fetchAll($select);
        		return $result->toArray();

    		}


}