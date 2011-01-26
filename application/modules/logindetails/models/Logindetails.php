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
class Logindetails_Model_Logindetails  extends Zend_Db_Table {
 protected $_name = 'ob_member';

 public function add_login($data) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->insert('ob_login_details',$data);
        return;
    }

    public function edit_address($id,$mod_id,$sub_id,$data)
    {
        $where = array('id = '.$id,'module_id='.$mod_id,'submodule_id='.$sub_id);
	$db = $this->getAdapter();
        $db->update('ob_address_details', $data , $where);
    }

    public function getaddress($id,$mod_id,$sub_id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_address_details'),array('member_id'))
                ->where('id=?',$id)
		->where('module_id=?',$mod_id)
		->where('submodule_id=?',$sub_id)
                ->where('recordstatus_id=3');
              
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
 public function getlogin($id,$mod_id,$sub_id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_login_details'),array('member_id'))
                ->where('id=?',$id)
		->where('module_id=?',$mod_id)
		->where('submodule_id=?',$sub_id)
                ->where('recordstatus_id=3');
              
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
public function edit_login($id,$mod_id,$sub_id,$data)
    {
        $where = array('id = '.$id,'module_id='.$mod_id,'submodule_id='.$sub_id);
	$db = $this->getAdapter();
        $db->update('ob_login_details', $data , $where);
    }
}
