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

class Reports_Model_Personalsavings extends Zend_Db_Table
{
    protected $_name = 'ourbank_usernamesupdates';

    public function accountDetails()
    {

        $db = $this->getAdapter();
        $sql = 'select 
                        G.account_id,
                        G.transaction_id, 
                        G.balance,
                        A.account_number,
                        B.offerproductname,
                        C.membercode,
                        D.memberfirstname,
                        A.accountcreated_date,
                        G.balance,
                        E.login_name
                        FROM 
                        ourbank_accounts A,
                        ourbank_productsofferdetails B,
                        ourbank_members C,
                        ourbank_membername D,
                        ourbank_userloginupdates E,
                        ourbank_transaction G,
                        ourbank_productdetails F
                        where 
                        G.transaction_id in (select max(transaction_id) FROM ourbank_transaction
                        group by account_id ) &&
                        C.member_id = A.member_id && 
                        A.product_id = B.offerproduct_id &&
                        B.product_id = F.product_id &&
                        C.member_id = D.member_id &&
                        E.user_id = A.accountcreated_by &&
                        G.account_id = A.account_id &&
                        F.productshortname = "ps" &&
                        (F.recordstatus_id = 3 || F.recordstatus_id) &&
                        (E.recordstatus_id = 3 || E.recordstatus_id = 1)&&
                        (A.accountstatus_id = 3 || A.accountstatus_id = 1) &&
                        D.recordstatus_id = 3 &&
                        (B.recordstatus_id = 3 || B.recordstatus_id = 1) &&
                        (G.recordstatus_id = 3 || G.recordstatus_id = 1)
                        order by G.account_id';
        $result = $db->fetchAll($sql);
        return $result;
    }
                        
}
