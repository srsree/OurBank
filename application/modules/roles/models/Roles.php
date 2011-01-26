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
// roles model page which is used to insert,edit,delete values for roles  
class Roles_Model_Roles extends Zend_Db_Table {
        // declare ob_grantactivity as a parent table 
	protected $_name = 'ob_grantactivity';
	// insert all grant activity values
	public function addGrantActivites($data) {
            $this->insert($data);
	}	
        // get grant details 
	public function getRoles() {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from('ob_grant');
            $result = $this->fetchAll($select);
            return $result->toArray(); // return grant details 
	}
        // get search details 
	public function searchRoles($post) { 
	$convertdate = new App_Model_dateConvertor();
	if($post['granteddate']){
	$searchdate = $convertdate->mysqlformat($post['granteddate']);}
	else{$searchdate=$post['granteddate'];}
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from('ob_grant') 
                    ->where('name like "%" ? "%" ' ,$post['grantname'])
                    ->where('created_date  like "%" ? "%" ',$searchdate);
	$result = $this->fetchAll($select);
	return $result->toArray();// return searched grant details 
	}
        // get all module details
 	public function getModule() {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_modules');
        $result = $this->fetchAll($select);
        return $result->toArray(); // return all module details
    	}
        // get all sub modules list
	public function getSubmodule($moduleid) {
	   $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ob_modules'),array('module_id'),array('module_id','module_description'))
                    ->where('parent=?',$moduleid);
		$result = $this->fetchAll($select);
		return $result->toArray(); // return all sub modules list
	}
        // update table data according to parameter values
        public function updateRecord($table,$data,$modid){
            $db = $this->getAdapter();
            $where[] = "module_id = '".$modid."'";
            $db->update($table,$data,$where);
        }
        // get grant activity for particular grant id 
         public function viewModuleid($grantid) {
            $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_grantactivity'),array('id'),array('module_id'))
                ->where('grant_id =?',$grantid);
            $result = $this->fetchAll($select);
            return $result->toArray(); // return grant activity for particular grant id 
    	}
        // get grant activity for particular module id 
	public function getActivity($moduleid,$grantid) {
                $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ob_grantactivity'),array('id'),array('add','edit','view','delete'))
                    ->where('grant_id ='.$grantid)
                    ->where('module_id ='.$moduleid);
		$result = $this->fetchAll($select);
		return $result->toArray();// return grant activity for particular module id 
	}   
        // edit grant activity details
        public function editactivity($grantid) {
                $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ob_grantactivity'),array('id'),array('id','module_id','add','edit','view','delete'))
                    ->where('grant_id ='.$grantid);
		$result = $this->fetchAll($select);
		return $result->toArray();
	} 
        // insert values according to sending parameter
        public function editactivitydetails($table,$data){
            $db = $this->getAdapter();
            $db->insert($table,$data);
        } 
        // delete activity 
        public function deleteactivity($table,$grantid){
            $db = $this->getAdapter();
            $where = 'grant_id = '.$grantid;
            $db->delete($table,$where);
        }
        // delete grant name
        public function deletegrantname($table,$grantid){
            $db = $this->getAdapter();
            $where = 'id = '.$grantid;
            $db->delete($table,$where);
        }
        // get single record of grant name for that grant id
	 public function getGrantname($grantid) {
            $db = $this->getAdapter();
            $sql = "select name from ob_grant 
                    where id = $grantid";
                    $result = $db->fetchOne($sql);
            return $result; // return grant name
	} 
        // get the status of grant id which is used by any one or not 
        public function getRolestatus($grantid) {
            $db = $this->getAdapter();
            $sql = "select * from ourbank_user 
                    where grant_id = $grantid";
                    $result = $db->fetchAll($sql);
            return $result; // return the status for grant id
	} 
}
