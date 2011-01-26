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
class App_Model_Users extends Zend_Db_Table
 {
    protected $_name="gender";

    public function userinfo($username) {
            $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_user'),array('id'))
                       ->where('a.username = ?',$username);

      // die ($select->__toString($select));

       return $this->fetchAll($select);
    }

    public function insertAct($input)
    {
        $db = $this->getAdapter();
	$db->insert('ob_subactivity',$input);
	return '1';
    }

    public function getActivity()
    {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ob_subactivity');
        return $this->fetchAll($select);
    }

    public function username($userid) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ob_user'),array('id'))
			->join(array('c'=>'ob_grant'),'a.grant_id=c.id')
			 ->where('a.id = ?',$userid);

        $result = $this->fetchAll($select);
        return $result->toArray();
    }
    // For Acl Implementation
    public function getRole($role) {

        $this->db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT id from ob_grant where name = '".$role."'";
        $result = $this->db->fetchOne($sql);
        return $result;

    }

    public function getRoleName($roleid) {

        $this->db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT grantname from ob_grant where grant_id = ".$roleid;
        $result = $this->db->fetchOne($sql);
        return $result;

    }
    
    public function getResource($resource) {

        $this->db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT submodule_id from ob_submodule where submodule_description = '".$resource."'";
        $result = $this->db->fetchOne($sql);
        return $result;

    }

    public function getResourceName($resourceid) {

        $this->db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT submodule_description from ob_submodule where submodule_id = ".$resourceid;
        $result = $this->db->fetchOne($sql);
        return $result;

    }
    public function getLanguage() {

        $this->db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT code from ob_language where 	active = 1";
        $result = $this->db->fetchOne($sql);
        return $result;

    }

    public function getSession() {

       $sessionName = new Zend_Session_Namespace('ourbank');
        if($sessionName->primaryuserid > 0) {
            $userid = $this->view->createdby = $sessionName->primaryuserid;
            $loginname = $this->username($userid);
			$language = $this->getLanguage();
			array_push($loginname,$language);
            return $loginname;
			
        } else { return 0; }

    }
 }


