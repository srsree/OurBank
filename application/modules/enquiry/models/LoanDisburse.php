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
class Enquiry_Model_LoanDisburse extends Zend_Db_Table_Abstract {
protected $_name = 'ourbank_loan_disbursement'; 

 public function fetchAllOffice()  {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_officenames')
                        ->where('recordstatus_id=3');
            //die($select->__toString());
            return $this->fetchAll($select);
    }


 public function fetchAllUsers()  {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_usernamesupdates')
                        ->where('recordstatus_id=3');
            //die($select->__toString());
            return $this->fetchAll($select);
    }

// public function loanSearch($brancId,$createdBy)
//         {
//             $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
//             $sql = "SELECT * FROM 
//                                     ourbank_loan_disbursement A, 
//                                     ourbank_productsofferdetails B, 
//                                     ourbank_accounts C, 
//                                     ourbank_productdetails D,
//                                     ourbank_officenames E,
//                       	       ourbank_members F,
//                                     ourbank_userloginupdates G
//                                     WHERE 
//                                     (E.office_id = '$brancId') &&
//                                     (G.login_name = '".$createdBy."') &&
//                                     (A.account_id = C.account_id) && 
//                                     (G.user_id = C.accountcreated_by) &&
//                                     (C.product_id = B.offerproduct_id) && 
//                                     (B.product_id = D.product_id) && 
//                                     (F.memberbranch_id = E.office_id) &&
//                                     (B.recordstatus_id =3) &&
//                                     (E.recordstatus_id =3) &&
//                                     (G.recordstatus_id =3)
//                                     GROUP BY offerproductname"; 
//             $result=$this->db->fetchAll($sql,array($brancId,$createdBy));
//             return $result;
//         }

 public function loanSearch($brancId,$createdBy) {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_loan_disbursement'),array('a.amount_disbursed'))
                       ->join(array('c'=>'ourbank_accounts'),'c.account_id = a.account_id')
                       ->where('c.accountstatus_id = 3')
                       ->join(array('b'=>'ourbank_productsofferdetails'),'b.product_id = c.product_id')
                       ->join(array('d'=>'ourbank_productdetails'),'d.product_id = b.product_id');
           //die($select->__toString());
       return $this->fetchAll($select);
    }



}


