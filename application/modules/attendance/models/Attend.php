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
class Attendance_Model_Attend extends Zend_Db_Table {
    protected $_name = 'ob_member';

    public function fetchMembers($meeting_ID) {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->join(array('a' => 'ob_meeting'),array('id'))
                ->where('a.id = '.$meeting_ID)

                ->join(array('b' => 'ob_groupmembers'),'b.id = a.group_id')
                ->where('b.groupmember_status = 1 OR b.groupmember_status = 3')

                ->join(array('c' => 'ob_member'),'b.member_id = c.id');
        $result = $this->fetchAll($select);
        return $result->toArray();		
    }
	
}