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
/*
 *  model page for fetch and return funder details, filtered search details
 */
class Officehierarchy_Model_Officehierarchy extends Zend_Db_Table_Abstract {

    public function noOfficelevel() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchAll('SELECT * FROM ourbank_officehierarchy');
        $result = count($result);
	//return no of office level
        return $result;
    }

    public function fetchAllHierarchy() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchAll('SELECT * FROM ourbank_officehierarchy ORDER BY Hierarchy_level');
	//return all office hierarchy level
        return $result;
    }

    public function officeExistedInThisType($officeTypeId) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_office where officetype_id=$officeTypeId";
        $result = $this->db->fetchAll($sql);
	//return all existed office level
        return $result;
    }

//     public function officeExistedInThisType1($officeTypeId) {
//         $this->db = Zend_Db_Table::getDefaultAdapter();
//         $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
//         $sql = "SELECT * FROM  ourbank_office where officetype_id=$officeTypeId AND recordstatus_id=3";
//         $result = $this->db->fetchAll($sql);
//         return count($result);
//     }

    public function officeInsert($input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $result = $this->db->insert('ourbank_officehierarchy',$input);
	//insert new  all office hierarchy level
    }

    public function officeUpdate($id,$input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
	//get selected office id
        $where[] = "id = '".$id."'";
	//update  all office hierarchy level
        $result = $this->db->update('ourbank_officehierarchy',$input,$where);
    }

    public function fetchOneOfficeHierarchy($id) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where id=$id";
        $result = $this->db->fetchAll($sql);
	//return office hierarchy level
        return $result;
    }

    public function editOfficeHierarchy($id) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where id!=$id";
        $result = $this->db->fetchAll($sql);
	//return selected office hierarchy details
        return $result;
    }

        public function findhighlevel() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT max(`Hierarchy_level`) as high FROM  ourbank_officehierarchy";
        $result = $this->db->fetchAll($sql);
	//return selected office hierarchy details
        return $result;
    }

    public function officeLowerLevel($hierarchyLevel) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM  ourbank_officehierarchy where Hierarchy_level>$hierarchyLevel ORDER BY Hierarchy_level";
        $result = $this->db->fetchAll($sql);
	//return level office details
        return $result;
        
    }

    public function officeTypeLevelUpdate($id,$input = array()) {
        $where[] = "id = '".$id."'";
        $result = $this->db->update('ourbank_officehierarchy',$input,$where);	 
    }

    public function officeTypeDelete($id) {
        $where[] = "id = '".$id."'";
	//delete selected office id
        $result = $this->db->delete('ourbank_officehierarchy',$where);	

    }
}
