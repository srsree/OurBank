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
class Accounting_Model_Savings extends Zend_Db_Table {

    public function searchMembercode($post = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT b.membertype_ID as type,
                     b.member_id as id,
                     b.membercode as code,
                     a.memberfirstname as Name,
                     c.office_name as Office 
                     from  ourbank_membername a,
                           ourbank_members b,
                           ourbank_officenames c
                     where a.member_id=b.member_id AND
                           c.office_id = a.memberoffice_id AND 
                          (a.memberfirstname like '$membercode' '%'  or b.membercode like '$membercode' '%')
                   UNION
                   select b.membertype_ID as type,
                          b.member_id as id,
                          b.membercode as code,
                          a.groupname as Name,
                          c.office_name as office 
                          from ourbank_groupaddress a,
                               ourbank_members b,
                               ourbank_officenames c
                          where b.member_id = a.group_id AND 
                                c.office_id = a.groupoffice_id AND 
                               (a.groupname like '$membercode' '%' or b.membercode like '$membercode' '%')";
        $result = $this->db->fetchAll($sql,array($membercode));
        return $result;
    }

    public function fetchMemberDetails($memberId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_members A,
                              ourbank_officenames C  
                         where A.member_id='$memberId' AND 
                               A.memberbranch_id=C.office_id AND 
                               C.recordstatus_id=3";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function fetchmemberName($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT memberfirstname FROM ourbank_membername 
                                       WHERE member_id='$memberId' AND 
                                             recordstatus_id=3";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function fetchSavingsProducts($membertypeId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select A.offerproductname,
                       B.product_id,A.offerproduct_id  
                from ourbank_productsofferdetails A,
                     ourbank_productdetails B 
                where (A.applicableto='$membertypeId' OR
                       A.applicableto = '1') AND 
                       A.recordstatus_id = 3 AND 
                      (B.recordstatus_id = 3 OR 
                       B.recordstatus_id = 1) AND
                       A.product_id=B.product_id AND 
                       B.category_id = 1";
        $result = $this->db->fetchAll($sql,array($membertypeId));
        return $result;
    }

    public function fetchGroupDetails($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_groupaddress 
                         WHERE group_id='$memberId' AND 
                               groupaccountstatus=3";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function accountsSearch($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_accounts A,
                              ourbank_productsofferdetails B,
                              ourbank_productdetails C 
                        WHERE A.member_id='$memberId' AND 
                              A.product_id=B.offerproduct_id AND 
                              B.product_id=C.product_id AND 
                              A.accountstatus_id=1 AND 
                              B.recordstatus_id=3 AND 
                             (C.recordstatus_id=3 OR
                              C.recordstatus_id = 1) AND
                              C.category_id = 1";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function fetchLoansProducts($membertypeId) {
            $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
            $sql = "select A.offerproduct_id,A.offerproductname 
                            from ourbank_productsofferdetails A,
                                 ourbank_productdetails B 
                            where (A.applicableto='$membertypeId' OR
                                   A.applicableto = '1') AND 
                                  A.recordstatus_id=3 AND 
                                  B.recordstatus_id=3 AND 
                                  A.product_id=B.product_id AND 
                                  B.category_id=2 AND
                                  A.closedate >= curdate()";
    $result = $this->db->fetchAll($sql,array($membertypeId));
    return $result;
    }

    public function accountsSearch1($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_accounts A,
                              ourbank_productsofferdetails B,
                              ourbank_productdetails C 
                        WHERE A.member_id='$memberId' AND 
                              A.product_id=B.offerproduct_id AND 
                              B.product_id=C.product_id AND 
                              A.accountstatus_id= 1 AND 
                              B.recordstatus_id=3 AND 
                             (C.recordstatus_id=3 OR
                              C.recordstatus_id = 1)AND
                              C.category_id = 2";
    $result = $this->db->fetchAll($sql,array($memberId));
    return $result;
    }

    public function loansProductsFetch($productId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from ourbank_productsofferdetails A,
                              ourbank_productsloan  B,
                              ourbank_productdetails D 
                where (A.offerproduct_id='$productId') AND 
                      (A.offerproductupdate_id=B.offerproductupdate_id)  AND 
                      (A.recordstatus_id=3) AND 
                      (A.product_id=D.product_id) AND 
                      (A.recordstatus_id=3)";
      $result = $this->db->fetchAll($sql,array($productId));
      return $result;
    }

