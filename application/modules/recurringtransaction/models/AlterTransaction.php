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

class Transaction_Model_AlterTransaction extends Zend_Db_Table{
    protected $db;

    public function fetchAccountDetails($vochure_number) 
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM
                ourbank_transaction A,
                ourbank_accounts B,
                ourbank_membername C,
                ourbank_productsofferdetails D, 
                ourbank_members E where (
                A.transaction_id=? &&
                A.account_id = B.account_id && 
                C.member_id = E.member_id &&
                B.member_id = C.member_id && 
                B.product_id = D.offerproduct_id &&
 		C.recordstatus_id = 3 &&
 		D.recordstatus_id = 3) ';
        $result = $db->fetchAll($sql,array($vochure_number));
        return $result;
    }
    
    public function recordStatus($transactionId) 
    {
        $db = $this->getAdapter();
        $sql = 'SELECT recordstatus_id FROM  ourbank_transaction where (transaction_id=?)';
        $result = $db->fetchAll($sql,array($transactionId));
        return $result;
    }

    public function fetchTransactionDetails($transactionId) 
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM
                       ourbank_accounts A,
                       ourbank_productsofferdetails B,
                       ourbank_members C,
                       ourbank_membername D,
                       ourbank_transaction E,
                       ourbank_paymenttypes G,
                       ourbank_transactiontype H,
                       ourbank_officenames I where (
                       E.transaction_id = '.$transactionId.' &&
                       A.account_id = E.account_id && 
                       A.member_id = C.member_id &&
                       A.product_id = B.offerproduct_id &&
                       C.member_id = D.member_id &&
                       H.transactiontype_id = E.transaction_type &&
                       G.paymenttype_id = E.paymenttype_mode && 
                       C.memberbranch_id= I.office_id &&
		       B.recordstatus_id = 3 &&
 		       D.recordstatus_id = 3 &&
 		       I.recordstatus_id = 3)';

        $result = $db->fetchAll($sql,array($transactionId));

        return $result;
    }

    public function groupDetails($transactionId) 
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM
                ourbank_transaction A,
                ourbank_accounts B,
                ourbank_groupmembers C,
                ourbank_groupaddress D,
                ourbank_officenames E where (
                A.transaction_id = ? && 
                A.account_id = B.account_id &&
                B.member_id = C.group_id &&
                C.group_id = D.group_id &&
                D.groupoffice_id= E.office_id)';
        $result = $db->fetchAll($sql,array($transactionId));
        return $result;
    }

    public function transactionUpdate1($feildname,$table,$pk,$input = array())
    {
        $db = $this->getAdapter();
	$pk = intval($pk);
		
        $where[] = "$feildname = '".$pk."'";
	$result = $db->update($table,$input,$where);
        return $result;
    }

    public function transactionDelete($id,$input = array()) {

        $db = $this->getAdapter();
        $where[] = "transaction_id = '".$id."'";
        $where[] = "recordstatus_id = '3'";
        $result = $db->update('ourbank_savings_transaction',$input,$where);

    }
        
    public function insertsavingstransactionDetails($input = array())
    {
            $db = $this->getAdapter();
            $db->insert('ourbank_savings_transaction',$input);
            return $db->lastInsertId('ourbank_savings_transaction');
    }

    public function insertTransaction($input = array())
    {
        $db = $this->getAdapter();
        $db->insert('ourbank_transaction',$input);
        $result = $db->lastInsertId('ourbank_transaction');
	return $result;
    } 

    public function transactionUpdate($id,$input = array()) {
        $db = $this->getAdapter();
        $where[] = "transaction_id = '".$id."'";
        $result = $db->update('ourbank_transaction',$input,$where);
    }

    public function transactionType($transactiontype)
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_transaction_type  where transaction_type =?';
        $result = $db->fetchAll($sql,array($transactiontype));
        return $result;
    }  

    public function transactionMode($transaction_mode)
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_paymenttypes where paymenttype_description =?';
        $result = $db->fetchAll($sql,array($transaction_mode));
        return $result;
    }
    
    public function transactionResult($transaction_id)
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_transaction where transaction_id =?';
        $result = $db->fetchAll($sql,array($transaction_id));
        return $result;
    }
    
    public function transaction_type()
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_transactiontype ';
        $result = $db->fetchAll($sql);
        return $result;
    }


    public function transactionModeEdit()
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_paymenttypes ';
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function accountStatus($account_number)
    {
        $db = $this->getAdapter();
        $sql = 'SELECT * FROM ourbank_accounts where (account_number = ?)';
        $result = $db->fetchAll($sql,array($account_number));
        return $result;
    }
}
