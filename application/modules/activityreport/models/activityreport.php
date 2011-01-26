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
 *  model page for fetch and return activity details, filtered search details
 */
class Activityreport_Model_activityreport extends Zend_Db_Table {
    protected $_name = 'ob_member';
	//age calculation from two table
	public function getactivity_between($from_age,$to_age,$activityname,$gender) {
			
                        $db = $this->getAdapter();
                        $sql = "SELECT c.account_id, COUNT(c.account_id) as accountcount,d.name FROM `ob_member` AS `b` INNER JOIN `ob_accounts` AS `c` ON c.member_id = b.id INNER JOIN `ob_activity` AS `d` ON d.id  = c.activity_id WHERE ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))>=$from_age) and ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))<=$to_age) and (c.accountstatus_id=1) and (d.status=1 or d.status=3) and d.id like '%".$activityname."%' and b.member_gender like '%".$gender."%'";
                        $result = $db->fetchAll($sql);
                        return $result;
		
    }
	//age calculation above the limit
     public function getactivity_above($age,$activityname,$gender) {
                        $db = $this->getAdapter();
                        $sql = "SELECT c.account_id, COUNT(c.account_id) as accountcount,d.name FROM `ob_member` AS `b` INNER JOIN `ob_accounts` AS `c` ON c.member_id = b.id INNER JOIN `ob_activity` AS `d` ON d.id  = c.activity_id WHERE ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))>=$age) and (c.accountstatus_id=1) and (d.status=1 or d.status=3) and d.id like '%".$activityname."%' and b.member_gender like '%".$gender."%'";
                        $result = $db->fetchAll($sql);
                        return $result;
    }
	//get activity detail
    public function getActivity()
    {
          $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_activity'),array('a.name'))
                ->where('a.status=1 or a.status=3');
         $result=$this->fetchAll($select);
         return $result->toArray();
         die ($select->__toString($select));
    }
	//search deatails
    public function getactivityname($activityname)
    {
          $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_activity'),array('a.member_id'),array('a.name'))
                ->where('a.id=?',$activityname)
                ->where('a.status=1 or a.status=3');
       $result=$this->fetchAll($select);
        return $result->toArray();
    }
	//fetch gender details
  	public function getGender() {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('gender');
         return $result = $this->fetchAll($select);
    }

	//fetch report details
	public function getReport() {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_reporttype');
         return $result = $this->fetchAll($select);
    }
	//search gender id
	public function getGendername($gender) {

         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('gender')
			->where('id=?',$gender);
         return $result = $this->fetchAll($select);
    }

 }
