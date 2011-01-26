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
class Enquiry_Model_LoanoutstandingDetails extends Zend_Db_Table_Abstract 
{
protected $_name = 'ourbank_officenames'; 

 public function fetchAllOffice()  {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_officenames')
                        ->where('recordstatus_id=3');
            //die($select->__toString());
            return $this->fetchAll($select);
    }

public function loanSearch($fromDate,$toDate,$brancId)  {
$select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_installmentdetails'),array('a.accountinstallment_date'))
                       ->where('a.accountinstallment_date >= "'.$fromDate.'" AND a.accountinstallment_date <= "'.$toDate.'"')
                       ->join(array('b' => 'ourbank_loanaccounts'),'a.account_id = b.account_id')
                       ->join(array('c' => 'ourbank_accounts'),'b.account_id = c.account_id')
                       ->join(array('d' => 'ourbank_members'),'d.member_id = c.member_id')
                       ->join(array('e' => 'ourbank_officenames'),'e.office_id = d.memberbranch_id')
                       ->where('e.recordstatus_id = 3')
                       ->where('e.office_id = ?',$brancId)
                       ->join(array('f' => 'ourbank_membername'),'f.member_id = d.member_id')
                       ->where('f.recordstatus_id=3')
                       ->join(array('g' => 'ourbank_memberaddress'),'g.member_id = f.member_id');
          //die($select->__toString());
       return $this->fetchAll($select);
    }
}

