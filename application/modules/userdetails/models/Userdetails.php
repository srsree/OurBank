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
	class Userdetails_Model_Userdetails extends Zend_Db_Table { 
	 protected $_name = 'ob_usernameupdates';

    public function edituserdetails($user_id)
    {
        $select =$this->select()
                 ->setIntegrityCheck(false)

		->join(array('a' => 'ob_usernameupdates'),array('a.userupdates_id'))
               ->where('a.recordstatus_id = 3')
               ->where('a.user_id = ?',$user_id)
		->join(array('b' => 'ob_usergrants'),'a.user_id = b.user_id');
           
        return $result= $this->fetchAll($select);
        //die($select->__toString($select));
    }
	 public function insertFee($post,$createdby) {

            $data = array('feedetails_id'=> '',
                          'fee_id'=> $fee_id,
                          'recordstatus_id'=>'3',
                          'feename'=>$post['feename'],
                          'feedescription'=>$post['feedescription'],
                          'feevalue'=>$post['feeamount'],
			'createdby'=> $createdby);
            $this->insert($data);
        }

	
	 
  public function getOffice() {
               $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ob_institute_bank_details') 
                       ->where('recordstatus_id = 3 AND submodule_id=2');

               $result = $this->fetchAll($select);
               return $result->toArray();
    }
public function addusername($data) {
        $this->insert($data);
        return;
    }
public function addgrantname($data) {
         $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ob_usergrants');
        $this->insert($data);
        return;

    }
public function userEdit($user_id,$data) {
	$where = 'user_id = '.$user_id;
	$db = $this->getAdapter();
        $db->update('ob_usernameupdates',$data,$where);

    }
public function grantEdit($user_id,$data) {
	$where = 'user_id = '.$user_id;
	$db = $this->getAdapter();
        $db->update('ob_usergrants',$data,$where);

    }
public function getGender() {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_gender');
         return $result = $this->fetchAll($select);
    }
public function getDesignation() {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_designation');
        return $result = $this->fetchAll($select);
      // die ($select->__toString($select));

    }
 public function getuser($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_usernameupdates'),array('a.user_id'))
                ->where('a.user_id=?',$id)
                ->where('a.recordstatus_id=3')
                ->join(array('b' => 'ob_institute_bank_details'),'a.office_id = b.Institute_bank_id') 
			->where('b.recordstatus_id = 3')
                ->join(array('c' => 'ob_designation'),'a.designation = c.designation_id') 
		->join(array('d'=>'ob_usergrants'),'a.user_id = d.user_id')
                        ->where('d.recordstatus_id = 3')
		->join(array('e'=>'ob_grant'),'d.grant_id = e.grant_id')
			->join(array('f'=>'ob_gender'),'a.gender = f.gender_id');

       $result=$this->fetchAll($select);
        return $result->toArray();
     //  die ($select->__toString($select));
    }
public function userdit($id,$data) {
	$where = 'user_id  = '.$id;
	$db = $this->getAdapter();
        $db->update('ob_usernameupdates', $data, $where);

    }
public function userad($id,$data) {
	$where = 'id  = '.$id;
	$db = $this->getAdapter();
        $db->update('ob_address_details', $data, $where);

    }
public function userinfo($id,$data) {
	$where = 'id  = '.$id;
	$db = $this->getAdapter();
        $db->update('ob_personal_details', $data, $where);

    }
public function userlogin($id,$data) {
	$where = 'id  = '.$id;
	$db = $this->getAdapter();
        $db->update('ob_login_details', $data, $where);

    }

public function noGrants()
             {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->from('ob_grant');
                //die($select->__toString());
                return $result = $this->fetchAll($select);
            }
}