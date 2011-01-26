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
class Enquiry_Model_Repaymentgroup extends Zend_Db_Table
{
protected $_name = 'ourbank_productsofferdetails';

    public function fetchloanDetails()
    {
        $sql = $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->from(array('A' => 'ourbank_groupaddress'), array('groupname'))
                                ->join(array('B'=>'ourbank_members'),'A.group_id = B.member_id')
                                ->where('A.recordstatus_id =3')
                                ->where('B.member_status = 3')
                                ->join(array('C' =>'ourbank_accounts'),'C.member_id = B.member_id','account_number')
                                ->join(array('D'=>'ourbank_officenames'),'D.office_id = B.memberbranch_id','office_name')
                                ->where('D.recordstatus_id =3')
                                ->join(array('E'=>'ourbank_groupmemberloan_disbursement'),'E.groupaccount_id = C.account_id','groupmember_loanamount')
                                ->join(array('F'=>'ourbank_groupmemberloan_repayment'),'F.groupaccount_id = C.account_id',array('groupmemberloaninstallmentpaid_date','groupmemberloaninstallmentpaid_amount'))
                                ->group('A.groupname');
                 // die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
    
    }


}