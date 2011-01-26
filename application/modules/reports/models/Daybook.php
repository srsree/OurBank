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
    
class Reports_Model_Daybook extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    public function totalSavingsCredit($mode,$fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank)/10 as savingcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR  C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"')
                        ->group('D.productname')

                        ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
                        
                       //die($select->__toString());

        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingSavingsCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(transaction_amount)/10 as openingsavingcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"')

                         ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');

                       //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalSavingsDebit($mode,$fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank)/10 as savingdebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"')

                        ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');

// die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }



    public function totalFixedCredit($mode,$fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank)/10 as fixedcredit','paymenttype_mode'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"')


                        ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
//                        // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingFixedCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank)/10 as openingfixedcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"')



                         ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }



    public function totalFixedDebit($mode,$fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank)/10 as fixeddebit','paymenttype_mode'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "fd"')




                        ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }



    public function totalRecurringCredit($mode,$fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank)/10 as recurringcredit','paymenttype_mode'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = "'.$mode.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"')



                         ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingRecurringCredit($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank)/10 as openingrecurringcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = 1' )
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"')




                         ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalRecurringDebit($mode,$fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank)/10 as recurringdebit','paymenttype_mode'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "rd"')




                         ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');

                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }




    public function totalLoanCredit($mode,$fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(transaction_amount) as loancredit','paymenttype_mode'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')

                        ->join(array('E'=>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2')
                        //->group('E.categoryname')


                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.glsubcode_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')
                        ->group('E.categoryname');

                      // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function openingLoanCredit($fromDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(transaction_amount)/10 as openingloancredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = 1')
                        ->where('A.transaction_date < "'.$fromDate.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')

                        ->join(array('E'=>'ourbank_categorydetails'),'D.category_id = E.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2')
                        ->group('B.offerproduct_id')
//                          ->join(array('E' =>'ourbank_categorydetails'),'E.category_id = D.category_id')
//                         ->where('E.recordstatus_id = 3 OR E.recordstatus_id = 1')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

                        ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = F.glcode_id');
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalLoanDedit($mode,$fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank) as loandebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1 OR C.accountstatus_id =5' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
 //->where('D.productshortname = "IL"')
                        ->join(array('E'=>'ourbank_categorydetails'),'E.category_id = D.category_id')
                        ->where('E.recordstatus_id =3 OR E.recordstatus_id =1' )
                        ->where('E.category_id =2')
//                         ->group('E.categoryname')

                        ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.glsubcode_id = E.category_id')
                        ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')
                         ->group('E.categoryname');
//                         ->join(array('F' =>'ourbank_glsubcodeupdates'),'F.subledger_id = E.category_id')
//                         ->where('F.recordstatus_id = 3 OR F.recordstatus_id = 1')

//                         ->join(array('G' =>'ourbank_glcode'),'G.glcode_id = 1');
//die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

public function test($mode,$fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_from_bank) as loandebit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2 AND A.paymenttype_mode = "'.$mode.'"')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' );
        return $this->fetchAll($select);
}




public function openingBalance($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_Assets'),array('(SUM(credit) - SUM(debit) )/10 as openingBalance'))

                        ->join(array('D'=>'ourbank_transaction'),'A.tranasction_number = D.transaction_id')
                        ->where('D.transaction_date < "'.$fromDate.'" ')
                        ->join(array('B'=>'ourbank_glsubcodeupdates'),'A.glsubcode_id_to = B.glsubcode_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('C'=>'ourbank_glcodeupdates'),'C.glcode_id = B.glcode_id')
                        ->where('C.recordstatus_id =3 OR C.recordstatus_id =1' )
                        ->where('C.glcode_id = 4');
//die($select->__toString());


        return $this->fetchAll($select);
    }

    public function closingBalance($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_Assets'),array('SUM(credit) - SUM(debit) as closingBalance'))
                        ->join(array('B'=>'ourbank_glsubcodeupdates'),'A.glsubcode_id_to = B.glsubcode_id')
                        ->join(array('C'=>'ourbank_glcodeupdates'),'C.glcode_id = B.glcode_id')
                        ->where('C.glcode_id = 4')
                        ->join(array('D'=>'ourbank_transaction'),'A.tranasction_number = D.transaction_id')
                        ->where('D.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ');

        $db = $this->getAdapter();
                         $sql = "SELECT sum(credit)-sum(debit) as closingBalance FROM ourbank_Assets a, ourbank_transaction b,ourbank_glsubcodeupdates c where a.tranasction_number = b.transaction_id and c.glsubcode_id = b.glsubcode_id_to and b.glsubcode_id_to = a.glsubcode_id_to and b.transaction_date >= '$fromDate' and  b.transaction_date <= '$toDate' and c.glcode_id = 4";
       
        return $db->fetchAll($sql);
//die($select->__toString());


    }

}