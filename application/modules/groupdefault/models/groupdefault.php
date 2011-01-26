<?php

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

class Groupdefault_Model_groupdefault extends Zend_Db_Table {
   	protected $_name = 'ob_member'; // set ob_member is a parent table
    
        // get branch members
	public function GetBranchMembers($branchid) {
	$db = $this->getAdapter();
	$sql = "select * from ob_member 
            where bank_id = $branchid
            and id not in
            (select member_id from ob_groupmembers 
            where (groupmember_status = 3 or groupmember_status = 1) and id in (select id from ob_groupmembers where (groupmember_status = 3 or groupmember_status = 1)))";
	$result = $db->fetchAll($sql);
	return $result;
	}

	public function Getgrouphead($group_id){
            $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a' => 'ob_group'),array('id'),array('group_head'))
                ->where('a.id = '.$group_id)
                ->join(array('b' => 'ob_member'),'b.id  = a.group_head');
        $result=$this->fetchAll($select);
        return $result->toArray(); //  return group head member
	}

	public function GetBranchMembers1($branchid,$group_id) {
	$db = $this->getAdapter();
	$sql = "select * from ob_member 
		where bank_id = $branchid 
		and id not in
		(select member_id from ob_groupmembers 
		where groupmember_status = 3)";
			$result = $db->fetchAll($sql);
	return $result; // get branch members for branch id , group id
		
	}


	public function getgroupdetails($group_id) {
	$db = $this->getAdapter();
	$sql = "select * from ob_group 
		where id = $group_id";
		$result = $db->fetchAll($sql);
	return $result; // return group details for particular group id
		
	}
	public function assignMembers($group_id) {
			$select=$this->select()
				->setIntegrityCheck(false)
				->join(array('a' => 'ob_groupmembers'),array('id'),array('member_id'))
				->where('a.id = '.$group_id)
				->where('a.groupmember_status = 3')
				->join(array('b' => 'ob_member'),'b.id  = a.member_id');
			$result=$this->fetchAll($select);
			return $result->toArray();// return assigned members for group
	}
	public function UpdateGroupdetails($groupid) {
		$where = 'id = '.$groupid;
		$db = $this->getAdapter();
		$db->delete('ob_groupmembers',$where); // delete group details
	
	}
	public function getGrouptypeid($type) {
	$db = $this->getAdapter();
	$sql = "select membertype_id from ob_membertypes 
		where membertype ='".$type."'";
		$result = $db->fetchOne($sql);
	return $result; // return membertype id
		
	}
	public function getAccountstatus($groupid,$typeid){
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ob_accounts'),array('account_id'),array('accountstatus_id'))
			->where('a.member_id ='.$groupid)
			->where('a.membertype_id ='.$typeid);
		$result= $this->fetchAll($select);
		return $result->toArray(); // return the status of group 
	}

}
