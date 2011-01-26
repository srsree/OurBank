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
 *  model meeting search, add and delete
 */
class Meetingreport_Model_Meetingreport extends Zend_Db_Table {
	protected $_name = 'ob_meeting';
	//search
	public function getMeetings($post) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('c'=>'ob_bank'),array('id'),array('name as bankname','id'))
			->where('c.id like "%" ? "%"',$post['field1'])
			->join(array('a'=>'ob_meeting'),'a.bank_id = c.id',array('name as meetingname','time','day','place','grouphead_name'))
			->where('a.group_id like "%" ? "%"',$post['field2'])
			->where('a.day like "%" ? "%"',$post['field3'])			
			->join(array('d'=>'ob_group'),'d.id = a.group_id');		
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	//meeting name
	public function getMeetingsall() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('c'=>'ob_bank'),array('id'),array('name as bankname','id'))
			->join(array('a'=>'ob_meeting'),'a.bank_id = c.id',array('name as meetingname','time','day','place','grouphead_name'))
			->join(array('d'=>'ob_group'),'d.id = a.group_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
	//get bank name for pdf
	public function getBankName($institute_bank_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->from('ob_bank')
			->where('id = '.$institute_bank_id);
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

public function fetchGroupnamesForMeetingReport() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->from('ob_group');
			//->where('recordstatus_id = 1 OR recordstatus_id = 3');
			
		$result = $this->fetchAll($select);
		return $result->toArray();
	}
    public function getDays() 
    {        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('ob_weekdays');
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
	public function getGroupName($group_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->from('ob_group')
			->where('id = '.$group_id);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

}
