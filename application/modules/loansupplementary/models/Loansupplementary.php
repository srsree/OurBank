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
class Loansupplementary_Model_Loansupplementary extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    public function totalloanCredit($date) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transaction_date BETWEEN "'.$date.'" AND "'.$date.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.product_id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id')
 			->join(array('F'=>'ourbank_category'),'F.id = D.category_id')
  			->where('F.id = 2')
                        ->join(array('E' =>'ourbank_glsubcode'),'E.id = A.glsubcode_id_to')
                        ->order('A.transaction_id');
//                        die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }
//array('SUM(transaction_amount)/10 as savingcredit','paymenttype_mode'))

    public function totalloanDebit($date) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                        ->from(array('A' => 'ourbank_transaction'))
                        ->where('A.recordstatus_id = 3 OR A.recordstatus_id = 1')
                        ->where('A.transactiontype_id = 2')
                        ->where('A.transaction_date BETWEEN "'.$date.'" AND "'.$date.'" ')
                        ->join(array('C'=>'ourbank_accounts'),'C.id = A.account_id')
                        ->where('C.status_id =3 OR C.status_id =1' )
                        ->join(array('B'=>'ourbank_productsoffer'),'C.product_id = B.product_id')
                        ->join(array('D' =>'ourbank_product'),'D.id = B.product_id')
 			->join(array('F'=>'ourbank_category'),'F.id = D.category_id')
 			->where('F.id = 2')
                        ->join(array('E' =>'ourbank_glsubcode'),'E.id = A.glsubcode_id_to')
                        ->order('A.transaction_id');
			//->group('D.product_id');
//                       die($select->__toString());
        $result = $this->fetchAll($select);
        return $result;
    }
}
