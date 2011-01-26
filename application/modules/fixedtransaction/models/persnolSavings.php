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
class Fixedtransaction_Model_persnolSavings extends Zend_Db_Table {
        protected $_name = 'ourbank_accounts';

        public function listOfcategory() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_categorydetails'),array('category_id'))
                        ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
                        ->order('category_id ASC');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function listOfmemberType() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_membertypes'),array('membertype_id'))
                        ->where('a.membertype_id != 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function searchpersnolsavings($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->join(array('b' => 'ourbank_accounts'),'a.member_id = b.member_id',array('account_id'))
                        ->where('b.account_number = ?',$accountNumber)
                        ->where('b.accountstatus_id = 3 or b.accountstatus_id = 1')
                        ->join(array('c' => 'ourbank_productsofferdetails'),'b.product_id = c.offerproduct_id',array('offerproduct_id'))
                        ->where('c.recordstatus_id = 3 or c.recordstatus_id = 1')
                        ->join(array('d' => 'ourbank_productdetails'),'c.product_id = d.product_id',array('product_id'))
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->where('d.productshortname="ps"')
                        ->join(array('e' => 'ourbank_categorydetails'),'d.category_id = e.category_id',array('category_id'))
                        ->where('e.recordstatus_id = 3 or e.recordstatus_id = 1')
                        ->join(array('f' => 'ourbank_membertypes'),'a.membertype_ID = f.membertype_id',array('f.membertype_id','f.membertype'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function savingsAccountsSearchdetails($membercode) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->where('a.membercode = ?',$membercode)
                        ->join(array('b' => 'ourbank_accounts'),'a.member_Id=b.member_id')
                        ->where('b.accountstatus_id = 3 or b.accountstatus_id = 1')
                        ->join(array('c' => 'ourbank_productsofferdetails'),'a.membertype_id=c.applicableto and b.product_id=c.offerproduct_id')
                        ->where('c.recordstatus_id = 3 or c.recordstatus_id = 1')
                        ->join(array('d' => 'ourbank_productdetails'),'c.product_id = d.product_id',array('d.category_id','d.productshortname','d.productname','d.product_id'))
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->where('d.productshortname="ps"')
                        ->join(array('f' => 'ourbank_membertypes'),'a.membertype_id = f.membertype_id',array('f.membertype_id','f.membertype'))
                        ->join(array('g' => 'ourbank_savingsaccounts'),'b.account_id = g.account_id',array('savingsaccount_id'))
                        ->where('g.savingsaccountstatus_id = 3 or g.savingsaccountstatus_id = 1')
                        ->where('g.recordstatus_id = 3 or g.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function accountIDSearch($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.member_id = ?',$memberId)
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_savingsaccounts'),'a.account_id=b.account_id')
                        ->where('b.savingsaccountstatus_id = 3 or b.savingsaccountstatus_id = 1')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchpersnolsavingsDetails($accountNumber,$categoryType) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->join(array('b' => 'ourbank_membername'),'a.member_id = b.member_id')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                        ->join(array('c' => 'ourbank_accounts'),'b.member_id = c.member_id')
                        ->where('c.account_number = ?',$accountNumber)
                        ->where('c.accountstatus_id = 3 or c.accountstatus_id = 1')
                        ->where('c.membertype_id="4"')
                        ->join(array('d' => 'ourbank_productsofferdetails'),'c.product_id = d.offerproduct_id')
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->join(array('e' => 'ourbank_productdetails'),'d.product_id = e.product_id')
                        ->where('e.category_id = ?',$categoryType)
                        ->where('e.recordstatus_id = 3 or e.recordstatus_id = 1')
                        ->join(array('f' => 'ourbank_categorydetails'),'e.category_id = f.category_id')
                        ->where('f.recordstatus_id = 3 or f.recordstatus_id = 1')
                        ->join(array('g' => 'ourbank_membertypes'),'a.membertype_ID = g.membertype_id')
                        ->join(array('h' => 'ourbank_officenames'),'a.memberbranch_id = h.office_id')
                        ->where('h.recordstatus_id = 3 or h.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchpersnolsavingsGroupDetails($accountNumber,$categoryType) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->where('a.membertype_ID="3"')
                        ->join(array('b' => 'ourbank_groupaddress'),'a.member_id = b.group_id')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                        ->join(array('c' => 'ourbank_accounts'),'a.member_id = c.member_id')
                        ->where('c.account_number = ?',$accountNumber)
                        ->where('c.accountstatus_id = 3 or c.accountstatus_id = 1')
                        ->where('c.membertype_id="3"')
                        ->join(array('d' => 'ourbank_productsofferdetails'),'c.product_id = d.offerproduct_id')
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->join(array('e' => 'ourbank_productdetails'),'d.product_id = e.product_id')
                        ->where('e.category_id = ?',$categoryType)
                        ->where('e.recordstatus_id = 3 or e.recordstatus_id = 1')
                        ->join(array('f' => 'ourbank_categorydetails'),'e.category_id = f.category_id')
                        ->where('f.recordstatus_id = 3 or f.recordstatus_id = 1')
                        ->join(array('g' => 'ourbank_membertypes'),'a.membertype_ID = g.membertype_id')
                        ->join(array('h' => 'ourbank_officenames'),'a.memberbranch_id = h.office_id')
                        ->where('h.recordstatus_id = 3 or h.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchgroupMembersDetails($groupid) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_groupmembers'),array('group_id'))
                        ->where('a.group_id = ?',$groupid)
                        ->join(array('b' => 'ourbank_members'),'a.member_id = b.member_id',array('b.membercode'))
                        ->join(array('c' => 'ourbank_membername'),'b.member_id = c.member_id',array('c.memberfirstname'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchGroupAccountMembers($accountNumber,$groupid) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.member_id = ?',$groupid)
                        ->where('a.account_number = ?',$accountNumber)
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_groupmembers_acccounts'),'a.account_id = b.groupaccount_id')
                        ->where('b.groupmember_account_status = 3 or b.groupmember_account_status = 1')
                        ->join(array('c' => 'ourbank_members'),'b.groupmember_id = c.member_id')
                        ->join(array('d' => 'ourbank_membername'),'c.member_id = d.member_id')
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1');
// 		die($select->__toString($select));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function totalamount($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->join(array('b' => 'ourbank_transaction'),'a.account_id=b.account_id',array('b.balance'))
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchsavingsdepodit($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->join(array('b' => 'ourbank_savings_transaction'),'a.account_id = b.account_id',array('b.transaction_amount'))
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                        ->where('b.transactiontype_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchsavingswithdrawal($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->join(array('b' => 'ourbank_savings_transaction'),'a.account_id = b.account_id',array('b.transaction_amount'))
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                        ->where('b.transactiontype_id = 2');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAccountDetails($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->where('a.membertype_id = 4')
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                        ->join(array('c' => 'ourbank_productdetails'),'b.product_id = c.product_id')
                        ->where('c.recordstatus_id = 3 or c.recordstatus_id = 1')
                        ->join(array('d' => 'ourbank_categorydetails'),'c.category_id = d.category_id')
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->join(array('e' => 'ourbank_members'),'a.member_id = e.member_id')
                        ->where('e.member_status = 3 or e.member_status = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchGroupAccountDetails($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->where('a.member_status = 3 or a.member_status = 1')
                        ->join(array('b' => 'ourbank_groupmembers'),'a.member_id = b.group_id')
                        ->join(array('c' => 'ourbank_groupaddress'),'b.group_id = c.group_id')
                        ->join(array('d' => 'ourbank_accounts'),'b.group_id = d.member_id')
                        ->where('d.accountstatus_id = 3 or d.accountstatus_id = 1')
                        ->where('d.account_number = ?',$accountNumber)
                        ->where('d.membertype_id = 3')
                        ->join(array('e' => 'ourbank_productsofferdetails'),'d.product_id = e.offerproduct_id')
                        ->where('e.recordstatus_id = 3 or e.recordstatus_id = 1')
                        ->join(array('f' => 'ourbank_productdetails'),'e.product_id = f.product_id')
                        ->where('f.recordstatus_id = 3 or f.recordstatus_id = 1')
                        ->join(array('g' => 'ourbank_categorydetails'),'f.category_id = g.category_id')
                        ->where('g.recordstatus_id = 3 or g.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function fetchsavingsfullDetails($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_savings_transaction'),array('transaction_id'))
                        ->order('a.transaction_id DESC LIMIT 5')
                        ->join(array('b' => 'ourbank_transactiontype'),'a.transactiontype_id= b.transactiontype_id')
                        ->join(array('c' => 'ourbank_paymenttypes'),'a.paymenttype_id = c.paymenttype_id')
                        ->join(array('d' => 'ourbank_accounts'),'a.account_id = d.account_id')
                        ->where('d.account_number = ?',$accountNumber);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchsavingsDetails($accountNumber)
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select * from ourbank_savings_transaction A,
                                ourbank_transactiontype B,ourbank_paymenttypes C,
                                ourbank_accounts D,ourbank_transaction E 
                                where (D.account_number ='$accountNumber' 
                                AND A.transactiontype_id=B.transactiontype_id 
                                AND A.paymenttype_id=C.paymenttype_id
                                AND A.transaction_id=E.transaction_id
                                AND D.account_id=A.account_id)ORDER BY A.transaction_id DESC LIMIT 5";
                $result = $this->db->fetchALL($sql,array());
                return $result;
        }

        public function lasttransactiondatefromtemp($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->join(array('b' => 'ourbank_transaction'),'a.account_id = b.account_id',array('b.transaction_date'))
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function lasttransactiondate1($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber)
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_savings_transaction'),'a.account_id = b.account_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAllStatus($accountStatusId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id = ?',$accountStatusId);
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function fetchAll_paymenttype_id() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('paymenttype_id'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAll_paymenttype_idforloans() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('paymenttype_id'))
                        ->where('a.paymenttype_id != 5');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function gettransactionmode($transactionMode) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('id'))
                        ->where('a.id = ?',$transactionMode);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAll_paymenttype() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('paymenttype_id'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function insertsavingstransactionDetails($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert('ourbank_savings_transaction',$input);
                return $this->db->lastInsertId('ourbank_savings_transaction');
        }

        public function groupsavingsInsert($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_groupmember_savingstransaction',$input);
                return $result;
        }

        public function fetchAllStatusDetails($accountStatusId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id != ?',$accountStatusId)
                        ->where('a.recordstatus_id != 3 and a.recordstatus_id != 5');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }


        public function accountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$id."'";
                $result = $this->db->update('ourbank_accounts',$input,$where);
        }

        public function savingsaccountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$id."'";
                $result = $this->db->update('ourbank_savingsaccounts',$input,$where);
        }

        public function savingsgroupaccountaccountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "groupaccount_id = '".$id."'";
                $result = $this->db->update('ourbank_groupmembers_acccounts',$input,$where);
        }

        public function originalaccountid($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountNumber);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function savingsaccountlink($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_id = ?',$accountId)
                        ->join(array('b' => 'ourbank_loanaccounts'),'a.account_id = b.savingsaccount_id')
                        ->where('b.tieup_flag = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function savingsAccountsSearch($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('id'))
                        ->where('A.account_number = ?',$accountnumber)
                        ->where('A.accountstatus_id = 3 or A.accountstatus_id = 1')
                        ->join(array('B' => 'ourbank_productsoffer'),'A.product_id=B.id')

                        ->join(array('C' => 'ourbank_savingsaccounts'),'A.id=C.account_id')
                        ->where('C.savingsaccountstatus_id = 3 or C.savingsaccountstatus_id = 1')
                        ->join(array('D' => 'ourbank_product'),'B.product_id=D.id')
                        ->where('D.productshortname = "ps"');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function transferaccountid($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.account_number = ?',$accountnumber)
                        ->where('a.accountstatus_id = 1 or a.accountstatus_id = 3')
                        ->join(array('b' => 'ourbank_member'),'a.member_id=b.id')
                        ->join(array('c' => 'ourbank_productsoffer'),'a.product_id=c.id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function transferedtotalamount($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('account_id'))
                        ->where('A.account_number = ?',$accountnumber)
                        ->join(array('B' => 'ourbank_transaction'),'A.account_id=B.account_id',array('B.balance'))
                        ->where('B.recordstatus_id = 3 or B.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchtransferedsavingsdepodit($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('C' => 'ourbank_accounts'),array('account_id'))
                        ->where('C.account_number = ?',$accountnumber)
                        ->join(array('D' => 'ourbank_savings_transaction'),'C.account_id=D.account_id',array('D.transaction_amount'))
                        ->where('D.transactiontype_id = 1')
                        ->where('D.recordstatus_id = 1 or D.recordstatus_id = 3');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchtransferedsavingswithdrawal($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('C' => 'ourbank_accounts'),array('account_id'))
                        ->where('C.account_number = ?',$accountnumber)
                        ->join(array('D' => 'ourbank_savings_transaction'),'C.account_id=D.account_id',array('D.transaction_amount'))
                        ->where('D.transactiontype_id = 2')
                        ->where('D.recordstatus_id = 1 or D.recordstatus_id = 3');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function savingsglsubcode($savingsaccountid) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('C' => 'ourbank_accounts'),array('account_id'))
                        ->where('C.account_id = ?',$savingsaccountid)
                        ->where('C.accountstatus_id = 1 or C.accountstatus_id = 3')
                        ->join(array('D' => 'ourbank_productsofferdetails'),'C.product_id=D.offerproduct_id')
                        ->where('D.recordstatus_id = 1 or D.recordstatus_id = 3');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

// 	public function savingsinterest($offerproductid,$noOfDays) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_interest_periods where offerproduct_id=$offerproductid and period_ofrange_monthfrom >= $noOfDays or period_ofrange_monthto <= $noOfDays and (intereststatus_id = '1' or intereststatus_id = '3')";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}

    public function savingsinterest($offerproductid,$noOfDays) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_interest_periods
                                WHERE period_ofrange_monthfrom <= '$noOfDays' AND
                                        period_ofrange_monthto >= '$noOfDays' AND
                                        offerproduct_id = '$offerproductid' AND
                                        (intereststatus_id = '1' or intereststatus_id = '3')";
        $result = $this->db->fetchAll($sql,array($offerproductid,$noOfDays));
        return $result;
    }

// 
// 	public function fetchfeeccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 1,1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}
// 
// 	public function fetchinterestccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 2,1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}


// 	public function fetchassetsaccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}
// 
// 	public function fetchincomeaccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 1,1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}
// 
// 
// 	public function fetchlibalitesaccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 2,1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}
// 
// 	public function fetchExpendituraccount($memberbranch_id) 
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$sql = "select * from   ourbank_bankaccounts where (bank_branch_id='$memberbranch_id') LIMIT 3,1";
// 		$result = $this->db->fetchAll($sql,array());
// 		return $result;
// 	}






// 	public function insertbankcapitalaccounts($input = array())
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$result = $this->db->insert('ourbank_bankcapitalaccount',$input);
// 		return $result;
// 	}
// 
// 	public function insertbankfeeaccounts($input = array())
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$result = $this->db->insert('ourbank_bankfeeaccount',$input);
// 		return $result;
// 	}
// 
// 	public function insertbankinterestaccounts($input = array())
// 	{
// 		$this->db = Zend_Db_Table::getDefaultAdapter();
// 		$result = $this->db->insert('ourbank_bankinterstaccount',$input);
// 		return $result;
// 	}

        public function insertbanklibalityaccounts($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_Liabilities',$input);
                return $result;
        }

        public function insertbankassetsaccounts($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_Assets',$input);
                return $result;
        }

        public function insertbankincomeaccounts($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_Income',$input);
                return $result;
        }

        public function insertbankexpenditureaccounts($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_Expenditure',$input);
                return $result;
        }

        public function getrecordstatusdetails($status) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id = ?',$status);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function getdisbursmentfee() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
            $sql = "SELECT * FROM ourbank_activity A,ourbank_feedetails B where A.activity_description='loandisbursementAction' && A.activity_id=B.fee_action_id && (A.recordstatus_id='3' || A.recordstatus_id='1') && (B.recordstatus_id='3' || B.recordstatus_id='1')";
            $result = $this->db->fetchAll($sql,array());
            return $result;
        }

        public function selectbankassetsaccount($branchID) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select * from   ourbank_glsubcode where substr(header,5)='$branchID' and glcode_id='3'";
                $result = $this->db->fetchAll($sql,array());
                return $result;
        }

        public function selectbankcashassetsaccount($branchID) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select * from   ourbank_glsubcode where substr(header,5)='$branchID' and glcode_id='4'";
                $result = $this->db->fetchAll($sql,array());
                return $result;
        }
}
