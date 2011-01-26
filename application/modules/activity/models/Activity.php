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
class Activity_Model_Activity extends Zend_Db_Table 
{
    protected $_name = 'ob_activity'; // set ob_activity table is parent table 

        public function SearchActivity($post) 
	{

		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_activity'),array('id'))
			->where('a.name  like "%" ? "%"',$post['activity'])
    			->where('a.sector_id  like "%" ? "%"',$post['sector'])
                        ->join(array('b'=>'ob_sector'),'b.id=a.sector_id',array('name as sectorname'));;
		$result = $this->fetchAll($select);
		return $result->toArray(); // return activity details according to search cretiria
	}

        public function IndexActivity()
	{
        $select = $this->select()
                  ->setIntegrityCheck(false)  
                  ->join(array('a' => 'ob_activity'),array('id','name','sector_id'))
		  ->join(array('b'=>'ob_sector'),'b.id=a.sector_id',array('name as sectorname'));
        $result = $this->fetchAll($select);
		return $result->toArray(); // return available activity details
	}
        // edit activity table records for particular id
	public function editActivity($id)
	{
        $select = $this->select()
                  ->setIntegrityCheck(false)  
                  ->join(array('a' => 'ob_activity'),array('id','name'))
				  ->join(array('b'=>'ob_sector'),'b.id=a.sector_id')
			      ->where('a.id = ?',$id);
        $result = $this->fetchAll($select);
		return $result->toArray();
	}
        public function viewActivity($id)
	{
        $select = $this->select()
                  ->setIntegrityCheck(false)  
                  ->join(array('a' => 'ob_activity'),array('id','name','sector_id'))
		  ->join(array('b'=>'ob_sector'),'b.id=a.sector_id',array('name as sectorname'))
                  ->where('a.id=?',$id);
        $result = $this->fetchAll($select);
		return $result->toArray(); // get activity details as per the activity id
	}
        // get the status of activity which is used by any one or not 
        public function getActivitystatus($activityid) {
            $db = $this->getAdapter();
            $sql = "select * from ob_accounts 
                    where activity_id = $activityid";
                    $result = $db->fetchAll($sql);
            return $result; // return the status for activity id
	} 

}
