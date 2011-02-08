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
class Attendance_Model_Attendance extends Zend_Db_Table 
{
    protected $_name = 'ob_attendance';
    public function insertattendance($post,$member_id,$attendance_id,$createdby) 
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $convertdate = new Creditline_Model_dateConvertor();
        $meeting_date=$convertdate->phpmysqlformat($post['meeting_date']);
        $data = array('id'=> $attendance_id,
                        'meeting_id' => $post['meeting_name'],
                        'member_id'=> $member_id,
                        'meeting_date'=> $meeting_date,
                        'created_by' => $createdby);
        $this->db->insert('ob_attendance',$data);
    }

    public function deleterecord($attendance_id)
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $data='id='.$attendance_id;
        $this->db->delete('ob_attendance',$data);
    }

    public function fetchAllattendancedetails() 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_attendance'),array('attendance_id'))
                ->join(array('b' => 'ob_meeting'),'a.meeting_id = b.group_id')
                ->group('b.meeting_id')
                ->group('a.meeting_date');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchAllattendancedetailsview() {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_attendance'),array('id'),array('a.id as attid','meeting_date'))
                ->group('a.id')
                ->join(array('b' => 'ob_meeting'),'a.meeting_id = b.id');

        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchattendancedetailsforID($attendance_id) {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_attendance'),array('id'))
                ->where('a.id = '.$attendance_id)
                ->group('a.id')
                ->join(array('b' => 'ob_meeting'),'a.meeting_id = b.id');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchMembers_attendance_ID($attendance_id) {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_attendance'),array('id'))
                ->where('a.id = '.$attendance_id)
                ->join(array('b' => 'ob_member'),'a.member_id = b.id');
// die($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }


    public function SearchAttendance($post) {
        $convertdate = new Creditline_Model_dateConvertor();
        if($post['search_meeting_date']) { 
                $search_meeting_date=$convertdate->phpmysqlformat($post['search_meeting_date']);
        }
        else{
                $search_meeting_date=$post['search_meeting_date'];
        }
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_attendance'),array('id'),array('a.id as attid','a.meeting_date as meeting_date'))
                ->where('a.meeting_id like "%" ? "%"',$post['search_meeting_name_att'])
                ->where('a.meeting_date like "%" ? "%"',$search_meeting_date)
                ->group('a.id')
                ->join(array('b' => 'ob_meeting'),'a.meeting_id = b.id');
        $result = $this->fetchAll($select);
        return $result->toArray();
}
    
    public function fetchMeetingIDforComparision() {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from('ob_attendance')
            ->group('meeting_id');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
    
    public function assignMembers($attendance_id) {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->join(array('a'=>'ob_attendance'),array('id'))
            ->where('a.id='.$attendance_id)
            ->join(array('b'=>'ob_member'),'a.member_id = b.id');
// // die($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}
