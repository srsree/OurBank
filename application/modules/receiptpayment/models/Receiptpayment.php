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
    
class Receiptpayment_Model_Receiptpayment extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    public function totalSavingsCredit($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank) as savingcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transactiontype_id = 1' )
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id')
                        ->group('B.name');
                       //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }



    public function totalSavingsDebit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'),array('SUM(amount_to_bank) as savingcredit'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transactiontype_id = 2' )
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id')
                        ->group('B.name');
                       //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }
  
    public function openingBalance($fromDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_Assets'),array('(SUM(credit) - SUM(debit) ) as openingBalance'))

                        ->join(array('D'=>'ourbank_transaction'),'A.transaction_id = D.transaction_id')
                        ->where('D.transaction_date < "'.$fromDate.'" ')
                        ->join(array('B'=>'ourbank_glsubcode'),'A.	glsubcode_id_to = B.id')
                        ->join(array('C'=>'ourbank_glcode'),'C.id = B.glcode_id')
                        ->where('C.id = 4');
//die($select->__toString());


        return $this->fetchAll($select);
    }

    public function closingBalance($fromDate,$toDate) {
//         $select = $this->select()
//                        ->setIntegrityCheck(false)
//                         ->from(array('A' => 'ourbank_Assets'),array('SUM(credit) - SUM(debit) as closingBalance'))
//                         ->join(array('B'=>'ourbank_glsubcodeupdates'),'A.glsubcode_id_to = B.glsubcode_id')
//                         ->join(array('C'=>'ourbank_glcodeupdates'),'C.glcode_id = B.glcode_id')
//                         ->where('C.glcode_id = 4')
//                         ->join(array('D'=>'ourbank_transaction'),'A.tranasction_number = D.transaction_id')
//                         ->where('D.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
//;
        $db = $this->getAdapter();
        $sql = "SELECT sum(credit)-sum(debit) closingBalance FROM ourbank_Assets a, ourbank_transaction b,ourbank_glsubcode c
where a.transaction_id = b.transaction_id
and c.id = b.glsubcode_id_to
and b.glsubcode_id_to = a.glsubcode_id_to
and b.transaction_date >= '$fromDate' and  b.transaction_date <= '$toDate'
and c.glcode_id = 4";
        
        return $db->fetchAll($sql);


    } 
}