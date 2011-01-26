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

class personalSavings extends Zend_Db_Table
{
//protected $_name = 'ourbank_usernamesupdates';
    protected $db;
	
    public function __construct()
    {
	$this->db = Zend_Registry::get('db');
    }

    public function accountDetails()
    {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM
                ourbank_accounts A,
                ourbank_productsofferdetails B,
                ourbank_members C,
                ourbank_membername D,
                ourbank_userloginupdates E,
                ourbank_productdetails F,
                ourbank_transaction G where (
                C.member_id = A.member_id && 
                A.product_id = B.offerproduct_id &&
                B.product_id = F.product_id &&
                C.member_id = D.member_id &&
                E.user_id = A.accountcreated_by &&
                G.account_id = A.account_id &&
                F.recordstatus_id = 3 &&
                E.recordstatus_id = 3 &&
                A.accountstatus_id = 3 &&
		D.recordstatus_id = 3 &&
		B.recordstatus_id = 3 &&
                G.recordstatus_id = 3
                )';



        $result = $this->db->fetchAll($sql);
        return $result;
    }
}
