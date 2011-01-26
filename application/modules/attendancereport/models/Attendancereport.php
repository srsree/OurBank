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
 *  model page to fetch and return attendence details and filtered search details
 */
class Attendancereport_Model_Attendancereport extends Zend_Db_Table {
	protected $_name = 'ob_meeting';
	
	public function getMeetings($post) {
		
			//condition with date
			if($post['field4']) {
			$select = $this->select()
				->setIntegrityCheck(false)  
				->join(array('c'=>'ob_bank'),'id')
				->where('c.id like "%" ? "%"',$post['field1'])
				->join(array('a'=>'ob_meeting'),'a.bank_id = c.id',array('id','name as gname','time','day','place'))
				->where('a.group_id like "%" ? "%"',$post['field2'])
				->where('a.id like "%"?"%"',$post['field5'])
				
				->join(array('d'=>'ob_group'),'d.id = a.group_id')
	
				->join(array('b'=>'ob_attendance'),'a.id = b.meeting_id')
				->where('b.meeting_date like "%"?"%" ',$post['field4'])
				->group('b.meeting_id');
				
			}
			else {
			$select = $this->select()
				->setIntegrityCheck(false)  
				->join(array('c'=>'ob_bank'),'id')
				->where('c.id like "%" ? "%"',$post['field1'])
				->join(array('a'=>'ob_meeting'),'a.bank_id = c.id',array('id','name as gname','time','day','place'))
				->where('a.group_id like "%" ? "%"',$post['field2'])
				->where('a.id like "%"?"%"',$post['field5'])
				->join(array('d'=>'ob_group'),'d.id = a.group_id')
				->join(array('b'=>'ob_attendance'),'a.id = b.meeting_id')
				->group('b.meeting_id');

			}
		
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	public function getMeetingsall() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('c'=>'ob_bank'),array('id','name'))
			->join(array('a'=>'ob_meeting'),'a.id = c.id',array('id','name as gname','time','day','place'))			
			->join(array('d'=>'ob_group'),'d.id = a.group_id')
			->join(array('b'=>'ob_attendance'),'b.meeting_id = a.id')
			->group('b.meeting_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	
	public function getOffice() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_bank');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

    public function fetchGroupnames($bank_id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('ob_group')
                ->where('bank_id  =  ?',$bank_id);
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
	public function fetchMembers() {
		$select = $this->select()
			->setIntegrityCheck(false)  
		->join(array('a'=>'ob_attendance'),array('attendance_id'))
		->join(array('b'=>'ob_member'),'b.id = a.member_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	
	public function fetchGroupMembers() {
		$select = $this->select()
			->setIntegrityCheck(false)  
		
		->join(array('b'=>'ob_meeting'),array('id'))
		->join(array('c'=>'ob_groupmembers'),'c.id = b.group_id')
		->where('c.groupmember_status = 3')
		->join(array('d'=>'ob_member'),'d.id = c.member_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	

}
