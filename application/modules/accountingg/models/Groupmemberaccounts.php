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
class Accounting_Model_Groupmemberaccounts extends Zend_Db_Table {
     protected $_name = 'ourbank_groupmembers_acccounts';


    public function Addgroupmembers($memberfirstname,$account_id,$productId,$createdby) {

        foreach($memberfirstname as $memberfirstname) {
            $data = array('groupmemberaccount_id' => '',
                          'groupaccount_id' => $account_id,
                          'groupmember_id' => $memberfirstname,
                          'product_id' => $productId,
                          'groupmember_account_status' => 3,
                          'groupcreateddate' => date("Y-m-d"),
                          'groupcreatedby'=> '');
           $this->insert($data);
        }
    }
}
