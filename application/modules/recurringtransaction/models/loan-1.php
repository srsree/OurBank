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
class Transaction_Model_loan extends Zend_Db_Table {
	protected $_name = 'ourbank_accounts';

	public function loancategory() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_categorydetails'),array('category_id'))
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->where('a.category_id = 2');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}



	public function search($accountNumber,$categoryType) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_members'),array('member_id'))
			->join(array('E' => 'ourbank_accounts'),'C.member_id=E.member_id')
			->where('E.account_number = ?',$accountNumber)
			->where('E.accountstatus_id = 3 or E.accountstatus_id = 1')
			->join(array('F' => 'ourbank_productsofferdetails'),'E.product_id=F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('P' => 'ourbank_productdetails'),'F.product_id=P.product_id')
			->where('P.category_id = ?',$categoryType)
			->where('P.recordstatus_id = 3 or P.recordstatus_id = 1')
			->join(array('G' => 'ourbank_categorydetails'),'P.category_id=G.category_id')
			->where('G.recordstatus_id = 3 or G.recordstatus_id = 1')
			->join(array('T' => 'ourbank_membertypes'),'C.membertype_ID=T.membertype_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function fetchDetails($accountNumber,$categoryType) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_members'),array('member_id'))
			->join(array('D' => 'ourbank_membername'),'C.member_id=D.member_id')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1')
			->join(array('E' => 'ourbank_accounts'),'C.member_id=E.member_id')
			->where('E.account_number = ?',$accountNumber)
			->where('E.accountstatus_id = 3 or E.accountstatus_id = 1')
			->where('E.membertype_id = 4')
			->join(array('F' => 'ourbank_productsofferdetails'),'E.product_id=F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('P' => 'ourbank_productdetails'),'F.product_id=P.product_id')
			->where('P.recordstatus_id = 3 or P.recordstatus_id = 1')
			->where('P.category_id = ?',$categoryType)
			->join(array('G' => 'ourbank_categorydetails'),'P.category_id=G.category_id')
			->where('G.recordstatus_id = 3 or G.recordstatus_id = 1')
			->join(array('T' => 'ourbank_membertypes'),'C.membertype_ID=T.membertype_id')
			->join(array('O' => 'ourbank_officenames'),'C.memberbranch_id=O.office_id')
			->where('O.recordstatus_id = 3 or O.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function fetchGroupDetails($accountNumber,$categoryType) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ourbank_members'),array('member_id'))
			->where('A.membertype_ID = 3')
			->join(array('H' => 'ourbank_groupaddress'),'A.member_id = H.group_id')
			->where('H.recordstatus_id = 3 or H.recordstatus_id = 1')
			->join(array('C' => 'ourbank_accounts'),'A.member_id = C.member_id')
			->where('C.account_number = ?',$accountNumber)
			->where('C.accountstatus_id = 3 or C.accountstatus_id = 1')
			->where('C.membertype_id = 3')
			->join(array('F' => 'ourbank_productsofferdetails'),'C.product_id = F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('D' => 'ourbank_productdetails'),'F.product_id = D.product_id')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1')
			->where('D.category_id = ?',$categoryType)
			->join(array('E' => 'ourbank_categorydetails'),'D.category_id = E.category_id')
			->where('E.recordstatus_id = 3 or E.recordstatus_id = 1')
			->join(array('T' => 'ourbank_membertypes'),'A.membertype_ID=T.membertype_id')
			->join(array('O' => 'ourbank_officenames'),'A.memberbranch_id=O.office_id')
			->where('O.recordstatus_id = 3 or O.recordstatus_id = 1');;
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function fetchAccountDetails($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('E' => 'ourbank_accounts'),array('account_id'))
			->where('E.account_number = ?',$accountNumber)
			->where('E.membertype_id = 4')
			->where('E.accountstatus_id = 3 or E.accountstatus_id = 1')
			->join(array('F' => 'ourbank_productsofferdetails'),'E.product_id=F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('P' => 'ourbank_productdetails'),'F.product_id=P.product_id')
			->where('P.recordstatus_id = 3 or P.recordstatus_id = 1')
			->join(array('G' => 'ourbank_categorydetails'),'P.category_id=G.category_id')
			->where('G.recordstatus_id = 3 or G.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function fetchGroupAccountDetails($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ourbank_members'),array('member_id'))
			->join(array('H' => 'ourbank_groupmembers'),'A.member_id=H.group_id')
			->join(array('I' => 'ourbank_groupaddress'),'H.group_id=I.group_id')
			->join(array('E' => 'ourbank_accounts'),'H.group_id=E.member_id')
			->where('E.account_number = ?',$accountNumber)
			->where('E.membertype_id = 3')
			->where('E.accountstatus_id = 3 or E.accountstatus_id = 1')
			->join(array('F' => 'ourbank_productsofferdetails'),'E.product_id=F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('P' => 'ourbank_productdetails'),'F.product_id=P.product_id')
			->where('P.recordstatus_id = 3 or P.recordstatus_id = 1')
			->join(array('G' => 'ourbank_categorydetails'),'P.category_id=G.category_id')
			->where('G.recordstatus_id = 3 or G.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function fetchLoanDisbursementDetails($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_loan_disbursement'),array('transaction_id'))
			->where('a.account_id = ?',$accountNumber);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchLoanDetails($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_accounts'),array('account_id'))
			->where('C.account_number = ?',$accountNumber)
			->where('C.accountstatus_id = 3 or C.accountstatus_id = 1')
			->join(array('D' => 'ourbank_loanaccounts'),'C.account_id=D.account_id')
			->where('D.loanstatus_id = 3 or D.loanstatus_id = 1')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function groupsavingsAccountDetails($memberid) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_groupmembers'),array('group_id'))
			->where('a.group_id = ?',$memberid)
			->join(array('b' => 'ourbank_members'),'a.member_id = b.member_id',array('b.membercode'))
			->join(array('c' => 'ourbank_membername'),'b.member_id = c.member_id',array('c.memberfirstname'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchsavingsAccountDetails($savingsaccountid) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_accounts'),array('C.account_number','C.member_id','C.membertype_id'))
			->where('C.account_id = ?',$savingsaccountid)
			->where('C.accountstatus_id = 3 or C.accountstatus_id = 1')
			->join(array('D' => 'ourbank_members'),'C.member_id=D.member_id')
			->where('D.member_status = 3 or D.member_status = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchLoanAccountDetails($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_accounts'),array('account_id'))
			->where('C.account_number = ?',$accountNumber)
			->where('C.accountstatus_id = 3 or C.accountstatus_id = 1')
			->join(array('D' => 'ourbank_loanaccounts'),'C.account_id=D.account_id')
			->where('D.loanstatus_id = 3 or D.loanstatus_id = 1')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1')
			->join(array('E' => 'ourbank_loan_disbursement'),'C.account_id=E.account_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchLoanAmount($accountNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_accounts'),array('account_id'))
			->where('C.account_number = ?',$accountNumber)
			->where('C.accountstatus_id = 3 or C.accountstatus_id = 1')
			->join(array('D' => 'ourbank_loanaccounts'),'C.account_id=D.account_id',array('D.loan_amount','D.loansanctioned_date'))
			->where('D.loanstatus_id = 3 or D.loanstatus_id = 1')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchlastLoandisbursed($accountid) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_loan_disbursement'),array('loandisbursement_id'))
			->where('C.account_id = ?',$accountid)
			->where('C.recordstatus_id = 3 or C.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}


	public function totalLoanAmount($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT SUM(amount_disbursed) amountdisbursed FROM ourbank_loan_disbursement where account_id=$accountid";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function updateaccountnumber($accountid,$input = array()) 
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$accountid."'";
		$where[] = "accountstatus_id = '3'";
		$result = $this->db->update('ourbank_accounts',$input,$where);
	}

	public function updateloanaccountnumber($accountid,$input = array()) 
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$accountid."'";
		$where[] = "loanstatus_id  = '3'";
		$where[] = "recordstatus_id = '3'";
		$result = $this->db->update('ourbank_loanaccounts',$input,$where);
	}

	public function disbursementInsertion($input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert("ourbank_loan_disbursement",$input);
		return '1';
	} 

	public function loanInstallmentInsertion($input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$result = $this->db->insert('ourbank_installmentdetails',$input);
		return $result;
	}

	public function eachMemberLoanDisbursementInsertion($input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
	$result = $this->db->insert('ourbank_groupmemberloan_disbursement',$input);
	return $result;
    }

	public function totalinstallmentAmount($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT SUM(accountinstallment_amount) installmentsamounts FROM ourbank_installmentdetails where account_id=$accountid AND (installment_status!=2 AND installment_status!=7) AND recordstatus_id=3";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function firstinstallmentid($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT accountinstallment_id FROM ourbank_installmentdetails  where (account_id=$accountid AND (installment_status!=2 AND installment_status!=7) AND recordstatus_id=3)LIMIT 1";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function totalinstallmentpaid($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT COUNT(accountinstallment_id) installmentpaid FROM ourbank_installmentdetails where account_id=$accountid AND installment_status=2";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function totalinstallmentpaidforlastdisbursment($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT COUNT(accountinstallment_id) installmentpaid FROM ourbank_installmentdetails where account_id=$accountid AND installment_status=2 AND recordstatus_id=3";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function lastinstallmentdate($accountid) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT accountinstallment_date FROM ourbank_installmentdetails where account_id=$accountid AND installment_status=2 ";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function updateinstallment($accountid,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$accountid."'";
		$where[] = "installment_status  != '2'";
		$result = $this->db->update('ourbank_installmentdetails',$input,$where);
	}

	public function updaterecordstatus($accountid,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$accountid."'";
		$result = $this->db->update('ourbank_installmentdetails',$input,$where);
	}



	public function gracePeriodNumber($accountNumber) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql="SELECT  L.graceperiodnumber
				FROM ourbank_accounts E 
				JOIN ourbank_productsofferdetails F
				ON ( E.product_id=F.offerproduct_id ) 
				JOIN ourbank_productdetails P
				ON ( F.product_id=P.product_id ) 
				JOIN ourbank_categorydetails G
				ON ( P.category_id=G.category_id ) 
				JOIN ourbank_productsloan L
				USING ( offerproductupdate_id ) 
				Where 
				E.account_number='$accountNumber'
				AND (E.accountstatus_id=3 OR E.accountstatus_id=1)
				AND (P.recordstatus_id=3 or P.recordstatus_id=1)
				AND (F.recordstatus_id=3 or F.recordstatus_id=1)
				AND (G.recordstatus_id=3 or G.recordstatus_id=1)
				AND E.membertype_id='4'";
				$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function overDueInstalment($accountId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
			->where('a.account_id = ?',$accountId)
			->where('a.installment_status = 5')
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function loanNextInstalmentDetails($accountId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
			->where('A.account_id = ?',$accountId)
			->where('A.installment_status = 4')
			->join(array('B' => 'ourbank_loanaccounts'),'A.account_id=B.account_id')
			->join(array('D' => 'ourbank_loan_disbursement'),'B.account_id=D.account_id')
			->join(array('S' => 'ourbank_installmentstatus'),'A.installment_status=S.installmentstatus_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
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
			->join(array('A' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
			->where('A.account_id = ?',$accountId)
			->where('A.installment_status = 4 or A.installment_status=3 or A.installment_status=5 or A.installment_status=2')
			->join(array('B' => 'ourbank_loanaccounts'),'A.account_id=B.account_id')
			->join(array('D' => 'ourbank_loan_disbursement'),'B.account_id=D.account_id')
			->join(array('S' => 'ourbank_installmentstatus'),'A.installment_status=S.installmentstatus_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function loanstilltopay($accountId) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT SUM(accountinstallment_amount) stilltopayamount FROM ourbank_installmentdetails where account_id=$accountId AND (installment_status = 4 or installment_status=3 or installment_status=5 or installment_status=6) AND recordstatus_id=3";
		$result = $this->db->fetchAll($sql);
		return $result;
	}


	public function loanInstalmentDetailsOfInstalmentNo($accountId,$InstalmentNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
			->where('a.account_id = ?',$accountId)
			->where('a.accountinstallment_id = ?',$InstalmentNumber);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function loanInstalmentPaid($accountId,$InstalmentNumber) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_loan_repayment'),array('loanrepayment_id'))
			->where('a.account_id = ?',$accountId)
			->where('a.loaninstallment_number = ?',$InstalmentNumber);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getDelayFine() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('fee_id'))
			->where('a.feename = "loanrepayment"')
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function instalmentStatus($accountId,$InstalmentNumber,$status) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where1[] = "account_id = '".$accountId."'";
		$where1[] = "accountinstallment_id = '".$InstalmentNumber."'";
		$where1[] = "installment_status != 2";
		$input3=  array('installment_status' =>$status);
		$result1 = $this->db->update('ourbank_installmentdetails',$input3,$where1);
		return $result1;
	}

	public function loanInstalments($accountId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ourbank_installmentdetails'),array('Installmentserial_id'))
			->where('A.account_id = ?',$accountId)
			->where('A.installment_status = 3 OR A.installment_status =4 OR A.installment_status =2 OR A.installment_status =5')
			->where('A.recordstatus_id = 3 OR A.recordstatus_id =1')
			->join(array('B' => 'ourbank_installmentstatus'),'A.installment_status=B.installmentstatus_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function selectinstallment($accountid,$installmentstatus) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT accountinstallment_interest_amount,installment_principal_amount FROM ourbank_installmentdetails where (account_id=$accountid AND installment_status=$installmentstatus AND (recordstatus_id=3 or recordstatus_id=1)) LIMIT 1";
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	public function loanRepaymentInsert($input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$result = $this->db->insert('ourbank_loan_repayment',$input);
		$result=$this->db->lastInsertId('ourbank_loan_repayment');
		$where[] = "account_id = '".$input['account_id']."'";
		$where[] = "accountinstallment_id = '".$input['loaninstallment_number']."' AND recordstatus_id = '3'";
		$input2=  array('installment_status' => '2');
		$result1 = $this->db->update('ourbank_installmentdetails',$input2,$where);
		$where1[] = "account_id = '".$input['account_id']."'";
		$nextInsralment=$input['loaninstallment_number']+1;
		$where1[] = "accountinstallment_id = '".$nextInsralment."' AND recordstatus_id = '3'";

		$input3=  array('installment_status' => '4');
		$result1 = $this->db->update('ourbank_installmentdetails',$input3,$where1);
		return $result;
	}

	public function eachMemberLoanRepaymentInsert($input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$result = $this->db->insert('ourbank_groupmemberloan_repayment',$input);
		return $result;
	}

	public function fetchloanStatusDetails($accountStatusId) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_Recordstatus'),array('recordstatus_id'))
			->where('a.recordstatus_id != ?',$accountStatusId)
			->where('a.recordstatus_id != 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function anyLoanAccountExist($membershipid) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('C' => 'ourbank_members'),array('member_id'))
			->where('C.membercode = ?',$membershipid)
			->join(array('D' => 'ourbank_membername'),'C.member_id=D.member_id')
			->where('D.recordstatus_id = 3 or D.recordstatus_id = 1')
			->join(array('E' => 'ourbank_accounts'),'C.member_id=E.member_id')
			->where('E.accountstatus_id = 3 or E.accountstatus_id = 1')
			->join(array('F' => 'ourbank_productsofferdetails'),'E.product_id=F.offerproduct_id')
			->where('F.recordstatus_id = 3 or F.recordstatus_id = 1')
			->join(array('P' => 'ourbank_productdetails'),'F.product_id=P.product_id')
			->where('P.recordstatus_id = 3 or P.recordstatus_id = 1')
			->join(array('G' => 'ourbank_categorydetails'),'P.category_id=G.category_id')
			->where('G.category_id = 2')
			->where('G.recordstatus_id = 3 or G.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
// 		die($select->__toString($select));
	}

	public function updatemainaccountstatus($account,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$account."'";
		$result = $this->db->update('ourbank_accounts',$input,$where);
	}

	public function updateloanaccountstatus($account,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$account."'";
		$result = $this->db->update('ourbank_loanaccounts',$input,$where);
	}


	public function updategroupmemberloanaccountstatus($account,$input = array()) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "groupaccount_id = '".$account."'";
		$result = $this->db->update('ourbank_groupmembers_acccounts',$input,$where);
	}

}
