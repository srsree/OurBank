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
class Education_Model_education  extends Zend_Db_Table {
    protected $_name = 'ob_member';

    //get the education details with respective individual member...
    public function edit_education($member_id)
    {
       $select=$this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a'=>'ourbank_familyeducation'),array('a.id'))
                        ->where('a.member_id=?',$member_id);
       $result=$this->fetchAll($select);
       return $result->toArray();
       //die ($select->__toString($select));
    }

    // update the education details with respective individual member...
    public function updateeducation($memberId,$input = array()) {
    $where[] = "familymember_id = '".$memberId."'";
    $db = $this->getAdapter();
    $result = $db->update('ourbank_familyeducation',$input,$where);
    }

}
