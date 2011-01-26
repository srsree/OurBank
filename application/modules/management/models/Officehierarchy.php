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
class Management_Model_Officehierarchy extends Zend_Db_Table_Abstract {

    public function noOfficelevel() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchAll('SELECT * FROM ourbank_officehierarchy');
        $result = count($result);
        return $result;
    }

    public function fetchAllHierarchy() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchAll('SELECT * FROM ourbank_officehierarchy ORDER BY Hierarchy_level');
        return $result;
    }

    public function officeExistedInThisType($officeTypeId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officenames where officetype_id=$officeTypeId AND recordstatus_id=3";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    public function officeExistedInThisType1($officeTypeId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officenames where officetype_id=$officeTypeId AND recordstatus_id=3";
        $result = $this->db->fetchAll($sql);
        return count($result);
    }

    public function officeInsert($input = array(),$level,$createdby,$date) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $result = $this->db->insert('ourbank_officehierarchy',$input);
        $oficeTypeId = $this->db->lastInsertId('ourbank_officehierarchy');
        $data = array('hierarchyupdates_id'=>'',
                      'officetype_id' => $oficeTypeId,
                      'hierarchylevel'=>$level,
                      'recordstatus_id'=>'3',
                      'createdby'=>$createdby,	
                      'createddate'=>$date);
       $result = $this->db->insert('ourbank_officehierarchyupdates',$data);
    }

    public function officeUpdate($id,$input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $where[] = "officetype_id = '".$id."'";
        $result = $this->db->update('ourbank_officehierarchy',$input,$where);
    }

    public function officeLevelUpdate($id,$input = array(),$level,$createdby,$date) {
        $where[] = "officetype_id = '".$id."'";
        $result = $this->db->update('ourbank_officehierarchyupdates',$input,$where);
        $data = array('hierarchyupdates_id'=>'',
                      'officetype_id' => $id,
                      'hierarchylevel'=>$level,
                      'recordstatus_id'=>'1',
                      'createdby'=>$createdby,
                      'createddate'=>$date);
        $result = $this->db->insert('ourbank_officehierarchyupdates',$data);	 
    }

    public function fetchOneOfficeHierarchy($id) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where officetype_id=$id";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    public function editOfficeHierarchy($id) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where officetype_id!=$id";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    public function officeLowerLevel($hierarchyLevel) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where Hierarchy_level>$hierarchyLevel ORDER BY Hierarchy_level";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    public function officeTypeLevelUpdate($id,$input = array()) {
        $where[] = "officetype_id = '".$id."'";
        $result = $this->db->update('ourbank_officehierarchy',$input,$where);	 
    }

    public function officeTypeDelete($id) {
        $where[] = "officetype_id = '".$id."'";
        $result = $this->db->delete('ourbank_officehierarchy',$where);	 
    }


}
