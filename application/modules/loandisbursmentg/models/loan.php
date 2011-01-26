<?php
class Loandisbursmentg_Model_loan extends Zend_Db_Table {
	protected $_name = 'ob_accounts';

    public function searchaccounts($acc) {
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
        $result = $db->fetchAll($sql,array($acc));
        return $result;
    }
    public function activeDisburs($acc) 
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
			   count(*) as count
               FROM
               ourbank_member A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E,
               ourbank_loanaccounts F,
			   ourbank_loan_disbursement G
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
               F.account_id = D.id AND
			   D.id = G.account_id AND
			   substr(A.membercode,5,1) = E.applicableto
			   UNION
			   SELECT 
			   count(*) as count
               FROM
               ourbank_group A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E,
               ourbank_loanaccounts F,
			   ourbank_loan_disbursement G
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
               F.account_id = D.id AND
			   D.id = G.account_id AND
	           substr(A.groupcode,5,1) = E.applicableto";
        return  $db->fetchAll($sql,array($acc));
    }
    public function active($accNum)
    {
    	$db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_number = '".$accNum."'";
		$where[] = "status_id = 3";
		return $db->update('ourbank_accounts',array('status_id' =>1),$where);
    }
    
    public function getSavingGl($id) 
    {
       	$db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select 
                B.glsubcode_id,
                sum(C.amount_to_bank) - sum(C.amount_from_bank) as balance
                FROM
                ourbank_accounts A,
                ourbank_productsoffer B,
                ourbank_transaction C
                WHERE
                A.product_id=B.id AND
                A.id = C.account_id
                ";
        $result = $db->fetchAll($sql,array($id));
        return $result;
    }	
    public function glBank($id) 
    {
	$db = Zend_Db_Table::getDefaultAdapter();
	$sql = "select id from ourbank_glsubcode where substr(header,5) = $id and glcode_id = 1 ";
	$result = $db->fetchAll($sql,array());
	return $result;
    }
	public function getMember($accNum)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = "select 
				C.membercode as code,
				C.name as name,
				C.id as id
				from
				ourbank_group as A,
				ourbank_groupmembers B,
				ourbank_member C,
			    ourbank_accounts D
				where
				D.account_number = '".$accNum."' AND
				D.member_id = A.id AND
				A.id = B.id AND
				B.member_id = C.id  
				";
		return $result = $db->fetchAll($sql);
	}
	public function goupAcc($accNum,$accId,$date,$amt,$tranID)
	{
        $db = $this->getAdapter();
		$group = $this->getMember($accNum);
        foreach($group as $group) {
			// Grp loan disbursment entry
            $accdata = array('transaction_id' => $tranID,
                          'account_id' => $accId,
                          'member_id' => $group->id,
                          'disbursement_date' => 3,
						  'transacted_by' => 1,
                          'loanamount' => $amt/2);
           	$db->insert('ourbank_grouploan_disbursement',$accdata);
        }
		return true; 
	}
}