    public function fetchingInterests($productId) {
    $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
    $sql = "select * from ourbank_interest_periods 
            where (offerproduct_id='$productId') and 
                  (intereststatus_id=3)";
    $result = $this->db->fetchAll($sql,array($productId));
    return $result;
    }

    public function interestperiods($productId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select  max(period_ofrange_monthto)  
                from ourbank_interest_periods 
                where offerproduct_id='$productId' 
                AND intereststatus_id=3 ";
        $result = $this->db->fetchOne($sql);
        return $result;
    }

    public function fetchSavingDetails($memberId,$membertypeId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_accounts A,
                              ourbank_productsofferdetails B,
                              ourbank_productdetails C 
                WHERE A.member_id='$memberId' AND
                      A.membertype_id = $membertypeId AND
                      A.product_id = B.offerproduct_id AND
                      B.recordstatus_id = '3' AND
                      B.product_id = C.product_id AND
                      C.category_id = 1 AND
                      (C.recordstatus_id = 3 OR
                       C.recordstatus_id = 3)AND
                      A.accountstatus_id = 1";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function accountnumber($memberId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from  ourbank_members  where member_id =? " ;
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function savingsProductFetch($productId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from ourbank_productsofferdetails A,
                              ourbank_product_fixedrecurring C,
                              ourbank_productdetails D
                       where (A.offerproduct_id='$productId') AND 
                             (A.offerproductupdate_id=C.offerproductupdate_id) AND 
                             (C.productstatus_id=3) AND 
                             (A.recordstatus_id=3) AND 
                             (A.product_id=D.product_id) AND
                             (A.recordstatus_id=3) AND
                             (C.productstatus_id = 3) AND
                             (D.recordstatus_id = 3 OR
                              D.recordstatus_id = 1)";
    $result = $this->db->fetchAll($sql,array($productId));
    return $result;
    }

    public function personalSavingsFetch($productId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from ourbank_productsofferdetails A,
                              ourbank_productssaving B,
                              ourbank_productdetails D
                                where (A.offerproduct_id='$productId') AND 
                                      (A.offerproductupdate_id=B.offerproductupdate_id)  AND 
                                      (A.recordstatus_id = 3 OR A.recordstatus_id = 1)  AND 
                                      (A.product_id=D.product_id)";
        $result = $this->db->fetchAll($sql,array($productId));
        return $result;
    }

    public function Loanfee() {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from  ourbank_feedetails where fee_action_id = 10 AND recordstatus_id = 3";
        $result = $this->db->fetchAll($sql,array());
        return $result;
    }

    public function Savingfee() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select * from  ourbank_feedetails where fee_action_id = 7 AND recordstatus_id = 3";
        $result = $this->db->fetchAll($sql,array());
        return $result;
    }

    public function interestFromUrl($productId,$country) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT A.interest  FROM  ourbank_interest_periods A,
                                         ourbank_productsofferdetails B 
                                   WHERE A.period_ofrange_monthfrom <= $country AND
                                         A.period_ofrange_monthto >= $country AND
                                         B.offerproduct_id = $productId AND 
                                         A.offerproduct_id=B.offerproduct_id AND 
                                         A.intereststatus_id=3";
        $result = $this->db->fetchOne($sql,array($productId));
        return $result;
    }

    public function fetchbranchid($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_members where member_id='$memberId'";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function fetchbranchaccount($branchID) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_bankaccounts where bank_branch_id='$branchID'";
        $result = $this->db->fetchAll($sql,array($branchID));
        return $result;
    }

    public function groupMembers($memberId) {
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT B.memberfirstname,B.member_id FROM 
                        ourbank_groupmembers A,
                        ourbank_membername B 
                        WHERE A.group_id='$memberId' AND
                              A.member_id=B.member_id";
        $result = $this->db->fetchAll($sql,array($memberId));
        return $result;
    }

    public function fetchaccountnumber($accountid) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT account_number FROM ourbank_accounts 
                                       WHERE account_id='$accountid'";
        $result = $this->db->fetchAll($sql,array($accountid));
        return $result;
    }

    public function ourbankRecurringInstalmentsInsertion($input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->insert("ourbank_recurringpaydetails",$input);
        return '1';
    }

}
