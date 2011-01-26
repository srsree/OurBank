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
class Enquiry_Model_LoanEnquiry extends Zend_Db_Table
{
protected $_name = 'ourbank_productsofferdetails';


    public function fetchloanDetails()
    {
        $sql = $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->from(array('B' => 'ourbank_loan_disbursement'), array('SUM(amount_disbursed),COUNT(offerproductname)'))
                                ->join(array('C'=>'ourbank_accounts'),'C.account_id = B.account_id','account_number')
                                ->where('C.accountstatus_id = 3 ')
                                ->join(array('D' =>'ourbank_productsofferdetails'),'D.offerproduct_id = C.product_id ','offerproductname')
                                ->where('D.recordstatus_id = 3')
                                ->join(array('E'=>'ourbank_productdetails'),'E.product_id = D.product_id','productname')
                                ->group('D.offerproductname');
                 // die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
    
    }
}
