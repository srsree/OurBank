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

class User_Model_User extends Zend_Db_Table { 
 protected $_name = 'ourbank_user';
// search function
 public function userSearch($post) {
 		$select = $this->select()
			->setIntegrityCheck(false)  
 			->join(array('a' => 'ourbank_user'),array('id'),array('name as username','id as userid'))
			->where('a.username like "%" ? "%"',$post['name'])
			->where('b.designation_id like "%" ? "%"',$post['designation'])
			->where('c.id like "%" ? "%"',$post['bank'])
			->where('e.id like "%" ? "%"',$post['grant_id'])
			->join(array('b'=>'ob_designation'),'a.designation = b.designation_id')
 			->join(array('c'=>'ob_institution'),'a.bank_id = c.id')
 			->join(array('d'=>'gender'),'a.gender = d.id')
 			->join(array('e'=>'ob_grant'),'a.grant_id = e.id',array('name as grant'));
			//die($select->__toString());		
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
// view function
public function getUser($id) {
 		   $select = $this->select()
                       ->setIntegrityCheck(false)  
                ->join(array('a'=>'ourbank_user'),array('a.id'),array('name as username','id as userid','password','bank_id'))
                ->where('a.id='.$id)

 			->join(array('b'=>'ob_designation'),'a.designation = b.designation_id')
 			->join(array('c'=>'ob_institution'),'a.bank_id = c.id')
 			->join(array('d'=>'gender'),'a.gender = d.id')
 			->join(array('e'=>'ob_grant'),'a.grant_id = e.id',array('name as grant'));



		//die($select->__toString($select));
        $result=$this->fetchAll($select);
        return $result->toArray();
	}
public function getUserDetails() {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_user'),array('id'),array('name as username','id as userid'))
			 ->join(array('b'=>'ob_designation'),'a.designation = b.designation_id')
 ->join(array('c'=>'ob_institution'),'a.bank_id = c.id')
 ->join(array('d'=>'gender'),'a.gender = d.id')
 ->join(array('e'=>'ob_grant'),'a.grant_id = e.id',array('name as grant'));


	//die($select->__toString());		
	return $this->fetchAll($select);
    }
// view module
 public function getmodule($modulename)
    {
        $select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('ob_modules'),array('module_id'))
                        ->where('module_description=?',$modulename);
        $result=$this->fetchAll($select);
        return $result->toArray();
        //die ($select->__toString($select));
    }
//view personal details
public function getpersonal($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_personal_details'),array('id'))
                ->where('id=?',$id);
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
//view address details
 public function getaddress($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'address'),array('id'))
                ->where('id=?',$id);
     //  die ($select->__toString($select));
        $result=$this->fetchAll($select);
        return $result->toArray();
    }
//view contact details
public function getcontact($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'contact'),array('id'))
                ->where('id=?',$id);
     //  die ($select->__toString($select));
        $result=$this->fetchAll($select);
        return $result->toArray();
    }
}