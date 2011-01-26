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
class App_Model_Access extends Zend_Db_Table 
{
    public function accessRights($resource,$role,$action)
    {
        $identity = Zend_Auth::getInstance()->getIdentity();
        $resmodel = new App_Model_Users();
        $this->resourceid = $resmodel->getResource($resource);
        $this->roleid = $resmodel->getRole($role);
        $db = Zend_Db_Table::getDefaultAdapter();
    
            $access = $db->fetchOne("SELECT 
                                    a.activity_id as activity_id
                                    FROM 
                                    ob_grantactivites a,
                                    ob_subactivity b
                                    where a.submodule_id='".$this->resourceid."' and 
                                    a.grant_id='".$this->roleid."' and 
                                    a.activity_id = b.activity_id and
                                    b.activity_description = '".$action."'");
        if($access['activity_id']) {
                $accessid = 1;
                return $accessid;
        } else {
                $accessid = 0;
                return $accessid;

                
        }
        
        
       }
       
       public function getRole($id) 
       {
       
               $db = Zend_Db_Table::getDefaultAdapter();
               $access = $db->fetchAll("SELECT 
                                    b.grantname as gname
                                    FROM 
                                    ob_usergrants a,
                                    ob_grant b
                                    where a.user_id='".$id."' and 
                                    a.grant_id = b.grant_id ");
            foreach ($access as $access) {
            
                   if ($access["gname"]) {
                   return $access['gname'];
                   }
            
            
            }

       
       }
}