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

class Reports_Model_Loandue extends Zend_Db_Table
{
protected $_name = 'ourbank_installmentdetails';

    public function getUser()
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_userloginupdates where recordstatus_id = 3';
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function loanSearchh($fromDate,$toDate)
    {
           $select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a'=>'ourbank_installmentdetails'),array('Installmentserial_id'))
                        ->where('a.accountinstallment_date >= "'.$fromDate.'"  AND a.accountinstallment_date <= "'.$toDate.'"')
                        ->where('a.installment_status=5 || a.installment_status=4')
                        ->join(array('b'=>'ourbank_loanaccounts'),'b.account_id=a.account_id',array('loanaccount_id'))
                        ->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')
                        ->join(array('c'=>'ourbank_accounts'),'c.account_id=b.account_id',array('account_number'))
                        ->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
                        ->join(array('d'=>'ourbank_members'),'d.member_id=c.member_id',array('member_id'))
                        ->join(array('e'=>'ourbank_officenames'),'e.office_id=d.memberbranch_id',array('officeupdates_id'))
                        ->where('e.recordstatus_id = 3 || e.recordstatus_id = 1')
                        ->join(array('f'=>'ourbank_membername'),'f.member_id=d.member_id',array('membername_id'))
                        ->where('f.recordstatus_id=3')
                        ->join(array('g'=>'ourbank_memberaddress'),'g.member_id=f.member_id',array('memberaddress_id'))
                        ->where('g.recordstatus_id=3');
                        $result = $this->fetchAll($select);
                        return $result->toArray();
                	die($select->__toString($select));
   }


    public function loanSearhb($brancId,$fromDate,$toDate)
    {
           $select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a'=>'ourbank_installmentdetails'),array('Installmentserial_id'))
                        ->where('a.accountinstallment_date >= "'.$fromDate.'"  AND a.accountinstallment_date <= "'.$toDate.'"')
                        ->where('a.installment_status=5 || a.installment_status=4')
                        ->join(array('b'=>'ourbank_loanaccounts'),'b.account_id=a.account_id',array('loanaccount_id'))
                        ->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')
                        ->join(array('c'=>'ourbank_accounts'),'c.account_id=b.account_id',array('account_number'))
                        ->where('c.accountstatus_id = 3 || c.accountstatus_id = 1')
                        ->join(array('d'=>'ourbank_members'),'d.member_id=c.member_id',array('member_id'))
                        ->join(array('e'=>'ourbank_officenames'),'e.office_id=d.memberbranch_id',array('officetype_id'))
                        ->where('e.recordstatus_id = 3 || e.recordstatus_id = 1')
                        ->where('e.officetype_id=?',$brancId)
                        ->join(array('f'=>'ourbank_membername'),'f.member_id=d.member_id',array('membername_id'))
                        ->where('f.recordstatus_id=3')
                        ->join(array('g'=>'ourbank_memberaddress'),'g.member_id=f.member_id',array('memberaddress_id'))
                        ->where('g.recordstatus_id=3');
                        $result = $this->fetchAll($select);
                        return $result->toArray();
                	die($select->__toString($select));
     }

     public function find_name($branch)
    {
           $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ourbank_officenames'),array('office_id'),'office_name')
                        ->where('recordstatus_id = 3 OR recordstatus_id = 1')
                        ->where('office_id=?',$branch);
                        return $result = $this->fetchAll($select);
                        die($select->__toString($select));
    }
 
}
