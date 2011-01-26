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
 *  model page for fetch and return Cashscroll details, filtered search details
 */
class Cashscroll_Model_Cashscroll extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
	//credit
    public function totalSavingsCredit($date) 
    {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transactiontype_id = 1 AND A.paymenttype_id = 1')
                        ->where('A.transaction_date <= "'.$date.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.product_id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id');
                        
        return $this->fetchAll($select);
        
    }

	//debit 
    public function totalSavingsDebit($date) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transactiontype_id = 2 AND A.paymenttype_id = 1')
                        ->where('A.transaction_date <= "'.$date.'"')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.product_id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id');
        return $this->fetchAll($select);

    }

	//opening balance
    public function openingBalance($date) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_Assets'),array('(SUM(credit) - SUM(debit) ) as openingBalance'))

                        ->join(array('D'=>'ourbank_transaction'),'A.transaction_id = D.transaction_id')
                        ->where('D.transaction_date < "'.$date.'" ')
                        ->join(array('B'=>'ourbank_glsubcode'),'A.glsubcode_id_to = B.id');

        return $this->fetchAll($select);
    }
}
