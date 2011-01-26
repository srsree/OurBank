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
class Management_Model_Roles extends Zend_Db_Table {
     protected $_name = 'ourbank_grantactivites';

     public function addGrantActivites($data) {

		 $this->insert($data);


     }



     public function getRoles() {
               $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ourbank_grant') 
                       ->where('recordstatus_id = 3 OR recordstatus_id = 1');
               $result = $this->fetchAll($select);
               return $result->toArray();
     }
 
     public function getActivities() {

        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_submodule');
        $result = $this->fetchAll($select);
        return $result->toArray();
      // die($select->__toString($select));
    }
     
    public function getSubActivities() {

        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_activity')
                        ->group('activity_id');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }   


    public function getgrantActivities($grant_id) {

        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_grantactivites')
                        ->where('grant_id=?',$grant_id)
// 			->group('module_id')
			->where('recordstatus_id = 3');
// 			die($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function familyMemberUpdate($feildname,$table,$pk,$data)
    {
	$pk = intval($pk);
	$db = $this->getAdapter();
        $where[] = "$feildname = '".$pk."'";

	$result = $db->update($table,$data,$where);
        return $result;
    }

    public function getModule() {

        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_module');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }  
    public function getGrantname($grantId)
    {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ourbank_grant') 
                       ->where('grant_id=?',$grantId)
                       ->where('recordstatus_id = 3 OR recordstatus_id = 1');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }



    public function getMainModule($grantId) {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_grantactivites'),array('grantactivites_id'))
                        ->where('grant_id=?',$grantId)
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_module'),'a.module_id = b.module_id')
                        ->where('b.recordstatus_id = 3')
			->join(array('c' => 'ourbank_submodule'),'a.submodule_id = c.submodule_id')
                        ->join(array('d' => 'ourbank_activity'),'a.activity_id = d.activity_id')
                        ->group('a.submodule_id');
			
	$result = $this->fetchAll($select);
	return $result->toArray();
// 	die($select->__toString($select));
    }

    public function editActivity($grantId) {
    
        $db = $this->getAdapter();
        $sql = "SELECT
                c.activity_id,
                c.activity_name,
                a.module_id,
                b.submodule_id
                FROM
                ourbank_module a,
                ourbank_submodule b,
                ourbank_activity c,
                ourbank_grantactivites d
                WHERE
                a.module_id=b.module_id AND
                b.submodule_id=c.submodule_id AND
                c.activity_id=d.activity_id AND
                d.recordstatus_id = 3 AND
                grant_id= '$grantId'
                group by(c.activity_id)";
        
        return $db->fetchAll($sql);
    
    }

    public function getMainModule1($grantId) {
        $db = $this->getAdapter();
        
        $sql = "SELECT * FROM
                ourbank_submodule a
                WHERE a.submodule_id NOT
                IN (
                SELECT b.submodule_id
                FROM ourbank_grantactivites b
                WHERE b.grant_id = '".$grantId."' AND
                b.recordstatus_id = 3 
                )";
        
    return $db->fetchAll($sql);
    }

    public function editActivity1($grantId) {
        $db = $this->getAdapter();
        $sql = "SELECT c.activity_id,
                c.activity_name,
                a.module_id,
                b.submodule_id
                from 
                ourbank_module a, 
                ourbank_submodule b,
                ourbank_activity c
                where
                c.activity_id
                NOT IN (
                SELECT d.activity_id 
                FROM 
                ourbank_grantactivites d 
                WHERE (
                d.grant_id = ".$grantId." AND
                d.recordstatus_id = 3 AND
                b.submodule_id = d.submodule_id))
                group by c.activity_name 
                order by c.activity_id";

   return $db->fetchAll($sql);


    }

    public function editSubactivity($grantId) {

        	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_grantactivites'),array('grantactivites_id'))
                        ->where('grant_id=?',$grantId)
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('d' => 'ourbank_activity'),'a.activity_id = d.activity_id')
                        ->where('a.activity_id = d.activity_id')
                        ->group('d.activity_id');
	//die($select->__toString($select));		
	//$result = $this->fetchAll($select);
	//return $result->toArray();
    }

    public function getSubActivities1($grantId) {

        $select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_grantactivites'),array('grantactivites_id'))
                        ->where('grant_id=?',$grantId)
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('d' => 'ourbank_activity'),'a.activity_id != d.activity_id')
                        ->group('d.submodule_description');
	//die($select->__toString($select));		
	$result = $this->fetchAll($select);
	return $result->toArray();
    }

    public function searchRoles($post = array()) {

         $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->from('ourbank_grant') 
                       ->where('grantname like "%" ? "%" ' ,$post['field2'])
                       ->where('granteddate like "%" ? "%" ',$post['field3'])
                       ->where('recordstatus_id = 3 OR recordstatus_id = 1');
        $result = $this->fetchAll($select);
	return $result->toArray();
    }

    public function updateRole($grantId,$data) {
	$where = 'grant_id = '.$grantId;
	$this->update($data , $where);
    }

    public function deleteGrants($grantId,$data) {
	$where = 'grant_id = '.$grantId;
	$db = $this->getAdapter();
        $db->update('ourbank_grant', $data , $where);

    }
}
