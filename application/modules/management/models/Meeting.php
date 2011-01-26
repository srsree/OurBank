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
class Management_Model_Meeting extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_days';

        public function getDays() {
                $result = $this->fetchAll();
                return $result;
        }
     
            public function getGroupNames() {
                    $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('a' => 'ourbank_groupaddress'),array('a.groupname'))
                                ->where('groupaccountstatus = 3');
               //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
            }

         public function getMeridiam() {
                    $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('a' => 'ourbank_Meridiem'),array('a.hourclock'));
               //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
            }

        public function getMeeting() {
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->join(array('a' => 'ourbank_meetingdetails'),array('a.meeting_name'))
                            ->where('a.recordstatus_id = 3')
                            ->join(array('b'=>'ourbank_groupaddress'),'a.group_id = b.groupoffice_id')
                            ->where('b.recordstatus_id = 3')
                            ->join(array('c'=>'ourbank_officenames'),'a.officetype_id = c.office_id')
                            ->where('c.recordstatus_id=3')
                            ->join(array('d'=>'ourbank_days'),'d.meetingdays_id = a.meetingdays_id');
                //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
            }

        public function viewMeeting($meeting_id) {
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

        public function SearchMeeting($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_meetingdetails'),array('a.meeting_name'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.meeting_name like "%" ? "%"',$post['field2'])
                       ->where('a.meetingdays_id  like "%" ? "%"',$post['field1'])
                       ->where('a.meeting_place  like "%" ? "%"',$post['field3'])
                       ->join(array('b'=>'ourbank_groupaddress'),'a.group_id = b.groupoffice_id')
                       ->where('b.recordstatus_id = 3')
                       ->where('b.groupname like "%" ? "%"',$post['field5'])
                       ->join(array('c'=>'ourbank_officenames'),'a.officetype_id = c.office_id')
                       ->join(array('d'=>'ourbank_days'),'d.meetingdays_id = a.meetingdays_id');
         //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

        public function subgroupFromUrl($officetype_id) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
                $sql = "SELECT a.groupname,a.groupname_id FROM ourbank_groupaddress a,ourbank_officenames b WHERE 
                        a.groupoffice_id = b.office_id AND 
                        groupoffice_id = $officetype_id";
                $result = $this->db->fetchAll($sql,array($officetype_id));
                return $result;
            }

        public function GroupHeadUrl($group) {
                $this->db = Zend_Db_Table::getDefaultAdapter();
                $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
                $sql = "SELECT a.group_head FROM ourbank_groupaddress a,ourbank_officenames b WHERE 
                        a.groupoffice_id = b.office_id AND 
                        a.group_id=$group";
                $result = $this->db->fetchAll($sql,array($group));
                return $result;
            }
        
        public function getGroupHead() {
                    $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('a' => 'ourbank_groupaddress'),array('a.group_head'))
                                ->where('groupaccountstatus = 3');
               //die($select->__toString());
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
 

}
