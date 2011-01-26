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
class Transaction_Model_BasicEnquiry extends Zend_Db_Table {
     protected $_name = 'ob_transaction';


    public function transactionByDate($date) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_transaction'),array('transaction_id'))
                       ->where('a.transaction_date = ?',$date)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ob_accounts'),'a.account_id = b.account_id') 
                       ->join(array('c' => 'ob_transactiontype'),'c.transactiontype_id = a.transaction_type')
                       ->join(array('d' => 'ob_paymenttypes'),'d.paymenttype_id = a.paymenttype_mode')
                       ->join(array('e' => 'ob_login_details'),'e.id = a.created_by')
                       ->join(array('f' => 'ob_record_status'),'f.recordstatus_id = a.recordstatus_id');
                       //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
        }

 
}
