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
class Commonviewuser_Model_User extends Zend_Db_Table {
protected $_name = 'ob_usernameupdates';

     public function getUserDetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_usernameupdates'),array('user_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ob_usernameupdates'),'a.user_id = b.user_id')
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
        }

        public function getOffice() {
               $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ob_institute_bank_details') 
                       ->where('recordstatus_id = 3 AND submodule_id=2');

               $result = $this->fetchAll($select);
               return $result->toArray();
    }

    public function viewuser($user_id){
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_usernameupdates'),array('a.office_id'))
                       ->where('a.user_id = ?',$user_id)
                       ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
                       ->join(array('b' => 'ourbank_officenames'),'a.office_id = b.office_id')
                       ->where('b.recordstatus_id = 3 or b.recordstatus_id = 1')
                       ->join(array('c' => 'ourbank_salutation'),'a.title = c.salutation_id')
                       ->join(array('d' => 'ob_gender'),'a.gender = d.gender_id');

         $result = $this->fetchAll($select);
        return $result->toArray();
	}

        public function getLoginName($user_id){
            $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_userloginupdates'),array('a.userlogin_id'))
                        ->where('a.user_id = ?',$user_id)
                        ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
            $result = $this->fetchAll($select);
            return $result->toArray();
        }

    public function fetchUserAddress($user_id) 
             {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_useraddressupdates'),array('a.offerproductupdate_id'))
                       ->where('a.user_id = ?',$user_id)
                       ->join(array('e' => 'ourbank_membermaritalstatus'),'a.marital_status = e.membermaritalstatus_id');
          //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
             }
     public function fetchUserloginDetails($user_id)
             {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_userloginupdates'),array('a.offerproductupdate_id'))
                       ->where('a.user_id = ?',$user_id);
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
             }
 public function noGrants()
             {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->from('ob_grant');
                //die($select->__toString());
                return $result = $this->fetchAll($select);
            }

public function fetchAllGrants()
             {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_grant'),array('a.grant_id'));
                //die($select->__toString());
                $result = $this->fetchAll($select);
//                 $result=count($result);
                return $result->toArray();
            }

 public function fetchAllGrant($user_id)
            {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_grant'),array('a.grant_id'))
                       ->where('a.user_id = ?',$user_id)
                       ->where('a.recordstatus_id=3')
                       ->join(array('b' => 'ob_grant'),'a.grant_id=b.grant_id');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
             }


//      public function editUser($post) {
// 		$data = array('categoryupdates_id'=> '',
// 		'category_id'=>$post['category_id'],
// 		'categoryname'=>$post['categoryname'],
// 		'categorydescription'=>$post['categorydescription'],
// 		'recordstatus_id'=>'3',
// 		'createdby'=>'1',
// 		'createddate'=>date("Y-m-d"),
// 		'editedby'=>'1',
// 		'editeddate'=>date("Y-m-d"));
// 		$this->insert($data);
// 		}
    
      public function SearchUsers($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_usernameupdates'),array('a.user_id'))
                       ->where('a.firstname like "%" ? "%"',$post['field6'])
                       ->where('a.dateofjoin like "%" ? "%"',$post['field3'])
                       ->where('a.designation like "%" ? "%"',$post['field4'])
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_useraddressupdates'),'a.user_id = b.user_id')
                       ->where('b.emailid like "%" ? "%"',$post['field2'])
                       ->where('b.recordstatus_id = 3')
                       ->order('a.firstname');
                     //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
       }
       
        public function deleteUser($user_id,$remarks) {
                $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
                $where = 'user_id = '.$user_id;
                $this->update($data,$where);
	}

        public function UpdateUsers($user_id) {

                $data = array('recordstatus_id'=> 2);
                $where = 'user_id = '.$user_id;
                $this->update($data , $where );
                    }

         public function editUsers($post,$user_id) {
                $data = array('usernames_id'=> '',
                  'user_id' => $user_id,
	          'office_id'=>$post['officetype_id'],
                  'firstname'=>$post['first_name'],
                  'middlename'=>$post['middle_name'],
                  'lastname'=>$post['userlast_name'],
                  'gender'=>$post['gender_id'],
                  'dateofbirth'=>$post['dateofbirth'],
                  'dateofjoin'=>$post['dateofjoin'],
                  'title'=>$post['membertitle'],
                  'designation'=>$post['designation'],
                  'recordstatus_id'=>3);

        $this->insert($data);
    }
public function getGender() {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_gender');
         return $result = $this->fetchAll($select);
    }
 public function getSalutation() {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_salutation');
            //die($select->__toString());
            return $result = $this->fetchAll($select);
    }
 
    public function getMaritalStatus() {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_membermaritalstatus');
         return $result = $this->fetchAll($select);
    }
 public function insertUser($post,$fee_id) {

            $data = array('usernames_id'=> '',
                          'user_id'=> $fee_id,
                          'recordstatus_id'=>'3',
                          'office_id'=>$post['officebranch'],
                          'firstname'=>$post['username'],
                          'gender'=>$post['gender'],
                          'designation'=>$post['designation']);

            $this->insert($data);
        }
 public function grantsInsert($grant_id,$user_id) {
            $data = array('usergrant_id' => '',
                        'grant_id' => $grant_id,
                        'user_id' => $user_id,
                        'recordstatus_id'=>3);
            $this->insert($data);
        }
public function getDesignation() {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_designation');
        return $result = $this->fetchAll($select);
      // die ($select->__toString($select));

    }

}

