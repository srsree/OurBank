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
class Cbmonthlytransaction_Model_Cbmonthlytransaction extends Zend_Db_Table { 
 protected $_name = 'ob_accounts';

 
public function getbankNames() {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_institute_bank_details');
        return $result = $this->fetchAll($select);
      // die ($select->__toString($select));

    }
 public function Searchmonthlybanktransaction($month,$year,$bank) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ob_transaction'),array('account_id'))
        ->where('MONTH(a.transaction_date)= "'.$month.'" AND YEAR(a.transaction_date)="'.$year.'"')
			->where('a.recordstatus_id=3')

	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c.member_id AND c.bank_id="'.$bank.'"')
	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
 public function Searchbanktransaction($bank) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ob_transaction'),array('account_id'))
			->where('a.recordstatus_id=3')

	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c.member_id AND c.bank_id="'.$bank.'"')

	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))

	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));


        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
 public function Searchyearbanktransaction($year,$bank) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ob_transaction'),array('account_id'))
        ->where('YEAR(a.transaction_date)="'.$year.'"')
			->where('a.recordstatus_id=3')
	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c.member_id AND c.bank_id="'.$bank.'"')
	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
public function Searchmonthyearbanktransaction($year,$month) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ob_transaction'),array('account_id'))
        ->where('MONTH(a.transaction_date)= "'.$month.'" AND YEAR(a.transaction_date)="'.$year.'"')
			->where('a.recordstatus_id=3')
	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c.id')
	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
public function Searchyearlybanktransaction($year) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ob_transaction'),array('account_id'))
        ->where('YEAR(a.transaction_date)="'.$year.'"')
			->where('a.recordstatus_id=3')

	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c.id')

	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));

        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
 public function Searchalltransaction() {
        $select = $this->select()
        ->setIntegrityCheck(false)  
	->join(array('a' => 'ob_transaction'),array('account_id'))
	->where('a.recordstatus_id=3')
	->join(array('b'=>'ob_accounts'),'a.account_id=b.account_id')
	->join(array('c'=>'ob_member'),'b.member_id=c._id')
	->join(array('d'=>'ob_institution'),'d.id=c.bank_id',array('name as bankname'))
	->join(array('e'=>'ob_activity'),'e.id=b.activity_id',array('e.name as activityname'));


        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

}