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
class App_Model_Acl extends Zend_Acl {


	public function __construct() 
	{
		/*
		 * Need to implement these features .Roles,Resources and Access
		 */
		
		/*
		 *  Roles
		 *
		 */

			$db = Zend_Db_Table::getDefaultAdapter();
			$roles = $db->fetchAll("select grantname from ob_grant");

			foreach ($roles as $role)
			{

			$this->addRole(new Zend_Acl_Role($role['grantname']));

			}
                // Eg. admin, manager

		/*
		 *  Resources
		 *
		 */
		
		
		$db = Zend_Db_Table::getDefaultAdapter();
			$resources = $db->fetchAll("select submodule_description from ob_submodule");

			foreach ($resources as $resources)
			{

			$this->add(new Zend_Acl_Resource($resources['submodule_description']));

			}
                // folder name management---->

		/*
		 *  Access
		 *
		 */
		
                $rolenames = new App_Model_Users();
		
		$db = Zend_Db_Table::getDefaultAdapter();
 		$access = $db->fetchAll("SELECT B.grant_id,
 		                                 B.submodule_id,
 		                                 C.activity_id
 		                                 FROM
 		                                 ob_grantactivites B,
 		                                 ob_subactivity C
 		                                 where
 		                                 C.activity_id = B.activity_id");
 		//edit,view,___,

		foreach ($access as $access) 
			{

 	                      if($access["activity_id"]) {
 	                      $this->allow($rolenames->getRoleName($access["grant_id"]),$rolenames->getResourceName($access["submodule_id"]),1);
 	                      } else {
                                  $this->deny($rolenames->getRoleName($access["grant_id"]),$rolenames->getResourceName($access["submodule_id"]),0);
				}
			}

    }
}