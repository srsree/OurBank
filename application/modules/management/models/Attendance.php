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
class Management_Model_Attendance extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_meetingdetails';

        public function getMeetingPlace() {
                $result = $this->fetchAll();
                return $result;
        }
     
        public function getdata() {
               $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->join(array('a' => 'ourbank_days'),array('a.meeting_days'))
                            ->join(array('b'=>'ourbank_meetingdetails'),'a.meetingdays_id = b.meetingdays_id')
                            ->where('b.recordstatus_id = 3')
                            ->join(array('c'=>'ourbank_groupaddress'),'b.group_id = c.groupoffice_id')
                            ->where('c.recordstatus_id = 3');
                //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
                    }

        public function getGroupNames() {
                    $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('a' => 'ourbank_groupaddress'),array('a.groupname'))
                                ->where('groupaccountstatus = 3');
                $result = $this->fetchAll($select);
                return $result->toArray();
            }

        public function getAttendance() {
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->join(array('a' => 'ourbank_meetingdetails'),array('a.meeting_name'))
                            ->where('a.recordstatus_id = 3')
                            ->join(array('b'=>'ourbank_groupaddress'),'a.group_id = b.groupoffice_id')
                            ->where('b.recordstatus_id = 3')
                            ->join(array('c'=>'ourbank_officenames'),'a.officetype_id = c.office_id')
                            ->where('c.recordstatus_id=3')
                            ->join(array('d'=>'ourbank_meetingattendance'),'a.meeting_id = d.meeting_id');
                //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
            }

        public function viewAttendance($meeting_id) {
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->join(array('a' => 'ourbank_meetingdetails'),array('a.meeting_name'))
                            ->where('a.recordstatus_id = 3')
                            ->where('a.meeting_id=?',$meeting_id)
                            ->join(array('b'=>'ourbank_groupaddress'),'a.group_id = b.groupoffice_id')
                            ->where('b.recordstatus_id = 3')
                            ->join(array('c'=>'ourbank_officenames'),'a.officetype_id = c.office_id')
                            ->where('c.recordstatus_id=3')
                            ->join(array('d'=>'ourbank_days'),'d.meetingdays_id = a.meetingdays_id');
               //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
            }

        public function SearchAttendance($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_meetingdetails'),array('a.meeting_name'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.meeting_place  like "%" ? "%"',$post['field1'])
                       ->join(array('d'=>'ourbank_meetingattendance'),'d.meeting_id = a.meeting_id')
                       ->where('d.meeting_date like "%" ? "%"',$post['field2'])
                       ->where('d.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_groupaddress'),'a.group_id = b.groupoffice_id')
                       ->where('b.recordstatus_id = 3')
                       ->where('b.groupname like "%" ? "%"',$post['field5'])
                       ->join(array('c'=>'ourbank_officenames'),'a.officetype_id = c.office_id')
                       ->where('c.office_name like "%" ? "%"',$post['field7']);
        //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

        public function subgroupFromUrl($officetype_id) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
                $sql = "SELECT a.groupname, c.meeting_days, d.timeg,d.group_head,a.groupname,f.memberfirstname
                         FROM ourbank_groupaddress a, ourbank_officenames b, ourbank_days c, ourbank_meetingdetails d,ourbank_groupmembers e,ourbank_membername f
                         WHERE a.groupoffice_id = b.office_id
                         AND c.meetingdays_id = d.meetingdays_id
                         AND d.group_id = a.groupoffice_id
                         AND e.member_id = f.member_id
                         AND a.groupoffice_id =$officetype_id
                         GROUP BY a.groupname";
//                 echo $sql;
                 $result = $this->db->fetchAll($sql,array($officetype_id));
                 return $result;
            }

            public function getMembers() {
               $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->join(array('a' => 'ourbank_groupmembers'),array('a.groupname'))
                            ->join(array('b'=>'ourbank_membername'),'a.member_id = b.member_id')
                            ->group('b.memberfirstname');
                //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
                    }


        
        public function getGroupHead() {
                    $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('a' => 'ourbank_groupaddress'),array('a.group_head'))
                                ->where('groupaccountstatus = 3');
                $result = $this->fetchAll($select);
                return $result->toArray();
            }


        public function deleteMeeting($office_id,$remarks) {
        $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
        $where = 'meeting_id = '.$office_id;
        $this->update($data,$where);
	}

         public function updateMeeting($meetingupdates_id) {
                $data = array('recordstatus_id'=> 2);
		$where = 'meetingupdates_id = '.$meetingupdates_id;
		$this->update($data , $where);
           //die($select->__toString());
                        }

        public function editMeeting($post,$meeting_id,$createdby) {
        $sessionName = new Zend_Session_Namespace('ourbank');
        $user_id = $sessionName->primaryuserid;
        $data = array('meetingupdates_id'=>'',
                      'meeting_id' => $meeting_id, 
                      'meeting_name'=>$post['office_name'],
                      'officetype_id'=>$post['officeshort_name'],
                      'group_id'=>$post['officetype_id'],
                      'meetingdays_id'=>$post['meetingdays_id'],
                      'meeting_place'=>$post['meeting_place'],
                      'time'=>$post['meeting_time'],
                      'group_head'=>$post['group_head'],
                      'createdby'=> $createdby,
                      'createddate'=>date("Y-m-d"),
                      'editeddate'=>date("Y-m-d"),
                      'editedby'=>'',
                      'hourclock'=>$time);
           //die($select->__toString());
     $this->insert($data);
    }
        public function noMembers()
            {
                $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
                $sql = "SELECT * FROM   ourbank_memberattendance";
                $result = $this->db->fetchAll($sql,array());
                $result=count($result);
                return $result;
            }
 

}
