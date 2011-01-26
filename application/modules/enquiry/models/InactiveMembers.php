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
class Enquiry_Model_InactiveMembers extends Zend_Db_Table_Abstract {
protected $_name = 'ourbank_memberaddress'; 

 public function InactiveMembers() {
              $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_membername'),array('a.memberfirstname'))
                       ->where('a.recordstatus_id = 1')
                       ->join(array('b'=>'ourbank_memberaddress'),'b.member_id = a.member_id')
                       ->where('b.recordstatus_id = 1')
                       ->join(array('c'=>'ourbank_members'),'c.member_id = a.member_id')
                       ->join(array('d'=>'ourbank_officenames'),'d.office_id = c.memberbranch_id')
                       ->where('d.recordstatus_id = 3')
                       ->join(array('e'=>'ourbank_userloginupdates'),'e.user_id = a.membercreatedby')
                       ->where('e.recordstatus_id = 3');
         //die($select->__toString());
       return $this->fetchAll($select);
     }
}