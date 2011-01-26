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
class Enquiry_Model_TransactiondueAmount extends Zend_Db_Table_Abstract 
{
protected $_name = 'ourbank_installmentdetails'; 

//  public function fetchTransaction($post = array()) {
//         $this->db = Zend_Db_Table::getDefaultAdapter();
//         $this->db->setFetchMode(Zend_Db::FETCH_OBJ);

 public function fetchTransaction($accountinstallment_amount)  {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_installmentdetails'),array('a.accountinstallment_date'))
                       ->where('a.accountinstallment_amount like "%" ? "%"',$accountinstallment_amount)
                       ->join(array('b' => 'ourbank_accounts'),'a.account_id = b.account_id ')
                       ->where('b.accountstatus_id')
                       ->join(array('c'=>'ourbank_membername'),'c.member_id = b.member_id')
                       ->join(array('d'=>'ourbank_officenames'),'d.officetype_id = c.memberoffice_id')
                       ->where('d.recordstatus_id=3')
                       ->join(array('e'=>'ourbank_transaction'),'e.account_id = b.account_id')
                       ->where('e.recordstatus_id=3');
           //die($select->__toString());
       return $this->fetchAll($select);
    }
}
