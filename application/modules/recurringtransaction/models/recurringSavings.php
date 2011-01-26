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
class Recurringtransaction_Model_recurringSavings extends Zend_Db_Table {
    protected $_name = 'ourbank_accounts';

    public function recurringAccountsSearch($membercode) 
    {
        if(substr($membercode,4,1)=='1') {
            $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ourbank_member'),array('id'),array('a.id as member_id','a.membercode','a.name as membername'))
                ->where('a.membercode = ?',$membercode)
                ->join(array('c' => 'ourbank_accounts'),'c.member_Id = a.id',array('c.account_number','c.membertype_id as membertype_ID'))
                ->join(array('d' => 'ourbank_productsoffer'),'d.id = c.product_id',array('d.id as product_id','d.name as offerproductname'))
                ->join(array('e' => 'ourbank_product_fixedrecurring'),'e.productsoffer_id = d.id')
                ->join(array('f' => 'ourbank_product'),'f.id = d.product_id')
                ->where('f.shortname="rd"')
                ->join(array('g' => 'ourbank_recurringaccounts'),'c.id = g.account_id',array('g.account_id','g.begin_date','g.mature_date'))
                ->group(array('a.membercode'));
    //         die($select->__toString($select));
            $result = $this->fetchAll($select);
            return $result->toArray();
        }
    }

        public function groupNamesSearch($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_group'),array('id'),array('a.name as groupname','a.id as group_id'))
                        ->where('a.id = ?',$memberId)
                        ->join(array('b' => 'ourbank_groupmembers'),'a.id = b.id')
                        ->join(array('c' => 'ourbank_member'),'b.member_id = c.id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function individualMemberName($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_member'),array('a.name'))
                        ->where('a.id = ?',$memberId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }


        public function recurringmemberbranchid($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('id'))
                        ->where('A.id = ?',$accountId)

                        ->join(array('B' => 'ourbank_member'),'A.member_id=B.id',array('B.name as memberfirstname','B.office_id'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function accountIDSearch($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.member_id = ?',$memberId)
                        ->where('a.status_id = 3 or a.status_id = 1')
                        ->join(array('b' => 'ourbank_recurringaccounts'),'a.id = b.account_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function recurringSearch($accountcode) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.account_number = ?',$accountcode)

                        ->join(array('b' => 'ourbank_recurringaccounts'),'a.id = b.account_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

    public function installmentsDetails($accountId,$productId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
            $sql = "select * from ourbank_recurringpaydetails A,
                                    ourbank_product_fixedrecurring B,
                                    ourbank_productsoffer C,
                                    ourbank_installmentstatus D 
                    where (A.account_id ='$accountId') AND 
                                    (C.id='$productId') AND
                                    (A.rec_payment_status=D.id) AND
                                    (C.id=B.productsoffer_id)";
        $result = $this->db->fetchAll($sql,array($accountId));
        return $result;
    }

    public function recurringAccountDetails($accountId,$productId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
            $sql = "select A.begin_date,A.mature_date,A.recurring_amount,A.fixed_interest,B.name as offerproductname,D.name as productname,E.membertype_id,B.glsubcode_id,C.penal_Interest,E.status_id
                    from ourbank_recurringaccounts A,
                            ourbank_productsoffer B,
                            ourbank_product_fixedrecurring C,
                            ourbank_product D,
                            ourbank_accounts E
                    where (A.account_id ='$accountId') AND
                            (B.id = '$productId') AND
                            (C.productsoffer_id = B.product_id) AND
                            (D.id = B.product_id) AND 
                            (A.account_id=E.id)";
        $result = $this->db->fetchAll($sql,array($accountId));
        return $result;
    }

        public function recurringPaidDetails($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurring_payment'),array('rec_paymentserial_id'))
                        ->where('a.account_id = ?',$accountId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function noOfInstalmentPaid($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('paymentserial_id'))
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
                        ->where('a.recordstatus_id=3 or a.recordstatus_id=1 or a.recordstatus_id=2');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchMemberName($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('id'))
                        ->where('A.id = ?',$accountId)
                        ->join(array('B' => 'ourbank_member'),'A.member_id=B.id',array('B.name as memberfirstname'));
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function recurringProductDetails($accountId,$productId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('id'))
                        ->where('A.id = "'.$accountId.'"  AND A.product_id = "'.$productId.'"')
                        ->where('A.status_id = 3 or A.status_id = 1')
                        ->join(array('B' => 'ourbank_productsoffer'),'A.product_id=B.id')
//                         ->where('B.id = ?',$productId)

                        ->join(array('C' => 'ourbank_product_fixedrecurring'),'B.id=C.productsoffer_id');
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
                        ->where('a.rec_payment_status = 3')
                        ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAllPaymentMode() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_paymenttypes'),array('id'))
                        ->where('a.id != 5');
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
                $where[] = "rec_payment_status = '4'";
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
                $where1[] = "id = '".$status."'";
                $where[] = "account_id = '".$status."'";
                $input1=  array ('status_id' => '5');
                $result = $this->db->update('ourbank_accounts',$input1,$where1);
                $input2=  array('fixedaccountstatus_id' => '5');
                $result = $this->db->update('ourbank_recurringaccounts',$input2,$where);
                $input3=  array('rec_payment_status' => '2','recordstatus_id'=> '5');
                $result = $this->db->update('ourbank_recurringpaydetails',$input3,$where);
        }

        public function accountNumberSearch($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.id = ?',$accountId);
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

        public function depositcheck($accountId)
        {
            $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_recurringpaydetails'),array('paymentserial_id'))
                        ->where('a.account_id = ?',$accountId)
                        ->where('a.rec_payment_status = 4')
                        ->where('a.recordstatus_id = 1 or a.recordstatus_id = 3');
            $result = $this->fetchAll($select);
            return $result->toArray();
        }
        public function statuscheck($accountId)
        {
            $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.id = ?',$accountId)
                        ->where('a.status_id != 5 AND a.status_id != 4 AND a.status_id != 2');
            $result = $this->fetchAll($select);
            return $result->toArray();
        }
}
