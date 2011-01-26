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
//create query model page for individual member
class Individualm_Model_Individualm extends Zend_Db_Table {
    protected $_name = 'ourbank_member';

// fetch the member details query
    public function getMemberDetails() {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_member'),array('a.id'),array('a.name as membername','a.membercode','a.id as memberid'))
                        ->join(array('c' => 'gender'),'c.id = a.gender',array('c.sex'))
                        ->join(array('d' => 'ourbank_office'),'d.id = a.office_id',array('d.name'))
                        ->join(array('e' => 'ourbank_officehierarchy'),'e.Hierarchy_level = d.officetype_id')
                        ->order(array('a.id DESC'));   		
	return $this->fetchAll($select);
    }

//fetch the member details from search options...
    public function searchDetails($post = array()) {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_member'),array('a.id'),array('a.name as membername','a.membercode','a.id as memberid'))
                        ->join(array('c' => 'gender'),'c.id = a.gender',array('c.sex'))
                        ->join(array('d' => 'ourbank_office'),'d.id = a.office_id',array('d.name'))
                        ->join(array('e' => 'ourbank_officehierarchy'),'e.Hierarchy_level = d.officetype_id')
                        ->where('a.membercode like "%" ? "%"',$post['code'])
                        ->where('a.name like "%" ? "%"',$post['name'])
                        ->where('a.gender like "%" ? "%"',$post['gender_id'])
                        ->where('a.office_id like "%" ? "%"',$post['office'])
                        ->order(array('a.id DESC'));   
	return $this->fetchAll($select);
    }

//get the office hierarchy id from the maximum hierarchy level
        public function getoffice_hierarchy() {
        $db = $this->getAdapter();
        $sql = "SELECT id FROM `ourbank_officehierarchy` where Hierarchy_level in (SELECT max(Hierarchy_level) FROM `ourbank_officehierarchy`)";
        $result = $db->fetchAll($sql);
        return $result;
    }

//get the office name and id with respective office type
    public function getoffice($id){
        $select=$this->select()
                    ->setIntegrityCheck(false)
                    ->join(array('a'=>'ourbank_office'),array('a.id'),array('a.id as office_id','a.name'))
                    ->where('a.officetype_id=?',$id);
                     return $this->fetchAll($select);

    }

 }
