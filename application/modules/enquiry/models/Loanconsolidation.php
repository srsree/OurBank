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
class Enquiry_Model_Loanconsolidation extends Zend_Db_Table_Abstract {

protected $_name = 'ourbank_interest_periods'; 

    public function fetchloanDetails()
    {
           $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_interest_periods'),array('a.Interest'))
                       ->where('a.period_id =1')
                       ->join(array('b'=>'ourbank_productsofferdetails'),'b.offerproduct_id = a.offerproduct_id')
                       ->join(array('c'=>'ourbank_members'),'c.memberbranch_id = d.office_id')
                       ->join(array('d'=>'ourbank_officenames'),'d.office_id = a.period_id')
                       ->join(array('e'=>'ourbank_groupmemberloan_disbursement'),'e.groupaccount_id = f.account_id')
                       ->join(array('f'=>'ourbank_accounts'),'e.recordstatus_id = f.recordstatus_id')
                       ->group('f.account_number');
        //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
     }
// SELECT * FROM 
//                     ourbank_interest_periods A, 
//                     ourbank_productsofferdetails B,
//                     ourbank_members C, 
//                     ourbank_officenames D, 
//                     ourbank_groupmemberloan_disbursement E, 
//                     ourbank_accounts F
//                     WHERE A.offerproduct_id = B.offerproduct_id AND 
//                     C.memberbranch_id = D.office_id AND
//                     E.groupaccount_id = F.account_id AND
//                     A.period_id =1
//                     GROUP BY F.account_number

/*
    public function fetchPeriod()
    {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_interest_periods'),array('a.amount_disbursed ,a.officeshort_name'))
                       ->where('a.period_id =2')
                       ->join(array('b'=>'ourbank_productsofferdetails'),'b.offerproduct_id = a.offerproduct_id')
//                        ->join(array('c'=>'ourbank_members'),'c.memberbranch_id = d.office_id')
//                        ->join(array('d'=>'ourbank_officenames'),'b.product_id = c.offerproduct_id')
                       ->join(array('e'=>'ourbank_groupmemberloan_disbursement'),'e.groupaccount_id = f.account_id')
                       ->join(array('f'=>'ourbank_accounts'),'f.account_id = e.groupaccount_id')
                       ->group('f.account_number');
           //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }*/

}