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
class Management_Model_UseraddressUpdates extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_useraddressupdates';

    public function addaddressdetails($post,$user_id) {
        $data = array('useraddress_id' => '',
                      'user_id' => $user_id,
                      'personnel_idcardnumber'=> $post['personnelid'],
                      'marital_status'=>$post['membermaritalstatus_id'],
                      'useraddress_id'=> '',
                      'addressline1'=>$post['line1'],
                      'addressline2'=>$post['line2'],
                      'addressline3'=>$post['line3'],
                      'city'=>$post['city'],
                      'state'=>$post['state'],
                      'country'=>$post['country'],
                      'postal_code'=>$post['pincode'],
                      'telephone'=>$post['telephonenumber'],
                      'emailid'=>$post['Email'],
                      'recordstatus_id'=>3);
      $this->insert($data);
    }

        public function userIdUpdate($user_id,$input = array()) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $where[] = "user_id = '".$user_id."'";
                $result = $this->db->update('ourbank_users',$input,$where);
        }

 public function edituseraddressdetails($post,$createby,$user_id) {
        $data = array('useraddress_id' => '',
                      'user_id' => $user_id,
                      'personnel_idcardnumber'=> '',
                      'marital_status'=>$post['membermaritalstatus_id'],
                      'useraddress_id'=> '',
                      'addressline1'=>$post['line1'],
                      'addressline2'=>$post['line2'],
                      'addressline3'=>$post['line3'],
                      'city'=>$post['city'],
                      'state'=>$post['state'],
                      'country'=>$post['country'],
                      'postal_code'=>$post['pincode'],
                      'telephone'=>$post['telephonenumber'],
                      'emailid'=>$post['Email'],
                      'createdby'=>$createby,
                      'recordstatus_id'=>3);
      $this->insert($data);
    }

}
