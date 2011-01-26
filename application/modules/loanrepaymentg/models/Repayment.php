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
class Loanrepaymentg_Model_Repayment extends Zend_Db_Table
{
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
        return $db->fetchAll($sql,array($acc));
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
	public function loanInstalments($accNum) 
	{
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$sql="SELECT 
               sum(A.installment_principal_amount) as principal,
			   sum(A.installment_interest_amount) as intrest,
               sum(A.installment_amount) as totalAmt,
			   A.installment_amount as installmentAmt,
			   A.account_id as accId
               FROM
               ourbank_installmentdetails A,
               ourbank_accounts B
               WHERE
               B.account_number = '$accNum' AND
               B.id = A.account_id AND 
               (A.installment_status = 4 OR
			   A.installment_status = 8)";
		return $db->fetchAll($sql);
	}
	public function declain($data) 
	{
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$result = $this->loanInstalments($data["accNum"]);
		foreach ($result as $result) {
			 $installmentAmt = $result->installmentAmt;
		}
		$acc = $this->searchaccounts($data["accNum"]);
		foreach ($acc as $acc) {
			 $accId = $acc->accId;
		}

		switch ($installmentAmt) {
			case $installmentAmt < $data["amount"] : 
													 break;
			case $installmentAmt = $data["amount"] : $this->update($accId);
													 
													 break;
			case $installmentAmt > $data["amount"] :
                                                     break;
		}
	}
	public function insertTran($data)
	{
        $db = Zend_Db_Table::getDefaultAdapter();
		$acc = $this->searchaccounts($data["accNum"]);
		foreach ($acc as $acc) {
			$accId = $acc->accId;
			$gl = $acc->gl;
			$officeid = $acc->officeid;
		}
		$cl = new Creditline_Model_dateConvertor ();
		$tranData= array('account_id' => $accId,
                     'glsubcode_id_to' => $gl,
                     'transaction_date' => $cl->phpmysqlformat($data["date"]),
                     'amount_to_bank' => $data["amount"],
					 'paymenttype_id' => $data["paymentMode"],
					 'recordstatus_id' => 3,
                     'transactiontype_id' => 1,
                     'transaction_description'=>$data["description"],
                     'created_by'=>1);
		$db->insert("ourbank_transaction",$tranData);
		$tranId = $db->lastInsertId('id');
		$sql = "select installment_id from ourbank_installmentdetails where account_id='".$accId."' AND installment_status = 4 limit 1";
		$idData = $db->fetchAll($sql);
		foreach ($idData as $idData) {
			$pram = $idData->installment_id;
		}
        // Insertion into Assets ourbank_Assets Cash Cr entry
     	$glresult = $this->getGlcode($officeid);
     	foreach ($glresult as $glresult) {
     		$cashglsubocde = $glresult->id;
     	}
        $assets =  array('office_id' => $officeid,
                         'glsubcode_id_from' => $cashglsubocde,
                         'glsubcode_id_to' => '',
                         'transaction_id' => $tranId,
                         'credit' => $data["amount"],
                         'record_status' => 3);
       	$db->insert('ourbank_Assets',$assets);
        // Insertion into Assets ourbank_Assets productgl Cr entry
		$glassets =  array('office_id' => $officeid,
                         'glsubcode_id_from' => $gl,
                         'glsubcode_id_to' => '',
                         'transaction_id' => $tranId,
                         'credit' => $data["amount"],
                         'record_status' => 3);
       	$db->insert('ourbank_Assets',$glassets);
//         // Insertion into Assets ourbank_Liabilities productgl Cr entry
// 		$glLia =  array('office_id' => $officeid,
//                          'glsubcode_id_from' => $gl,
//                          'glsubcode_id_to' => '',
//                          'transaction_id' => $tranId,
//                          'credit' => $data["amount"],
//                          'record_status' => 3);
//        	$db->insert('ourbank_Liabilities',$glLia);
		return array('transaction_id' => $tranId,
						'account_id' => $accId,
						'paymentMode' => $data["paymentMode"],
						'installment_id' => $accId);
	}
    public function getGlcode($officeId)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
		$sql = "select id from ourbank_glsubcode where substr(header,5)=$officeId and glcode_id=2";
		return $db->fetchAll($sql);
    }
	public function update($accId) 
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$where[] = "account_id = '".$accId."'";
		$where[] = "installment_status = 4";
		$set =  array('installment_status' => '2');
		$db->update('ourbank_installmentdetails',$set,$where);
		$sql = "select id from ourbank_installmentdetails where account_id='".$accId."' AND installment_status = 3 limit 1";
		$idData = $db->fetchAll($sql);
		foreach ($idData as $idData) {
			$pram = $idData->id;
		}
		$where1[] = "account_id = '".$accId."'";
		$where1[] = "id = '".$pram."'";
		$set1 =  array('installment_status' => '4');
		$db->update('ourbank_installmentdetails',$set1,$where1);
		return;
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
               A.installment_status = 2";
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
	public function grpRepayment($accdata)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->insert('ourbank_grouploan_repayment',$accdata);
		return;
	}
}
