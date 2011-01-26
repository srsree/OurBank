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
class Transaction_Model_recurringSavings extends Zend_Db_Table {
        protected $_name = 'ourbank_accounts';

        public function recurringAccountsSearch($membercode) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->where('a.membercode = ?',$membercode)
                        ->join(array('b' => 'ourbank_membertypes'),'b.membertype_id = a.membertype_id')
                        ->join(array('c' => 'ourbank_accounts'),'a.member_Id = c.member_id')
                        ->where('c.accountstatus_id = 3 or c.accountstatus_id = 1')
                        ->join(array('d' => 'ourbank_productsofferdetails'),'d.applicableto = a.membertype_id')
                        ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                        ->join(array('e' => 'ourbank_product_fixedrecurring'),'c.product_id = d.offerproduct_id')
                        ->where('e.productstatus_id = 3 or e.productstatus_id = 1')
                        ->join(array('f' => 'ourbank_productdetails'),'f.product_id = d.product_id')
                        ->where('f.recordstatus_id = 3 or f.recordstatus_id = 1')
                        ->where('f.productshortname="rd"')
                        ->join(array('g' => 'ourbank_recurringaccounts'),'c.account_id = g.account_id')
                        ->where('g.fixedaccountstatus_id = 3 or g.fixedaccountstatus_id = 1')
                        ->where('g.recordstatus_id = 3 or g.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function groupNamesSearch($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_groupaddress'),array('a.groupname','a.group_id'))
                        ->where('a.group_id = ?',$memberId)
                        ->where('a.groupaccountstatus = 3 or a.groupaccountstatus = 1')
                        ->join(array('b' => 'ourbank_groupmembers'),'a.group_id = b.group_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function individualMemberName($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_membername'),array('a.memberfirstname'))
                        ->where('a.member_id = ?',$memberId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }


        public function recurringmemberbranchid($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('B.memberfirstname'))
                        ->where('A.account_id = ?',$accountId)
                        ->where('A.accountstatus_id = 3 or A.accountstatus_id = 1')
                        ->join(array('B' => 'ourbank_members'),'A.member_id=B.member_id')
                        ->where('B.member_status = 3 or B.member_status = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function accountIDSearch($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.member_id = ?',$memberId)
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_recurringaccounts'),'a.account_id = b.account_id')
                        ->where('b.fixedaccountstatus_id = 3 or b.fixedaccountstatus_id = 1')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function recurringSearch($accountcode) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountcode)
                        ->where('a.accountstatus_id = 3 or a.accountstatus_id = 1')
                        ->join(array('b' => 'ourbank_recurringaccounts'),'a.account_id = b.account_id')
                        ->where('b.fixedaccountstatus_id = 3 or b.fixedaccountstatus_id = 1')
                        ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function installmentsDetails($accountId,$productId) {
            $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select * from ourbank_recurringpaydetails A,ourbank_product_fixedrecurring B,ourbank_productsofferdetails C,ourbank_installmentstatus D where (A.account_id ='$accountId') AND (C.offerproduct_id='$productId') AND (A.rec_payment_status=D.installmentstatus_id) AND (C.offerproductupdate_id=B.offerproductupdate_id) AND (B.productstatus_id=1 or B.productstatus_id=3) AND (C.recordstatus_id=1 or C.recordstatus_id=3)";
            $result = $this->db->fetchAll($sql,array($accountId));
            return $result;
        }

        public function recurringAccountDetails($accountId,$productId) {
            $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select * from ourbank_recurringaccounts A,ourbank_productsofferdetails B,ourbank_product_fixedrecurring C,ourbank_productdetails D,ourbank_accounts E where (A.account_id ='$accountId') AND (B.offerproduct_id='$productId') AND (C.offerproductupdate_id=B.offerproductupdate_id) AND (C.productstatus_id=3 or C.productstatus_id=1) AND (B.recordstatus_id=3 or B.recordstatus_id=1) AND (A.recordstatus_id=1 or A.recordstatus_id=3) AND (D.product_id=B.product_id) AND (A.account_id=E.account_id)";
            $result = $this->db->fetchAll($sql,array($accountId));
            return $result;
        }

        public function recurringPaidDetails($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurring_payment'),array('account_id'))
                        ->where('a.account_id = ?',$accountId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function noOfInstalmentPaid($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('rec_payment_id'))
                        ->where('a.account_id = ?',$accountId)
                        ->where('a.rec_payment_status = 2 AND (a.recordstatus_id=3 or a.recordstatus_id=1)');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function TotalnoOfInstalmentPaid($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('rec_payment_id'))
                        ->where('a.account_id = ?',$accountId)
                        ->where('a.recordstatus_id=3 or a.recordstatus_id=1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchMemberName($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('B.memberfirstname'))
                        ->where('A.account_id = ?',$accountId)
                        ->join(array('B' => 'ourbank_membername'),'A.member_id=B.member_id')
                        ->where('B.recordstatus_id = 3 or B.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function recurringProductDetails($accountId,$productId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('account_id'))
                        ->where('A.account_id = "'.$accountId.'"  AND A.product_id = "'.$productId.'"')
                        ->where('A.accountstatus_id = 3 or A.accountstatus_id = 1')
                        ->join(array('B' => 'ourbank_productsofferdetails'),'A.product_id=B.offerproduct_id')
                        ->where('B.offerproduct_id = ?',$productId)
                        ->where('B.recordstatus_id = 3 or B.recordstatus_id = 1')
                        ->join(array('C' => 'ourbank_product_fixedrecurring'),'B.offerproductupdate_id=C.offerproductupdate_id')
                        ->where('C.productstatus_id = 3 or C.productstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function recurringInstalmentpayments($accountId,$InstalmentNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('rec_payment_id'))
                        ->where('a.account_id = "'.$accountId.'"  AND a.rec_payment_id = "'.$InstalmentNumber.'"');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function nextinstallmentdate($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('rec_payment_id'))
                        ->where('a.account_id = "'.$accountId.'"')
                        ->where('a.rec_payment_status = 5')
                        ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAllPaymentMode() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('paymenttype_id'))
                        ->where('a.paymenttype_id != 5');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchfreequencyofdeposit() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_frequencyofpayment'),array('a.timefrequncy_id','a.timefrequencytype'))
                        ->where('a.timefrequencytype != "One time"')
                        ->where('a.timefrequencytype != "Any time"');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function paymentUpdates($id,$accountId,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "rec_payment_id = '".$id."'";
                $where[] = "account_id = '".$accountId."'";
                $result = $this->db->update('ourbank_recurringpaydetails',$input,$where);
                $recurrpay_id=$input['rec_payment_status'];

                $select="select rec_payment_id from ourbank_recurringpaydetails  where rec_payment_status=$recurrpay_id and account_id=$accountId and (recordstatus_id=3 or recordstatus_id=1)";
                $result = $this->db->fetchAll($select);
                foreach($result  as $recuupay_id) {
                        $recirringpayment_id=$recuupay_id['rec_payment_id'];
                }
                $recirringpayment_id1=$recirringpayment_id+1;
                $where1[] = "rec_payment_id = '".$recirringpayment_id1."'";
                $where1[] = "account_id = '".$accountId."'";
                $rec_payment_status =array('rec_payment_status' =>4);
                $result = $this->db->update('ourbank_recurringpaydetails',$rec_payment_status,$where1);


        }

        public function recurringPaymentInsertion($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_recurring_payment',$input);
                return $result;
        }  

        public function grouprecurringInsert($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_groupmember_recurringtransaction',$input);
                return $result;
        }   

        public function interestperiods($productId) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select  max(period_ofrange_monthto)  from ourbank_interest_periods where offerproduct_id='$productId' AND intereststatus_id=3 ";
                $result = $this->db->fetchOne($sql);
                return $result;
        }

        public function ourbankRecurringInsertion($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert("ourbank_recurringaccounts",$input);
                return '1';
        }

        public function groupAccountInsertion($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert("ourbank_groupmembers_acccounts",$input);
                return '1';
        }

        public function ourbankRecurringInstalmentsInsertion($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert("ourbank_recurringpaydetails",$input);
                return '1';
        }

        public function previousAccountClose($status,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$status."'";
                $input1=  array ('accountstatus_id' => '5');
                $result = $this->db->update('ourbank_accounts',$input1,$where);
                $input2=  array('fixedaccountstatus_id' => '5','recordstatus_id' => '5');
                $result = $this->db->update('ourbank_recurringaccounts',$input2,$where);
                $input3=  array('rec_payment_status' => '2','recordstatus_id'=> '5');
                $result = $this->db->update('ourbank_recurringpaydetails',$input3,$where);
        }

        public function accountNumberSearch($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('a.account_number'))
                        ->where('a.account_id = ?',$accountId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function groupNamesSavingsearch($searchedAccountId) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "SELECT D.groupname,D.group_id,A.membercode,E.account_number FROM ourbank_members A,ourbank_groupaddress D,ourbank_accounts E WHERE E.account_id='$searchedAccountId' AND A.member_id=D.group_id AND E.member_id=A.member_id AND D.recordstatus_id=3 ";
                $result = $this->db->fetchAll($sql,array($searchedAccountId));
                return $result;
        }

        public function recurringaccountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$id."'";
                $result = $this->db->update('ourbank_recurringaccounts',$input,$where);
        }

        public function recurringpaydetailsChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$id."'";
                $result = $this->db->update('ourbank_recurringpaydetails',$input,$where);
        }

        public function getDelayFine() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_feedetails'),array('fee_id'))
                        ->where('a.feename = "recurrings" or a.feename = "deposit"')
                        ->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function instalmentStatus($accountId,$InstalmentNumber,$instalmentStstus) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where1[] = "account_id = '".$accountId."'";
                $where1[] = "rec_payment_id = '".$InstalmentNumber."'";
                $where1[] = "rec_payment_status != 2";
                $input3=  array('rec_payment_status' =>$instalmentStstus);
                $result1 = $this->db->update('ourbank_recurringpaydetails',$input3,$where1);
                return $result1;
        }

}
