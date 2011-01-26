<?php
class Loandetailsg_Model_loandetails extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

    public function searchaccounts($acc) 
	{
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT 
               A.name as name,
               B.name as officename,
               B.id as officeid,
               A.membercode as code,
               D.account_number as number,
               D.id as accId,
               E.name as loanname,
               E.glsubcode_id as gl,
               F.loan_amount as amount,
               F.loan_installments as installments,
               substr(A.membercode,5,1) as type,
               DATE_FORMAT(F.loansanctioned_date, '%d/%m/%Y') as sanctioned,
               F.loan_interest as interest,
               F.interesttype_id as interesttype,
               F.savingsaccount_id as sAccId
               FROM
               ourbank_member A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E,
               ourbank_loanaccounts F
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
               F.account_id = D.id AND
				substr(A.membercode,5,1) = E.applicableto
				UNION
				SELECT 
               A.name as name,
               B.name as officename,
               B.id as officeid,
               A.groupcode as code,
               D.account_number as number,
               D.id as accId,
               E.name as loanname,
               E.glsubcode_id as gl,
               F.loan_amount as amount,
               F.loan_installments as installments,
               substr(A.groupcode,5,1) as type,
               DATE_FORMAT(F.loansanctioned_date, '%d/%m/%Y') as sanctioned,
               F.loan_interest as interest,
               F.interesttype_id as interesttype,
               F.savingsaccount_id as sAccId
               FROM
               ourbank_group A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E,
               ourbank_loanaccounts F
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
               F.account_id = D.id AND
	       substr(A.groupcode,5,1) = E.applicableto";
				//echo $sql;
        $result = $db->fetchAll($sql,array($acc));
        return $result;
    }

	public function loanInstalments($accNum) 
	{
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('A' => 'ourbank_accounts'),array('id'))
			->join(array('B' => 'ourbank_installmentdetails'),'A.id = B.account_id')
			->join(array('C' => 'ourbank_installmentstatus'),'B.installment_status = C.id')
			->where('A.account_number = ?',$accNum);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	public function paid($accNum) 
	{
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$sql="SELECT 
               count(*) as paidCount,
               sum(A.installment_amount) as paidAmt
               FROM
               ourbank_installmentdetails A,
               ourbank_accounts B
               WHERE
               B.account_number = '$accNum' AND
               B.id = A.account_id AND 
               A.installment_status = 2 ";
		return $db->fetchAll($sql);
	}
	public function unpaid($accNum) 
	{
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$sql="SELECT 
               count(*) as unpaidCount,
               sum(A.installment_amount) as unpaidAmt
               FROM
               ourbank_installmentdetails A,
               ourbank_accounts B
               WHERE
               B.account_number = '$accNum' AND
               B.id = A.account_id AND 
               (A.installment_status = 3 OR
			   A.installment_status = 4)";
		return $db->fetchAll($sql);
	}
}
