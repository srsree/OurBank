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
class Enquiry_Model_Interest extends Zend_Db_Table_Abstract {

protected $_name = 'ourbank_accounts'; 

public function fetchTransactionDetails($transaction_date) {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_accounts'),array('a.account_number'))
                       ->join(array('b'=>'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_members'),'c.member_id = b.offerproduct_id')
                       ->join(array('d'=>'ourbank_membername'),'d.member_id = c.member_id')
                       ->where('d.recordstatus_id = 3')
                       ->join(array('e'=>'ourbank_transaction'),'e.account_id = a.account_id')
                       ->where('e.transaction_date = ?',$transaction_date)
                       ->join(array('g'=>'ourbank_paymenttypes'),'g.paymenttype_id = e.paymenttype_mode')
                       ->join(array('h'=>'ourbank_transaction_type'),'h.transactiontype_id = e.transaction_type')
                       ->join(array('i'=>'ourbank_officenames'),'c.memberbranch_id = i.office_id')
                       ->where('i.recordstatus_id = 3')
                       ->join(array('j'=>'ourbank_userloginupdates'),'j.user_id = e.created_by');
           //die($select->__toString());
       return $this->fetchAll($select);
    }
}
