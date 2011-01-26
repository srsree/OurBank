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

class Groupcommonview_Model_groupcommon extends Zend_Db_Table {
    protected $_name = 'ob_member'; // set ob_member table is a base table

        // get group details 
	public function getgroup($id){
            $select=$this->select()
                    ->setIntegrityCheck(false)
                    ->join(array('a' => 'ob_group'),array('id'),array('id as groupid','bank_id','name as group_name','group_created_date'))
                    ->where('a.id = '.$id)
                    ->join(array('b' => 'ob_bank'),'b.id  = a.bank_id',array('name as bankname'));
            $result=$this->fetchAll($select);
            return $result->toArray();
        }
        // get group members 
        public function getgroupmembers($id){
        $select=$this->select()
                ->setIntegrityCheck(false)
        	->join(array('a' => 'ob_groupmembers'),array('id'),array('id as groupid','member_id'))
		->where('a.groupmember_status = 3')
		->where('a.id = '.$id)
         	->join(array('b' => 'ob_member'),'b.id = a.member_id')
		->join(array('c' => 'ob_group'),'c.id ='.$id,array('group_head'));
       $result=$this->fetchAll($select);
       return $result->toArray();
        }

     // get module description  details 
        public function getmodule($modulename){
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('ob_modules'),array('module_id'))
                ->where('module_description=?',$modulename);
            $result=$this->fetchAll($select);
        return $result->toArray();
   }
}
