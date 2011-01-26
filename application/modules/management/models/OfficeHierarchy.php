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
class  Management_Model_OfficeHierarchy extends Zend_Db_Table   {
    protected $_name = 'ourbank_officehierarchy';

    public function getOfficehierarchyDetails() {
        $result = $this->fetchAll();
        return $result;
        }
 public function viewParentOffice($officetype_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_officenames'),array('a.office_name'))
                       ->where('a.officetype_id = ?',$officetype_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_officeaddress'),'a.office_id = b.office_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_officehierarchy'),'a.officetype_id = c.officetype_id','c.officetype');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }
} 

