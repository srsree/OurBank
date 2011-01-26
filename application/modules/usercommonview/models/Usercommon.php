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

 <!--
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
!-->
<?php 
class Usercommonview_Model_Usercommon extends Zend_Db_Table { 
 protected $_name = 'ob_usernameupdates';


 public function getuser($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_usernameupdates'),array('usernames_id'))
                ->where('a.user_id=?',$id)
                ->where('a.recordstatus_id=3')
->join(array('b' => 'ob_institute_bank_details'),'a.office_id = b.Institute_bank_id') 
                ->where('b.recordstatus_id=3')

->join(array('c' => 'ob_gender'),'a.gender = c.gender_id')
                ->join(array('d' => 'ob_designation'),'a.designation = d.designation_id') ;

        $result=$this->fetchAll($select);
        return $result->toArray();
   //die ($select->__toString($select));
    }
public function getmemtype($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_feedetails'),array('feedetails_id'))
                ->where('fee_id=?',$id)
                ->where('recordstatus_id=3');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
  public function getAppliesTo() {
        $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->join(array('a' => 'ourbank_membertypes'),array('membertype_id'));

        $result = $this->fetchAll($select);
        return $result->toArray();
        return $result;
    }
 
     public function getaddress($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_address_details'),array('id'))
                ->where('id=?',$id)
                ->where('recordstatus_id=3')
                ->where('module_id=1')
                ->where('submodule_id=4');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
 public function getpersonal($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_personal_details'),array('id'))
                ->where('id=?',$id)
                ->where('recordstatus_id=3')
                ->where('module_id=1')
                ->where('submodule_id=4');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
 public function getfamily($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_member_family'),array('member_id'))
                ->where('member_id=?',$id)
                ->where('recordstatus_id=3');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
public function getlogin($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_login_details'),array('id'))
                ->where('id=?',$id)
                ->where('recordstatus_id=3')
                ->where('module_id=1')
                ->where('submodule_id=4');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
 public function fetchAllGrant($id)
            {
                $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_usergrants'),array('a.grant_id'))
                       ->where('a.user_id = ?',$id)
                       ->where('a.recordstatus_id=3')
                       ->join(array('b' => 'ob_grant'),'a.grant_id=b.grant_id');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
             }

}
