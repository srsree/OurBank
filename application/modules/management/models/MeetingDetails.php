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
class Management_Model_MeetingDetails extends Zend_Db_Table {
    protected $_name = 'ourbank_meetingdetails';

public function addMeeting($post,$meeting_id,$createdby) {
        $data = array('meetingupdates_id'=> '',
                      'meeting_id'=>$meeting_id,
                      'meeting_name'=>$post['meeting_name'],
                      'officetype_id'=>$post['officetype_id'],
                      'group_id'=>$post['group'],
                      'meetingdays_id'=>$post['meeting_days'],
                      'meeting_place'=>$post['meeting_place'],
                      'timeg'=>$post['meeting_time'],
                      'group_head'=>$post['group_head'],
                      'createdby'=>$createdby,
                      'hourclock'=>$post['timeg'],
                      'recordstatus_id'=>'3',
                      'createddate'=>date("Y-m-d"));
     $this->insert($data);
    }

}

