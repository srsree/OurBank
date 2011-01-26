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
class Fixedtransaction_Model_fixedSavings extends Zend_Db_Table 
{
    protected $_name = 'ourbank_accounts';

    public function fixedAccountsSearch($membercode)
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
            ->where('f.shortname="fd"')
            ->join(array('g' => 'ourbank_fixedaccounts'),'c.id = g.account_id',array('g.account_id','g.begin_date','g.mature_date'))
            ->group(array('a.membercode'));
//         die($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
        }

        if(substr($membercode,4,1)=='2') {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_group'),array('id'),array('a.id as member_id','a.groupcode as membercode','a.name as membername'))
            ->where('a.groupcode = ?',$membercode)
            ->join(array('c' => 'ourbank_accounts'),'c.member_Id = a.id',array('c.account_number','c.membertype_id as membertype_ID'))
            ->join(array('d' => 'ourbank_productsoffer'),'d.id = c.product_id',array('d.id as product_id','d.name as offerproductname'))
            ->join(array('e' => 'ourbank_product_fixedrecurring'),'c.product_id = d.id')
            ->join(array('f' => 'ourbank_product'),'f.id = d.product_id')
            ->where('f.shortname="fd"')
            ->join(array('g' => 'ourbank_fixedaccounts'),'c.id = g.account_id',array('g.account_id','g.begin_date','g.mature_date'))
            ->group(array('a.groupcode'));
//         die($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
        }
    }

    public function fixedSearch($accountcode) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_accounts'),array('id'))
            ->where('a.account_number = ?',$accountcode)
            ->join(array('b' => 'ourbank_fixedaccounts'),'a.id = b.account_id');
