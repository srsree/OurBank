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
class Plugin_Model_memberplugin extends Zend_Db_Table 
{
	protected $_name = 'member_ship_plugin';

	public function fetch_all_detail() 
        {
	$select = $this->select()

			->setIntegrityCheck(false)  

			->join(array('p' => 'member_ship_plugin'),array('plugin_id'));


		$result = $this->fetchAll($select);

		return $result->toArray();
                die($select->__toString($select));
	}

       public function updateModule($rootid,$status)
        {
       echo $rootid;
        echo $status;
        $data = array('staus'=> $status);
        $where= 'plugin_id='. $rootid;
        $this->update($data,$where);
        }
}