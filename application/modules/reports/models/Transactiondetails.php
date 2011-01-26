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
    
class Reports_Model_Transactiondetails extends Zend_Db_Table
{
     protected $_name = 'ourbank_transaction';

    public function getAccountDetails($accountNo)
    {

        $db = $this->getAdapter();
        $sql = "Select A.memberfirstname as name, 
                       D.offerproductname,    
                       B.membercode,
                       C.account_number,
                       E.office_name
                       from 
                       ourbank_membername A,
                       ourbank_members B,
                       ourbank_accounts C,
                       ourbank_productsofferdetails D,
                       ourbank_officenames E
                    WHERE
                        (C.account_number = '$accountNo') AND
                        (C.accountstatus_id = '3' OR C.accountstatus_id = '1') AND
                        (C.product_id = D.offerproduct_id) AND
                        (D.recordstatus_id = '3' || D.recordstatus_id = '1') AND
                        (B.member_id = C.member_id) AND
                        (A.member_id = B.member_id) AND

                        (A.recordstatus_id = '3') AND
                        (B.member_status = '3' OR B.member_status = '1') AND
                        (E.office_id = B.memberbranch_id) AND
                        (E.recordstatus_id = '3' || E.recordstatus_id = '1')
                    UNION
                Select A.groupname as name, 
                       D.offerproductname,    
                       B.membercode,
                       C.account_number,
                       E.office_name
                       from 
                       ourbank_groupaddress A,
                       ourbank_members B,
                       ourbank_accounts C,
                       ourbank_productsofferdetails D,
                       ourbank_officenames E
                WHERE
                (C.account_number = '$accountNo') AND
                        (C.accountstatus_id = '3' OR C.accountstatus_id = '1') AND
                        (C.product_id = D.offerproduct_id) AND
                        (D.recordstatus_id = '3' || D.recordstatus_id = '1') AND
                        (B.member_id  = C.member_id) AND
                        (A.group_id  = B.member_id) AND

                        (A.recordstatus_id = '3') AND
                        (B.member_status = '3' OR B.member_status = '1') AND
                        (E.office_id = B.memberbranch_id) AND
                        (E.recordstatus_id = '3' || E.recordstatus_id = '1')";

        $result = $db->fetchAll($sql);
        return $result;



	

    }





    public function fetchTransactionDetails($accountNo,$dateFrom,$dateTo)
    {
        if($accountNo && !$dateFrom) {
                  $select = $this->select()
                    ->setIntegrityCheck(false) 
                    ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                    ->where('a.accountstatus_id = 3 OR a.accountstatus_id = 1')
                  ->where('a.account_number like  ? "%"',$accountNo)
                    ->join(array('b' => 'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                    ->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')


                    ->join(array('f' => 'ourbank_transaction'),'f.account_id = a.account_id')
                    ->where('f.recordstatus_id = 3 || f.recordstatus_id = 1')
                    ->join(array('g' => 'ourbank_transactiontype'),'f.transaction_type = g.transactiontype_id')
                    ->join(array('h' => 'ourbank_paymenttypes'),'f.paymenttype_mode = h.paymenttype_id')
                    ->join(array('i' => 'ourbank_userloginupdates'),'f.created_by = i.user_id');

        } 
        else if(!$accountNo && $dateFrom) {
        $select = $this->select()
                    ->setIntegrityCheck(false) 
                    ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                    ->where('a.accountstatus_id = 3 OR a.accountstatus_id = 1')
//                      ->where('a.account_number like "%" ? "%"',$accountNo)
                    ->where('f.transaction_date >= "'.$dateFrom.'"  AND f.transaction_date <= "'.$dateTo.'"')
                    ->join(array('b' => 'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                    ->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')



                    ->join(array('f' => 'ourbank_transaction'),'f.account_id = a.account_id')
                    ->where('f.recordstatus_id = 3 || f.recordstatus_id = 1')
                    ->join(array('g' => 'ourbank_transactiontype'),'f.transaction_type = g.transactiontype_id')
                    ->join(array('h' => 'ourbank_paymenttypes'),'f.paymenttype_mode = h.paymenttype_id')
                    ->join(array('i' => 'ourbank_userloginupdates'),'f.created_by = i.user_id');

        }
        else  {
        $select = $this->select()
                    ->setIntegrityCheck(false) 
                    ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                    ->where('a.accountstatus_id = 3 OR a.accountstatus_id = 1')
                      ->where('a.account_number like "%" ? "%"',$accountNo)
                    ->where('f.transaction_date >= "'.$dateFrom.'"  AND f.transaction_date <= "'.$dateTo.'"')
                    ->join(array('b' => 'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                    ->where('b.recordstatus_id = 3 || b.recordstatus_id = 1')



                    ->join(array('f' => 'ourbank_transaction'),'f.account_id = a.account_id')
                    ->where('f.recordstatus_id = 3 || f.recordstatus_id = 1')
                    ->join(array('g' => 'ourbank_transactiontype'),'f.transaction_type = g.transactiontype_id')
                    ->join(array('h' => 'ourbank_paymenttypes'),'f.paymenttype_mode = h.paymenttype_id')
                    ->join(array('i' => 'ourbank_userloginupdates'),'f.created_by = i.user_id');

        }
        
        return $this->fetchAll($select);

    }






        public function transaction_type()
        {
            $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
            $sql = 'SELECT * FROM ourbank_transaction_type ';
            $result = $this->db->fetchAll($sql);
            return $result;
        }


        public function transactionMode()
        {
            $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
            $sql = 'SELECT * FROM ourbank_paymenttypes ';
            $result = $this->db->fetchAll($sql);
            return $result;
        }
}
