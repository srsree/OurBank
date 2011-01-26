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

class Reports_Model_Loanrepayment extends Zend_Db_Table {
    protected $_name = 'ourbank_accounts';


    public function loansearch($loanaccountnumber) {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->from(array('A' =>'ourbank_accounts'),array('account_id'))
            ->where('A.account_number = ?',$loanaccountnumber)
            ->join(array('B'=>'ourbank_productsofferdetails'),'A.product_id = B.offerproduct_id')
            ->where('B.recordstatus_id =3 OR B.recordstatus_id =1')
            ->join(array('C'=>'ourbank_productdetails'),'B.product_id = C.product_id')
            ->where('C.recordstatus_id =3 OR C.recordstatus_id =1')
            ->join(array('D'=>'ourbank_categorydetails'),'C.category_id = D.category_id')
            ->where('D.recordstatus_id =3 OR D.recordstatus_id =1')
            ->where('D.category_id =2')
            ->join(array('G'=>'ourbank_transaction'),'A.account_id=G.account_id')
            ->where('G.recordstatus_id =3 OR G.recordstatus_id=1')
            ->join(array('E'=>'ourbank_loan_repayment'),'G.account_id = E.account_id')
            ->where('E.recordstatus_id =3 OR E.recordstatus_id =1')
            ->where('G.transaction_id =E.transaction_id');
//         die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function disbursedamounts($loanaccountnumber) {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->from(array('A' =>'ourbank_accounts'),array('account_id'))
            ->where('A.account_number = ?',$loanaccountnumber)
            ->join(array('B'=>'ourbank_loan_disbursement'),'A.account_id = B.account_id',array('SUM(B.amount_disbursed) as amount_disbursed','B.loandisbursement_date'))
            ->where('B.recordstatus_id =3 OR B.recordstatus_id =1');
//         die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}
