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
class Outstanding_Model_outstanding extends Zend_Db_Table
{
protected $_name = 'ob_member';

    public function loanSearchh($bankname,$activity,$credit_id,$month,$year)
    {
           $select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a'=>'ob_member'),array('a.id'),array('a.member_name'))
                        ->join(array('b'=>'ob_bank'),'b.id=a.bank_id',array('b.id'))
			->where('b.id like "%" ? "%"',$bankname)
			->join(array('c'=>'ob_accounts'),'c.member_id=a.id',array('account_number'))
                        ->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
			->where('c.creditline_id like "%" ? "%"',$credit_id)
			->join(array('d'=>'ob_loan_accounts'),'d.account_id=c.account_id',array('d.loan_amount'))
			->where('d.loanstatus_id = 3 || d.loanstatus_id = 1')
			->join(array('e'=>'ob_installmentdetails'),'e.account_id=c.account_id',array('SUM(e.accountinstallment_amount)'))
			->where('e.installment_status != 2')
			->where('MONTH(e.accountinstallment_date) like "%" ? "%"',$month)
			->where('YEAR(e.accountinstallment_date) like "%" ? "%"',$year)
			->group('c.account_number')
			->join(array('f'=>'ob_activity'),'f.id=c.activity_id')
			->where('f.id like "%" ? "%"',$activity);
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
                        die($select->__toString($select));
    }

      public function getbankname($bankname)
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_bank'),array('id'),array('a.name'))
			->where('a.id=?',$bankname);;
           return $result = $this->fetchAll($select);
              //          die($select->__toString($select));
    }

    public function getActivity()
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_activity'),array('a.id'),array('a.name','a.id'));
                        return $result = $this->fetchAll($select);
                        die($select->__toString($select));
    }

      public function getcreditline()
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_creditline'),array('a.id '),array('a.name','a.id'));
                        return $result = $this->fetchAll($select);
                        die($select->__toString($select));
    }

       public function getcreditname($credit_id)
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_creditline'),array('a.id '),array('a.name','a.id'))
			->where('a.id=?',$credit_id);
                        return $result = $this->fetchAll($select);
                        die($select->__toString($select));
    }

    public function getactivityname($activity)
    { 
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_activity'),array('a.id'),array('a.name'))
			->where('a.id = ?',$activity);
                       return $result = $this->fetchAll($select);
                       // die($select->__toString($select));
    }
}
