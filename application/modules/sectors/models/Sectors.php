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

class Sectors_Model_Sectors extends Zend_Db_Table 
{
        // set ob_sector is a parent table 
	protected $_name = 'ob_sector';

	public function SearchSectors($post) 
	{
            $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('b' => 'ob_sector'),array('id'))
                    ->where('b.name  like "%" ? "%"',$post);
            $result = $this->fetchAll($select); // return  sector details according to search criteria
            return $result->toArray();
	}
        // get the status of activity which is used by any one or not 
        public function getSectorstatus($sectorid) {
            $db = $this->getAdapter();
            $sql = "select * from ob_activity 
                    where sector_id  = $sectorid";
                    $result = $db->fetchAll($sql);
            return $result; // return the status for activity id
	} 
}
