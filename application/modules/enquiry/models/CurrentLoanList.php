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
class Enquiry_Model_CurrentLoanList extends Zend_Db_Table_Abstract {
protected $_name = 'ourbank_loan_disbursement'; 

 public function currentLoan() {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_loan_disbursement'),array('a.amount_disbursed ,a.officeshort_name'))
                       ->join(array('b'=>'ourbank_accounts'),'a.account_id = b.account_id')
                       ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id = c.offerproduct_id')
                       ->where('c.recordstatus_id = 3')
                       ->join(array('d'=>'ourbank_productdetails'),'c.product_id = d.product_id');
//           die($select->__toString());
       return $this->fetchAll($select);
    }

}




