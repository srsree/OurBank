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

class Savingsdeposit_Model_Savingsdeposit extends Zend_Db_Table 
{
	protected $_name = 'ourbank_member';

    public function search($acc) 
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
               E.name as offername,
               E.glsubcode_id as gl,
               substr(A.membercode,5,1) as type,
               DATE_FORMAT(E.begindate, '%d/%m/%Y') as begindate,
               DATE_FORMAT(D.begin_date, '%d/%m/%Y') as createdDate
               FROM
               ourbank_member A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
			   substr(A.membercode,5,1) = E.applicableto 
			   UNION
			   SELECT 
               A.name as name,
               B.name as officename,
               B.id as officeid,
               A.groupcode as code,
               D.account_number as number,
               D.id as accId,
               E.name as offername,
               E.glsubcode_id as gl,
               substr(A.groupcode,5,1) as type,
               DATE_FORMAT(E.begindate, '%d/%m/%Y') as begindate,
               DATE_FORMAT(D.begin_date, '%d/%m/%Y') as createdDate
               FROM
               ourbank_group A,
               ourbank_office B,
               ourbank_accounts D,
               ourbank_productsoffer E
               WHERE
               (A.name = '$acc' OR D.account_number = '$acc') AND
               B.id = A.office_id AND 
               A.id = D.member_id AND 
               D.product_id = E.id AND
	           substr(A.groupcode,5,1) = E.applicableto
				";
				//echo $sql;
        $result = $db->fetchAll($sql,array($acc));
        return $result;
    }
	public function transaction($acc) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
                A.transaction_id as id,
                B.account_number as number,
                DATE_FORMAT(A.transaction_date, '%d/%m/%Y') as date,
                A.amount_to_bank as cr,
                A.amount_from_bank as dt,
                D.description as mode,
                E.name as name
                FROM 
                ourbank_transaction A,
                ourbank_accounts B,
                ourbank_paymenttypes D,
                ob_user E
                WHERE
                B.account_number  = '".$acc."' AND
                A.account_id = B.id AND
                A.paymenttype_id = D.id AND
                A.created_by = E.id  
                ORDER BY A.transaction_id DESC
                ";
        $result = $db->fetchAll($sql);
        return $result;
    }
	public function deposit($acc,$data) 
    {
		$cl = new Creditline_Model_dateConvertor ();
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$accData = $this->search($acc);
		foreach ($accData as $accData) {
			$accId = $accData->accId;
			$gl = $accData->gl;
			$officeid = $accData->officeid;
		}
		// Transaction entry
		$input = array('account_id' => $accId,
                       'glsubcode_id_to' => $gl,
                       'transaction_date' => $cl->phpmysqlformat($data["date"]),
                       'amount_to_bank' => $data["amount"],
                       'paymenttype_id' => 1,
                       'transactiontype_id' => 1,
                       'recordstatus_id' => 3,
                       'transaction_description'=> $data["description"],
                       'balance' => $data["amount"],
                       'confirmation_flag' => 0,
                       'created_by' => 1);
		$tranId = $db->insert("ourbank_transaction",$input);
		// Saving transaction entry 
        $saving = array('transaction_id' => $tranId,
      	                'account_id' => $accId,
                        'transaction_date' => $cl->phpmysqlformat($data["date"]),
                        'transactiontype_id' => 1,
						'glsubcode_id_to' => $gl,
						'amount_to_bank' => $data["amount"],
						'paymenttype_id' => 1,
						'transaction_description'=> $data["description"],
						'transaction_by' => 1);
		$db->insert('ourbank_savings_transaction',$saving);
		if (substr($acc,4,1) == 2) {
			$group = $this->getMember($acc);
			foreach ($group as $group) {
				$groupsaving = array('transaction_id' => $tranId,
									'account_id' => $accId,
									'member_id' => $group->id,
									'transaction_date' => $cl->phpmysqlformat($data["date"]),
									'transaction_amount' => $data["amount"]/2,
									'transacted_by' => 1);
				$db->insert('ourbank_group_savingstransaction',$groupsaving);
			}
		}
		// Insertion into Liabilities
		$liabilities = array('office_id' => $officeid,
							'glsubcode_id_from' => '',
							'glsubcode_id_to' => $gl,
							'transaction_id' => $tranId,
							'credit' => $data["amount"],
							'record_status'=> 3);
		$db->insert('ourbank_Liabilities',$liabilities);
		$glresult = $this->getGlcode($officeid);
		foreach ($glresult as $glresult) {
				$cashglsubocde = $glresult->id;
		}
        // Insertion into Assets ourbank_Assets
        $assets =  array('office_id' => $officeid,
						'glsubcode_id_from' => '',
						'glsubcode_id_to' => $cashglsubocde,
						'transaction_id' => $tranId,
						'credit' => $data["amount"],
						'record_status' => 3);
		$db->insert('ourbank_Assets',$assets);
	}
    public function getGlcode($officeId)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
		$sql = "select id from ourbank_glsubcode where substr(header,5)=$officeId and glcode_id=2";
		return $result = $db->fetchAll($sql);
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
}

