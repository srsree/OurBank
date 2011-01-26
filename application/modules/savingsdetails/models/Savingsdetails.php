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
class Savingsdetails_Model_Savingsdetails extends Zend_Db_Table
{
protected $_name = 'ourbank_transaction';


    public function accountDetails()
    {
        $db = $this->getAdapter();
        $sql = 'SELECT 
B.name as productname,
A.account_number as account_number,
C.membercode as membercode,
C.name as name,
A.accountcreated_date as accountcreated_date,
G.balance as balance,
E.name as username

				 FROM 
                ourbank_accounts A,
                ourbank_productsoffer B,
                ourbank_member C,
                ourbank_user E,
                ourbank_product F,
                ourbank_transaction G where (
                C.id = A.member_id && 
                A.product_id = B.id &&
                B.product_id = F.id &&
                E.id = A.created_by &&
                G.account_id = A.id &&
                A.status_id = 3 &&
                G.recordstatus_id = 3
                )';



        $result = $db->fetchAll($sql);
        return $result;
    }
}
