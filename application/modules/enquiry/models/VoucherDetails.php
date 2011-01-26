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
class Enquiry_Model_VoucherDetails extends Zend_Db_Table_Abstract {

 public function fetchTransaction($fromDate,$toDate,$voucherId) 
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "Select A.transaction_date, A.transaction_id,                    A.transaction_amount,A.transaction_interest_amount,E.paymenttype_description,A.transaction_mode_details,H.transaction_type,G.login_name from 
                ourbank_transaction A,
                ourbank_groupaddress B,
                ourbank_members C,
                ourbank_accounts D,
                ourbank_paymenttypes E,
                ourbank_userloginupdates G,
                ourbank_transaction_type H
                WHERE
                (A.transaction_date BETWEEN '".$fromDate."' AND '".$toDate."') AND
                (A.transaction_id = '$voucherId') AND
                (B.group_id = C.member_id) AND
                (C.member_id = D.member_id) AND
                (D.account_id = A.account_id) AND
                (E.paymenttype_id = A.paymenttype_mode) AND
                (A.created_by = G.user_id) AND
                (H.transactiontype_id = A.transaction_type) AND
                (B.recordstatus_id = 3)
        UNION
                SELECT E.transaction_date,E.transaction_id,E.transaction_amount,E.transaction_interest_amount,G.paymenttype_description,E.transaction_mode_details,H.transaction_type,J.login_name  FROM
                ourbank_accounts A,
                ourbank_members C,
                ourbank_membername D,
                ourbank_transaction E,
                ourbank_paymenttypes G,
                ourbank_transaction_type H,
                ourbank_userloginupdates J
                WHERE
                (E.transaction_date BETWEEN '".$fromDate."' AND '".$toDate."') AND
                (E.transaction_id= '$voucherId')  AND
                (A.account_id = E.account_id) AND
                (A.member_id = C.member_id) AND
                (C.member_id = D.member_id) AND
                (H.transactiontype_id = E.transaction_type) AND
                (G.paymenttype_id = E.paymenttype_mode) AND
                (E.created_by= J.user_id) AND
 		(D.recordstatus_id = 3)";
        $result = $this->db->fetchAll($sql,array($field2,$field3,$field4));
        return $result;
    }
}