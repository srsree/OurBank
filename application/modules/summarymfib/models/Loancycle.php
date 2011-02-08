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
class Loancycles_Model_Loancycle extends Zend_Db_Table { 
 protected $_name = 'ob_accounts';

 
public function getbankNames() {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_institute_bank_details')
			->where('recordstatus_id=3 or recordstatus_id=1');
        return $result = $this->fetchAll($select);
      // die ($select->__toString($select));

    }
 public function Searchnullaccounttransaction($date1,$date2)
{
      $select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','account_id','account_number','count(account_number) as totac'))
		->join(array('b' => 'ob_member'),'a.member_id = b.id')
 		->join(array('c' => 'ob_loan_accounts'),'a.account_id = c.account_id')
 		->join(array('d' => 'ob_installmentdetails'),'d.account_id = c.account_id',array('SUM(d.accountinstallment_amount) as balance','d.accountinstallment_date'))
		->where('d.accountinstallment_date >= "'.$date1.'"  AND d.accountinstallment_date <= "'.$date2.'"')

		->join(array('e' => 'ob_loan_disbursement'),'e.account_id = d.account_id')
 		->join(array('f' => 'ob_loan_repayment'),'f.account_id = e.account_id')
		->order('b.id')
		->join(array('g' => 'ob_institution'),'g.id = b.bank_id',array('name as Institute_bank_name'))
		->group('a.account_id');
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
 public function Searchbanktransaction($bank) {
       
      
$select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','account_id','account_number','count(account_number) as totac'))
		->join(array('b' => 'ob_member'),'a.member_id = b.id')
 		->join(array('c' => 'ob_loan_accounts'),'a.account_id = c.account_id')
 		->join(array('d' => 'ob_installmentdetails'),'d.account_id = c.account_id',array('SUM(d.accountinstallment_amount) as balance','d.accountinstallment_date'))

		->join(array('e' => 'ob_loan_disbursement'),'e.account_id = d.account_id')
 		->join(array('f' => 'ob_loan_repayment'),'f.account_id = e.account_id')
		->order('b.id')
		->join(array('g' => 'ob_institution'),'g.id = "'.$bank.'"',array('name as Institute_bank_name'))
		->group('a.account_id');
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();


    }
 public function Searchyearbanktransaction($bank,$date1,$date2) {
      

$select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','account_id','account_number','count(account_number) as totac'))
		->join(array('b' => 'ob_member'),'a.member_id = b.id')
 		->join(array('c' => 'ob_loan_accounts'),'a.account_id = c.account_id')
 		->join(array('d' => 'ob_installmentdetails'),'d.account_id = c.account_id',array('SUM(d.accountinstallment_amount) as balance','d.accountinstallment_date'))
		->where('d.accountinstallment_date >= "'.$date1.'"  AND d.accountinstallment_date <= "'.$date2.'"')

		->join(array('e' => 'ob_loan_disbursement'),'e.account_id = d.account_id')
 		->join(array('f' => 'ob_loan_repayment'),'f.account_id = e.account_id')
		->order('b.id')
		->join(array('g' => 'ob_institution'),'g.id = "'.$bank.'"',array('name as Institute_bank_name'))
		->group('a.account_id');
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();

    }


 public function Searchalltransaction() {
       $select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_accounts'),array('account_id'),array('member_id','account_id','account_number','count(account_number) as totac'))
		->join(array('b' => 'ob_member'),'a.member_id = b.id')
 		->join(array('c' => 'ob_loan_accounts'),'a.account_id = c.account_id')
 		->join(array('d' => 'ob_installmentdetails'),'d.account_id = c.account_id',array('SUM(d.accountinstallment_amount) as balance','d.accountinstallment_date'))
		->join(array('e' => 'ob_loan_disbursement'),'e.account_id = d.account_id')
 		->join(array('f' => 'ob_loan_repayment'),'f.account_id = e.account_id')
		->order('b.id')
		->join(array('g' => 'ob_institution'),'g.id = b.bank_id',array('name as Institute_bank_name'))
		->group('a.account_id');
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

}