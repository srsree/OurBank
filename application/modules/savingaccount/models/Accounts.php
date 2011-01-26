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
class Savingaccount_Model_Accounts extends Zend_Db_Table {
     protected $_name = 'ourbank_accounts';

     public function insertAccounts() 
     {
		$data = array('account_id'=> '');
		$this->insert($data);
     }

     public function UpDateAccounts($account_id,$accountNumber,$memberId,$productId,$grouporIndividualNumber,$createby) 
     {
        $data = array('account_number' =>$accountNumber,
                      'member_id' => $memberId,
                      'product_id' => $productId,
                      'membertype_id' => $grouporIndividualNumber,
                      'accountcreated_date' => date("Y-m-d"),
                      'accountcreated_by' => $createby,
                      'accountstatus_id'=> 1);
        $where = 'account_id = '.$account_id;
        $this->update($data , $where );
    }
	
    public function search($membercode) 
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT 
              a.id as id,
              a.membercode as code,
              a.name as name,
              substr(a.membercode,5,1) as type,
	      	  c.type as membertype,
              b.name as officename
              from
              ourbank_member a,
              ourbank_office b,
              ourbank_membertypes c
              where
              a.office_id= b.id and
              (a.name like '%' '$membercode' '%'  or a.membercode like '%' '$membercode' '%') AND
              substr(a.membercode,5,1) = c.id
              union
	      	  SELECT
	          a.id as id,
              a.groupcode as code,
              a.name as name,
	          substr(a.groupcode,5,1) as type,
              c.type as membertype,
              b.name as officename
              from
              ourbank_group a,
              ourbank_office b,
              ourbank_membertypes c
              where
              a.office_id= b.id and
              (a.name like '%' '$membercode' '%'  or a.groupcode like '%' '$membercode' '%') AND
              substr(a.groupcode,5,1) = c.id";
        $result = $this->db->fetchAll($sql,array($membercode));
        return $result;
    }
    
    public function getDetails($code) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT 
              a.id as id,
              a.membercode as code,
              a.name as name,
              substr(a.membercode,5,1) as type,
              c.type as membertype,
              b.name as officename
              from
              ourbank_member a,
              ourbank_office b,
              ourbank_membertypes c
              where
              a.office_id= b.id and 
              substr(a.membercode,5,1) = c.id and
              a.membercode like '%' '$code' '%'
              union
			  SELECT 
			  a.id as id,
              a.groupcode as code,
              a.name as name,
	          substr(a.groupcode,5,1) as type,
	          c.type as membertype,
              b.name as officename
              from
              ourbank_group a,
              ourbank_office b,
              ourbank_membertypes c
              where
              a.office_id= b.id and
	          substr(a.groupcode,5,1) = c.id and
              a.groupcode like '%' '$code' '%'";
        $result = $db->fetchAll($sql,array($code));
        return $result;
    }
    
    public function fetchSavingsProducts($code) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select 
                A.name as name,
                A.id as id
                from 
                ourbank_productsoffer A,
                ourbank_product B,
                ourbank_member C
                where 
                C.membercode = $code AND 
                substr(C.membercode,5,1) = A.applicableto AND 
				A.product_id = B.id AND 
				B.category_id = 1 AND
				B.shortname = 'ps'
				UNION
				select 
                A.name as name,
                A.id as id
                from 
                ourbank_productsoffer A,
                ourbank_product B,
                ourbank_group C
                where 
                C.groupcode = $code AND 
                substr(C.groupcode,5,1) = A.applicableto AND 
				A.product_id = B.id AND 
				B.category_id = 1 AND
				B.shortname = 'ps' ";

        $result = $db->fetchAll($sql,array($code));
        return $result;
    }
    
    public function accountsSearch($code) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
                A.account_number as number,
                B.name as name
                FROM
                ourbank_accounts A,
                ourbank_productsoffer B,
                ourbank_product C,
                ourbank_member D
                WHERE
                D.membercode = $code AND
 				substr(D.membercode,5,1) = A.membertype_id AND
				A.member_id = D.id AND
                A.product_id = B.id AND
                B.product_id = C.id AND
                C.category_id = 1
                UNION
                SELECT 
                A.account_number as number,
                B.name as name
                FROM
                ourbank_accounts A,
                ourbank_productsoffer B,
                ourbank_product C,
                ourbank_group D
                WHERE
                D.groupcode = $code AND
 				substr(D.groupcode,5,1) = A.membertype_id AND
				A.member_id = D.id AND
                A.product_id = B.id AND
                B.product_id = C.id AND
                C.category_id = 1";

        $result = $db->fetchAll($sql,array($code));
        return $result;
    }
    
    public function details($productId,$code) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
				E.id as id,
                E.membercode as code,
                substr(E.membercode,5,1) as typeID,
                E.name as name,
                F.name as officename,
                F.id as officeid,
                B.name as productname,
                B.begindate as begindate,
                B.glsubcode_id as glsubID,
                C.minmumdeposit as minbalance,
                C.minimumbalanceforinterest as mininterest
                FROM
                ourbank_productsoffer B,
                ourbank_productssaving C,
                ourbank_member E,
                ourbank_office F,
				ourbank_product G
                WHERE
                E.membercode = $code AND 
				E.office_id = F.id AND
                B.id = $productId AND
                B.id = C.productsoffer_id AND
				G.id = B.product_id AND
 				G.category_id = 1
                UNION
                SELECT 
				E.id as id,
                E.groupcode as code,
                substr(E.groupcode,5,1) as typeID,
                E.name as name,
                F.name as officename,
                F.id as officeid,
                B.name as productname,
                B.begindate as begindate,
                B.glsubcode_id as glsubID,
                C.minmumdeposit as minbalance,
                C.minimumbalanceforinterest as mininterest
                FROM
                ourbank_productsoffer B,
                ourbank_productssaving C,
                ourbank_group E,
                ourbank_office F,
				ourbank_product G
                WHERE
                E.groupcode = $code AND 
				E.office_id = F.id AND
                B.id = $productId AND
                B.id = C.productsoffer_id AND
				G.id = B.product_id AND
 				G.category_id = 1
                ";
        return $db->fetchAll($sql,array($productId,$code));
    }
    
    public function getInterestRates($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT
                period_ofrange_description ,
                Interest
                FROM
                ourbank_interest_periods
                WHERE
               	offerproduct_id = $id 
                ";
        $result = $db->fetchAll($sql,array($id));
        return $result;
    }
    
    public function accUpdate($accId,$input)
    {
    	$where[] = "id = '".$accId."'";
	$db = $this->getAdapter();
        $result = $db->update('ourbank_accounts',$input,$where);
    
    }
    
    public function getGlcode($officeId)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
		$sql = "select id from ourbank_glsubcode where substr(header,5)=$officeId and glcode_id=2";
		return $result = $db->fetchAll($sql);
    }

	public function getMember($officeid)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$sql = "select 
				C.id as id,
				C.name as name
				from
				ourbank_group as A,
				ourbank_groupmembers B,
				ourbank_member C
				where
				A.office_id = $officeid AND
				A.id = B.id AND
				B.member_id = C.id  
				";
		return $result = $db->fetchAll($sql);
	}

	public function goupAcc($group,$productId,$accId,$amt,$tranID,$date)
	{
        $db = $this->getAdapter();
        foreach($group as $group) {
			// Acc entry
            $accdata = array('account_id' => $accId,
                          'member_id' => $group,
                          'product_id' => $productId,
                          'status' => 3,
                          'created_by' => 1);
           	$db->insert('ourbank_group_acccounts',$accdata);
			//Grp transaction entry
           	$trandata = array('transaction_id' => $tranID,
						  	'account_id' => $accId,
						  	'transaction_date' => $date,
						  	'transaction_type' => 1,
						  	'transaction_amount' => $amt/2,
                          	'member_id' => $group,
                          	'transacted_by' => 1);
           $db->insert('ourbank_group_savingstransaction',$trandata);
        }
		return true; 
	}
}
