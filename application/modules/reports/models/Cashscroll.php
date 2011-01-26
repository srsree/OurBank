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
    
class Reports_Model_Cashscroll extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    public function totalSavingsCredit($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingSavingsCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank) as openingsavingcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"');
                       //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalSavingsDebit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingSavingsDebit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank) as openingsavingdebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalFixedCredit($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingFixedCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank) as openingfixedcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalFixedDebit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingFixedDebit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank) as openingfixeddebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2' )
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalRecurringCredit($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingRecurringCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank) as openingrecurringcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalRecurringDebit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingRecurringDebit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank) as openingrecurringdebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalLoanCredit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->join(array('E'=>'ourbank_categorydetails'),'D.category_id = E.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2');
// die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingLoanCredit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(transaction_amount) as openingloancredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')

                        ->join(array('E'=>'ourbank_categorydetails'),'D.category_id = E.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2')
                        ->group('B.offerproduct_id');
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalLoanDedit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->join(array('E'=>'ourbank_categorydetails'),'D.category_id = E.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2');
// die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingLoanDedit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(transaction_amount) as openingloandebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date < "'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')

                        ->join(array('E'=>'ourbank_categorydetails'),'D.category_id = E.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2')
                        ->group('B.offerproduct_id');
        $result = $this->fetchAll($select);
        return $result;
    }
}
