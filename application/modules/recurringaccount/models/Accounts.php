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
class Recurringaccount_Model_Accounts extends Zend_Db_Table {
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
                    b.name as officename,
                    c.type as membertype,
                    c.id as type
                    from  
                        ourbank_member a,
                        ourbank_office b,
                        ourbank_membertypes c
                    where 
                        b.id = a.office_id  AND 
                        substr(a.membercode,5,1) = c.id AND
                        (a.name like '$membercode' '%'  or a.membercode like '$membercode' '%')
                UNION
                SELECT
                    a.id as id,
                    a.groupcode as code,
                    a.name as name,
                    b.name as officename,
                    c.type as membertype,
                    c.id as type
                    from  
                        ourbank_group a,
                        ourbank_office b,
                        ourbank_membertypes c
                    where
                        a.office_id= b.id AND
                        substr(a.groupcode,5,1) = c.id AND
                        (a.name like '$membercode' '%'  or a.groupcode like '$membercode' '%')";
 
        $result = $this->db->fetchAll($sql,array($membercode));
        return $result;
    }
    
    public function getDetails($membercode)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT 
                    b.id as id,
                    b.membercode as code,
                    b.name as name,
                    c.name as officename
                    from  
                    ourbank_member b,
                    ourbank_office c,
                    ourbank_membertypes d
                    where 
                    c.id = b.office_id  AND 
                    substr(b.membercode,5,1) = '1' AND
                    (b.membercode like '$membercode' '%') 
            UNION
                SELECT 
                    b.id as id,
                    b.groupcode as code,
                    b.name as name,
                    c.name as officename
                    from  
                    ourbank_group b,
                    ourbank_office c,
                    ourbank_membertypes d
                    where 
                    c.id = b.office_id  AND 
                    substr(b.groupcode,5,1) = '2' AND
                    (b.groupcode like '$membercode' '%')";
        $result = $db->fetchAll($sql,array($membercode));
        return $result;
    }

   public function fetchSavingsProducts($applicableto) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select name,id
                from ourbank_productsoffer 
                where applicableto = $applicableto AND  product_id in
                        (select id 
                                from ourbank_product 
                                where shortname ='rd')";
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function accountsSearch($membercode) 
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
                    (D.membercode like '$membercode' '%') AND
                    A.member_id = D.id AND 
                    substr(A.account_number,5,1) = '1' AND
                    A.product_id = B.id AND 
                    B.product_id = C.id AND 
                    C.shortname = 'rd' AND
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
                    (D.groupcode like '$membercode' '%') AND
                    A.member_id = D.id AND 
                    substr(A.account_number,5,1) = '2' AND
                    A.product_id = B.id AND 
                    B.product_id = C.id AND 
                    C.shortname = 'rd' AND
                    C.category_id = 1";
        $result = $db->fetchAll($sql,array($membercode));
        return $result;
    }
    
    public function details($productId,$memberId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
                    E.membercode as code,
                    substr(E.membercode,5,1) as typeID,
                    E.name as name,
                    F.name as officename,
                    F.id as officeid,
                    B.name as productname,
                    B.begindate as begindate,
                    B.glsubcode_id as glsubID,
                    C.minimum_deposit_amount as minbalance,
                    C.penal_Interest as mininterest
                    FROM 
                    ourbank_productsoffer B,
                    ourbank_product_fixedrecurring C,
                    ourbank_member E,
                    ourbank_office F
                    WHERE
                    (E.membercode like '$memberId' '%') AND 
                    B.id = $productId AND
                    B.id = C.productsoffer_id AND
                    F.id = E.office_id
                UNION
                SELECT 
                    E.groupcode as code,
                    substr(E.groupcode,5,1) as typeID,
                    E.name as name,
                    F.name as officename,
                    F.id as officeid,
                    B.name as productname,
                    B.begindate as begindate,
                    B.glsubcode_id as glsubID,
                    C.minimum_deposit_amount as minbalance,
                    C.penal_Interest as mininterest
                    FROM 
                    ourbank_productsoffer B,
                    ourbank_product_fixedrecurring C,
                    ourbank_group E,
                    ourbank_office F
                    WHERE
                    (E.groupcode like '$memberId' '%') AND 
                    B.id = $productId AND
                    B.id = C.productsoffer_id AND
                    F.id = E.office_id";
        $result = $db->fetchAll($sql);
        return $result;
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

    public function interestperiods($productId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  max(period_ofrange_monthto) as maxperiod 
                from ourbank_interest_periods 
                where offerproduct_id='$productId' 
                AND intereststatus_id= 3 ";
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function getInterestvalue($productId,$interestId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  Interest from ourbank_interest_periods 
                where offerproduct_id= $productId 
                AND $interestId between period_ofrange_monthfrom and period_ofrange_monthto";
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function fetchmembers($group_id) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  id,name from ourbank_member 
                where id in (select member_id from ourbank_groupmembers where id = $group_id)";
        $result = $db->fetchAll($sql);
        return $result;
    }
}
