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
    
class Reports_Model_Sbcashscroll extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    public function totalSavingsCredit($fromDate,$toDate) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 1')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"')
                        ->join(array('E' =>'ourbank_glsubcode'),'E.glsubcode_id = A.glsubcode_id_to')
                        ->order('A.transaction_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

    public function totalSavingsDebit($fromDate,$toDate) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_type = 2')
                        ->where('A.transaction_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.account_id = A.account_id')
                        ->where('C.accountstatus_id =3 OR C.accountstatus_id =1' )
                        ->join(array('B'=>'ourbank_productsofferdetails'),'C.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 OR B.recordstatus_id = 1')
                        ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id')
                        ->where('D.recordstatus_id = 3 OR D.recordstatus_id = 1')
                        ->where('D.productshortname = "ps"')
                        ->join(array('E' =>'ourbank_glsubcode'),'E.glsubcode_id = A.glsubcode_id_to')
                        ->order('A.transaction_id');
                       // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }

}
