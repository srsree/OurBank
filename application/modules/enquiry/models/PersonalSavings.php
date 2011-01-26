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
class Enquiry_Model_PersonalSavings extends Zend_Db_Table_Abstract {
protected $_name = 'ourbank_accounts'; 

 public function accountDetails() {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_accounts'),array('a.account_number'))
                       ->where('a.accountstatus_id=3')
                       ->join(array('b'=>'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                       ->where('b.recordstatus_id=3')
                       ->join(array('c'=>'ourbank_members'),'a.member_id = c.member_id')
                       ->join(array('d'=>'ourbank_membername'),'c.member_id = d.member_id')
                       ->join(array('e'=>'ourbank_officenames'),'e.office_id=c.memberbranch_id')
                       ->where('e.recordstatus_id = 3')
                       ->join(array('i'=>'ourbank_userloginupdates'),'a.accountcreated_by = i.user_id')
                       ->where('i.recordstatus_id = 3')
                       ->join(array('j'=>'ourbank_productdetails'),'j.product_id = b.product_id')
                       ->where('j.category_id=1 AND j.recordstatus_id=3');
        //die($select->__toString());
       return $this->fetchAll($select);
      }

    public function accountBalanceDetails() {
            $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_accounts'),array('a.account_number'))
                       ->where('a.accountstatus_id=3')
                       ->join(array('b'=>'ourbank_productsofferdetails'),'a.product_id = b.offerproduct_id')
                       ->where('b.recordstatus_id=3')
                       ->join(array('c'=>'ourbank_members'),'a.member_id = c.member_id')
                       ->join(array('d'=>'ourbank_membername'),'c.member_id = d.member_id')
                       ->join(array('e'=>'ourbank_officenames'),'e.office_id=c.memberbranch_id')
                       ->where('e.recordstatus_id = 3')
                       ->join(array('f'=>'ourbank_transaction'),'a.account_id=f.account_id')
                       ->where('f.recordstatus_id = 3')
                       ->join(array('i'=>'ourbank_userloginupdates'),'a.accountcreated_by = i.user_id')
                       ->where('i.recordstatus_id = 3')
                       ->join(array('j'=>'ourbank_productdetails'),'j.product_id = b.product_id')
                       ->where('j.category_id=1 AND j.recordstatus_id=3');
        //die($select->__toString());
       return $this->fetchAll($select);
    }
}
