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
class Management_Model_UsernameUpdates extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_usernamesupdates';
    public function adduserdetails($post,$user_id) {
    $data = array('usernames_id'=> '',
                  'user_id' => $user_id,
	          'bank_id'=>$post['officetype_id'],
                  'firstname'=>$post['first_name'],
                  'middlename'=>$post['middle_name'],
                  'lastname'=>$post['userlast_name'],
                  'gender'=>$post['gender_id'],
                  'dateofbirth'=>$post['dateofbirth'],
                  'dateofjoin'=>$post['dateofjoin'],
                  'title'=>$post['membertitle'],
                  'designation'=>$post['designation'],
                  'recordstatus_id' => 3);
    $this->insert($data);
    }

    public function Edituser($user_id) {
        $select = $this->select()
               ->setIntegrityCheck(false)
               ->join(array('a' => 'ourbank_usernamesupdates'),array('a.usernames_id'))
               ->where('a.recordstatus_id = 3')
               ->where('a.user_id = ?',$user_id)
               ->join(array('b' => 'ourbank_useraddressupdates'),'a.user_id=b.user_id')
                ->where('b.recordstatus_id = 3')
               ->join(array('c' => 'ourbank_userloginupdates'),'a.user_id=c.user_id')
               ->where('c.recordstatus_id = 3')
               ->join(array('d' => 'ourbank_usergrants'),'a.user_id = d.user_id')
               ->where('d.recordstatus_id = 3');
           //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
                                        }
}
