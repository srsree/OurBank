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
class Activityoutstanding_Model_activityoutstanding extends Zend_Db_Table
{
protected $_name = 'ob_installmentdetails';

    public function outstanding($brancId,$fromDate,$toDate)
    {
 	$select=$this->select()
		->setIntegrityCheck(false)
		->join(array('a'=>'ob_installmentdetails'),array('a.Installmentserial_id'),array('Sum(a.current_due) as outstanding'))
		->where('a.accountinstallment_date >= "'.$fromDate.'"  AND a.accountinstallment_date <= "'.$toDate.'"')
		->where('a.installment_status != 2')
		->join(array('b'=>'ob_loan_accounts'),'b.account_id=a.account_id',array('loanaccount_id'))
		->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')
		->join(array('c'=>'ob_accounts'),'c.account_id=b.account_id',('c.account_id'))
		->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
		->join(array('f'=>'ob_member'),'f.id=c.member_id',array('id'))
		->join(array('e'=>'ob_bank'),'e.id=f.bank_id',array('id'))
		->where('e.id=?',$brancId)
		->join(array('g'=>'ob_activity'),'g.id=c.activity_id',array('g.id','g.name'))
		->group('g.name');
		$result = $this->fetchAll($select);
		return $result->toArray();
		die($select->__toString($select));
    }

  public function disbursed($brancId,$fromDate,$toDate)
    {
 	$select=$this->select()
		->setIntegrityCheck(false)
		->join(array('a'=>'ob_loan_disbursement'),array('a.loandisbursement_id'),array('Sum(a.amount_disbursed) as disbursed'))
		->join(array('b'=>'ob_loan_accounts'),'b.account_id=a.account_id',array('loanaccount_id'))
		->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')
		->join(array('c'=>'ob_accounts'),'c.account_id=b.account_id',('c.account_id'))
		->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
		->join(array('f'=>'ob_member'),'f.id=c.member_id',array('id'))
		->join(array('e'=>'ob_bank'),'e.id=f.bank_id',array('id'))
		->where('e.id=?',$brancId)
		->join(array('g'=>'ob_activity'),'g.id=c.activity_id',array('g.id','g.name'))
		->group('g.name');
		$result = $this->fetchAll($select);
		return $result->toArray();
		die($select->__toString($select));
    }

  public function paid($brancId,$fromDate,$toDate)
    {
 	$select=$this->select()
		->setIntegrityCheck(false)
		->join(array('a'=>'ob_loan_repayment'),array('a.Installmentserial_id'),array('Sum(a.loaninstallmentpaid_amount) as paid'))
		->join(array('b'=>'ob_loan_accounts'),'b.account_id=a.account_id',array('loanaccount_id'))
		->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')
		->join(array('c'=>'ob_accounts'),'c.account_id=b.account_id',('c.account_id'))
		->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
		->join(array('f'=>'ob_member'),'f.id=c.member_id',array('id'))
		->join(array('e'=>'ob_bank'),'e.id=f.bank_id',array('id'))
		->where('e.id=?',$brancId)
		->join(array('g'=>'ob_activity'),'g.id=c.activity_id',array('g.id','g.name'))
		->group('g.name');
		
		$result = $this->fetchAll($select);
		return $result->toArray();
		die($select->__toString($select));
    }

     public function getBranchOffice()
    {
	$select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a'=>'ob_bank'),array('id'),array('a.name','a.id'));
		return $result = $this->fetchAll($select);
		//die($select->__toString($select));
    }

    public function getbank($branch)
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_bank'),array('id'),array('a.name','a.id'))
			->where('a.id=?',$branch);
                        return $result = $this->fetchAll($select);
                       // die($select->__toString($select));
    }
}