//         die($select->__toString($select));

        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function groupNamesSearch($memberId) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_groupaddress'),array('a.groupname','a.group_id'))
            ->where('a.group_id = ?',$memberId)
            ->where('a.groupaccountstatus = 3 or a.groupaccountstatus = 1')
            ->join(array('b' => 'ourbank_groupmembers'),'a.group_id = b.group_id');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function individualMemberName($memberId) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_member'),array('a.name'))
            ->where('a.id = ?',$memberId);
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function accountIDSearch($memberId,$membertype) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_accounts'),array('id'))
                ->where('a.member_id = ?',$memberId)
                ->where('a.membertype_id = ?',$membertype)

            ->join(array('b' => 'ourbank_fixedaccounts'),'a.id = b.account_id')
            ->join(array('c' => 'ourbank_productsoffer'),'a.product_id = c.id',array('c.name as productname'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fixedAccountDetails($accountId) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_accounts'),array('id'),array('a.account_number','a.membertype_id','a.status_id'))
            ->where('a.id = ?',$accountId)
            ->join(array('s' => 'ourbank_member'),'a.member_id = s.id',array('s.name as membername','s.office_id'))
            ->join(array('b' => 'ourbank_fixedaccounts'),'a.id = b.account_id',array('b.begin_date','b.mature_date','b.fixed_amount','b.fixed_interest','b.recordstatus_id'))

            ->join(array('c' => 'ourbank_productsoffer'),'a.product_id = c.id',array('c.name as offerproductname','c.glsubcode_id'))
            ->join(array('d' => 'ourbank_product_fixedrecurring'),'c.id = d.productsoffer_id',array('d.penal_Interest'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function findmembertypeid($accountId) 
    {
        $select = $this->select()
            ->setIntegrityCheck(false)  
            ->join(array('a' => 'ourbank_accounts'),array('id'))
            ->where('a.id = ?',$accountId)
            ->where('a.status_id = 3 or a.status_id = 1');
// 		die($select->__toString($select));

        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function offerproductdetails($productId) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->join(array('a' => 'ourbank_productsoffer'),array('id'))
                ->where('a.id = ?',$productId)
                ->join(array('b' => 'ourbank_product_fixedrecurring'),'a.id = b.productsoffer_id');
        $result = $this->fetchAll($select);
        return $result->toArray();
// 		die($select->__toString($select));
    }

    public function groupNamesSearchs($accountId) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('c' => 'ourbank_accounts'),array('id'),array('c.account_number'))
                ->where('c.id = ?',$accountId)
                ->where('c.membertype_id = 2')
                ->join(array('a' => 'ourbank_group'),'a.id = c.member_id',array('a.id as group_id','a.groupcode','a.name as groupname'))
                ->join(array('b' => 'ourbank_groupmembers'),'b.id = a.id')
                ->join(array('d' => 'ourbank_member'),'d.id = b.member_id',array('d.membercode','d.name','d.id'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchGroupAccountMembers($accountNumber,$groupid) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                ->where('a.member_id = ?',$groupid)
                ->where('a.account_number = ?',$accountNumber)
                ->where('a.status_id = 3 or a.status_id = 1')
                ->join(array('b' => 'ourbank_groupmembers_acccounts'),'a.account_id = b.groupaccount_id')
                ->where('b.groupmember_account_status = 3 or b.groupmember_account_status = 1')
                ->join(array('c' => 'ourbank_members'),'b.groupmember_id = c.member_id')
                ->join(array('d' => 'ourbank_membername'),'c.member_id = d.member_id')
                ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1');
        $result = $this->fetchAll($select);
        return $result->toArray();
// 		die($select->__toString($select));
    }

    public function fetchAll_paymenttype() 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ourbank_paymenttypes'),array('id'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fixedAccountinformation($accountId) {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                ->where('a.account_id = ?',$accountId)
                ->where('a.status_id = 3 or a.status_id = 1')
                ->join(array('b' => 'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                ->join(array('c' => 'ourbank_productdetails'),'b.product_id = c.product_id')
                ->where('c.recordstatus_id = 3 or c.recordstatus_id = 1')
                ->join(array('d' => 'ourbank_categorydetails'),'c.category_id = d.category_id')
                ->where('d.recordstatus_id = 3 or d.recordstatus_id = 1')
                ->join(array('e' => 'ourbank_members'),'a.member_id = e.member_id');
        $result = $this->fetchAll($select);
        return $result->toArray();
// 		die($select->__toString($select));
    }

        public function fetchpersnolfixedGroupDetails($accountNumber,$categoryType)
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "SELECT * FROM ourbank_members A,ourbank_groupaddress H,ourbank_accounts C,
                                                        ourbank_productdetails D,ourbank_categorydetails E,ourbank_productsofferdetails F,ourbank_membertypes T,ourbank_officenames L
                                WHERE C.account_number = '$accountNumber' 
                                AND A.member_id = H.group_id 
                                AND A.member_id = C.member_id
                                AND C.product_id = F.offerproduct_id 
                                AND F.product_id = D.product_id 
                                AND D.category_id = E.category_id 
                                AND A.memberbranch_id = L.office_id 
                                AND (H.recordstatus_id=3 OR H.recordstatus_id=1) 
                                AND (L.recordstatus_id=3 OR L.recordstatus_id=1)
                                AND (C.status_id=1 OR C.status_id=3)
                                AND C.membertype_id='3'
                                AND A.membertype_ID='3'
                                AND (D.recordstatus_id=3 OR D.recordstatus_id=1)
                                AND (F.recordstatus_id=3 OR F.recordstatus_id=1)
                                AND (E.recordstatus_id=3 OR E.recordstatus_id=1)
                                AND D.category_id='$categoryType'
                                AND A.membertype_ID=T.membertype_id";
        $result = $this->db->fetchAll($sql);
                return $result;

    }

        public function findstatus($accountstatus) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id = ?',$accountstatus);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchAllStatusDetails($accountStatusId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id != ?',$accountStatusId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fixedstatus($accountStatusId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
                        ->where('a.recordstatus_id != ?',$accountStatusId)
                        ->where('a.recordstatus_id != 3 AND a.recordstatus_id != 5');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchLoanDisbursementDetails($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_loan_disbursement'),array('loandisbursement_id'))
                        ->where('a.account_id = ?',$accountId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function fetchLoanAccountDetails($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('C' => 'ourbank_accounts'),array('account_id'))
                        ->where('C.account_number = ?',$accountNumber)
                        ->join(array('D' => 'ourbank_loanaccounts'),'C.account_id=D.account_id')
                        ->where('D.loanstatus_id = 3 or D.loanstatus_id = 1')
                        ->where('D.recordstatus_id = 3 or D.recordstatus_id = 1')
                        ->join(array('E' => 'ourbank_loan_disbursement'),'C.account_id=E.account_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function noOfInstalmentPaied($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
                        ->where('a.account_id = ?',$accountId)
                        ->where('a.installment_status = 2');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function loanInstalmentDetails($accountId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_installmentdetails'))
                        ->where('A.account_id = ?',$accountId)
                        ->where('A.installment_status = 3 or A.installment_status = 4 or A.installment_status = 5 or A.installment_status = 2')
                        ->join(array('B' => 'ourbank_loanaccounts'),'B.account_id=A.account_id')
                        ->join(array('D' => 'ourbank_loan_disbursement'),'B.account_id=D.account_id')
                        ->join(array('S' => 'ourbank_installmentstatus'),'A.installment_status=S.installmentstatus_id');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function feeFetch() {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_feedetails'),array('a.feevalue','a.feename'))
                        ->where('a.fee_action_id = 2')
                        ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function interestperiods($productId) 
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "select  max(period_ofrange_monthto)  from ourbank_interest_periods where offerproduct_id='$productId' AND intereststatus_id=3 ";
                $result = $this->db->fetchOne($sql);
                return $result;
        }

        public function interestFromUrl($productId,$country) 
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql = "SELECT A.interest  FROM  ourbank_interest_periods A,ourbank_productsofferdetails B WHERE A.period_ofrange_monthfrom <=$country AND A.period_ofrange_monthto >='$country' AND B.offerproduct_id=$productId AND A.offerproduct_id=B.offerproduct_id AND A.intereststatus_id=3";
                $result = $this->db->fetchOne($sql,array($productId));
                return $result;
        }

        public function savingsAccountsSearch($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('id'))
                        ->where('A.id = ?',$accountNumber)
                        ->where('A.status_id = 3 or A.status_id = 1')
                        ->join(array('B' => 'ourbank_productsoffer'),'A.product_id=B.id')
                        ->join(array('D' => 'ourbank_product'),'B.product_id=D.id')
                        ->where('D.shortname = "fd"');
// 		die($select->__toString($select));
                $result = $this->fetchAll($select);
                return $result->toArray();

        }

        public function transferaccountid($accountNumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('id'))
                        ->where('a.id = ?',$accountNumber)
                        ->join(array('b' => 'ourbank_productsoffer'),'a.product_id=b.id');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function updateaccountnumber($accountid,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "id = '".$accountid."'";
                $where[] = "status_id = '1'";
                $result = $this->db->update('ourbank_accounts',$input,$where);
        }

        public function updatefixedaccountnumber($accountid,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$accountid."'";
                $where[] = "fixedaccountstatus_id = '1'";
                $where[] = "recordstatus_id = '1'";
                $result = $this->db->update('ourbank_fixedaccounts',$input,$where);
        }

        public function updategroupaccountnumber($accountid,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "groupaccount_id = '".$accountid."'";
                $where[] = "groupmember_account_status = '1'";
                $result = $this->db->update('ourbank_groupmembers_acccounts',$input,$where);
        }

        public function transactionInsert($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_transaction',$input);
                return $this->db->lastInsertId('ourbank_transaction');
    }

        public function insertfixedsavingstransactionDetails($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert('ourbank_fixed_payment',$input);
                return '1';
        }

        public function groupfixedInsert($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_groupmember_recurringtransaction',$input);
                return $result;
        }

        public function fetchBranchAccount($accountid) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('account_id'))
                        ->where('A.account_id = ?',$accountid)
                        ->join(array('B' => 'ourbank_members'),'A.member_id=B.member_id ')
                        ->join(array('C' => 'ourbank_bankaccounts'),'B.memberbranch_id=C.bank_branch_id',array('C.bankaccont_id'));
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function bankAccountInsert($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_bankcapitalaccount',$input);
                return $result;
        }

        public function bankFeeInsert($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result=  $this->db->insert('ourbank_bankfeeaccount',$input);
                return $result;
        }

        public function bankInterestInsert($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result=  $this->db->insert('ourbank_bankinterstaccount',$input);
                return $result;
        }

        public function insertpersnolsavingstransactionDetails($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert('ourbank_savings_transaction',$input);
                return '1';
        }

        public function groupNamesSavingsearch($transaferaccount_id) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('E' => 'ourbank_accounts'),array('E.account_number'))
                        ->where('E.account_id = ?',$transaferaccount_id)
                        ->join(array('A' => 'ourbank_members'),'E.member_id=A.member_id')
                        ->join(array('D' => 'ourbank_groupaddress'),'A.member_id=D.group_id',array('D.groupname','D.group_id'))
                        ->where('D.recordstatus_id = 3 or D.recordstatus_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }
        public function groupsavingsinsert($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_groupmember_savingstransaction',$input);
                return $result;
        }

        public function fetchBranchAccountnew($transaferaccount_id) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('A' => 'ourbank_accounts'),array('account_id'))
                        ->where('A.account_id = ?',$transaferaccount_id)
                        ->join(array('B' => 'ourbank_members'),'A.member_id=B.member_id')
                        ->join(array('C' => 'ourbank_bankaccounts'),'B.memberbranch_id=C.bank_branch_id',array('C.bankaccont_id'));
                $result = $this->fetchAll($select);
                return $result->toArray();
// 		die($select->__toString($select));
        }

        public function anyLoanAccountExist($membershipid)
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $sql="SELECT  *
                FROM ourbank_members C
                JOIN  ourbank_membername D
                USING ( member_id )
                JOIN ourbank_accounts E
                USING ( member_id )
                JOIN ourbank_productsofferdetails F
        ON ( E.product_id=F.offerproduct_id ) 
                JOIN ourbank_productdetails P
        ON ( F.product_id=P.product_id ) 
                JOIN ourbank_categorydetails G
                ON ( P.category_id=G.category_id ) 
                Where 
                C.membercode='$membershipid'
                AND (D.recordstatus_id=3 OR D.recordstatus_id=1)
                AND (G.recordstatus_id=3 OR G.recordstatus_id=1)
                AND (F.recordstatus_id=3 OR F.recordstatus_id=1)
                AND (P.recordstatus_id=3 Or P.recordstatus_id=1)
                AND G.category_id='2'
                AND (E.status_id=1 Or E.status_id=1)";
        $result = $this->db->fetchAll($sql);
                return $result;
        }

        public function accountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "id = '".$id."'";
                $result = $this->db->update('ourbank_accounts',$input,$where);
        }

        public function fixedaccountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$id."'";
                $result = $this->db->update('ourbank_fixedaccounts',$input,$where);
        }

        public function fixedgroupaccountaccountstatusChange($id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "groupaccount_id = '".$id."'";
                $result = $this->db->update('ourbank_groupmembers_acccounts',$input,$where);
        }

        public function transferaccount_Id($accountnumber) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_accounts'),array('account_id'))
                        ->where('a.account_number = ?',$accountnumber)
                        ->where('a.status_id = 3 or a.status_id = 1');
                $result = $this->fetchAll($select);
                return $result->toArray();
        }


        public function insertAccount($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert('ourbank_accounts',$input);
                $result = $this->db->lastInsertId('ourbank_accounts');
                return $result;
        }

        public function accountnumber($memberId) {
                $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_members'),array('member_id'))
                        ->where('a.member_id = ?',$memberId);
                $result = $this->fetchAll($select);
                return $result->toArray();
        }

        public function updateRow($lastaccountinsertedId,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "account_id = '".$lastaccountinsertedId."'";
                $result = $this->db->update('ourbank_accounts',$input,$where);
        }

        public function ourbankFixedInsertion($input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->insert("ourbank_fixedaccounts",$input);
                return '1';
        }

        public function groupAccountInsertion($input = array())
        {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $result = $this->db->insert('ourbank_groupmembers_acccounts',$input);
                return $result;
        }
}
