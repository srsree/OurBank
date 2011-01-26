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

class Groupmdefault_Model_groupdefault extends Zend_Db_Table {
   	protected $_name = 'ourbank_member'; // set ourbank_member is a parent table

        public function getofficehierarchy()
        {
         $db = $this->getAdapter();
        $sql = "SELECT id as hierarchyid FROM `ourbank_officehierarchy` where Hierarchy_level in (SELECT max(Hierarchy_level) FROM `ourbank_officehierarchy`)";
        $result = $db->fetchAll($sql);
        return $result;
        }
	
        // get branch members
	public function GetBranchMembers($branchid) {
	$db = $this->getAdapter();
	$sql = "select * from ourbank_member 
            where office_id = $branchid
            and id not in
            (select member_id from ourbank_groupmembers 
            where (groupmember_status = 3 or groupmember_status = 1) and id in (select id from ourbank_groupmembers where (groupmember_status = 3 or groupmember_status = 1)))";
	$result = $db->fetchAll($sql);
	return $result;
	}

	public function Getgrouphead($group_id){
            $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a' => 'ourbank_group'),array('id'),array('head'))
                ->where('a.id = '.$group_id)
                ->join(array('b' => 'ourbank_member'),'b.id  = a.head',array('name'));
        $result=$this->fetchAll($select);
        return $result->toArray(); //  return group head member
	}

	public function GetBranchMembers1($branchid,$group_id) {
	$db = $this->getAdapter();
	$sql = "select * from ourbank_member 
		where office_id = $branchid 
		and id not in
		(select member_id from ourbank_groupmembers 
		where groupmember_status = 3 or groupmember_status = 1)";
			$result = $db->fetchAll($sql);
	return $result; // get branch members for branch id , group id
	
	}
// 
// 
	public function getgroupdetails($group_id) {
	$db = $this->getAdapter();
	$sql = "select * from ourbank_group 
		where id = $group_id";
		$result = $db->fetchAll($sql);
	return $result; // return group details for particular group id
		
	}
	public function assignMembers($group_id) {
			$select=$this->select()
				->setIntegrityCheck(false)
				->join(array('a' => 'ourbank_groupmembers'),array('id'),array('member_id'))
				->where('a.id = '.$group_id)
				->where('a.groupmember_status = 3 or a.groupmember_status = 1')
				->join(array('b' => 'ourbank_member'),'b.id  = a.member_id');
			$result=$this->fetchAll($select);
			return $result->toArray(); // return assigned members for group
	}
	public function UpdateGroupdetails($groupid) {
		$where = 'id = '.$groupid;
		$db = $this->getAdapter();
		$db->delete('ourbank_groupmembers',$where); // delete group details
	
	}
	public function getGrouptypeid($type) {
	$db = $this->getAdapter();
	$sql = "select id from ourbank_membertypes 
		where type ='".$type."'";
		$result = $db->fetchOne($sql); // return membertype id
	return $result;
       }
        public function getProductid($grouptypeid){
        $db = $this->getAdapter();
        $sql = "select id,name,product_id from ourbank_productsoffer where (applicableto =".$grouptypeid.") and product_id in(select category_id from ourbank_product)"; 
        $result = $db->fetchAll($sql); // return the product id details for that group 
	return $result;

        }
        public function getAccountstatus($groupid,$typeid){
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ourbank_accounts'),array('id'),array('status_id'))
			->where('a.member_id ='.$groupid)
			->where('a.membertype_id ='.$typeid);
		$result= $this->fetchAll($select);
		return $result->toArray(); // return the status of group 
	}
// //         public function insertgroupMemberAccount($input) {
// //                 $db = $this->getAdapter();
// //                 $db->insert('ourbank_groupmembers_acccounts',$input);
// //             }


}
