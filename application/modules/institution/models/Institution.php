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
 *  model page for fetch and return institution details
 */
class Institution_Model_Institution extends Zend_Db_Table 
{
    protected $_name = 'ob_institution';
        
    public function searchRecord($name)
    {
		$select = $this->select()
					->setIntegrityCheck(false)  
					->join(array('a' => 'ob_institution'),array('id '))
                	->where('a.name like "%" ? "%"',$name)
					->order('id DESC');
		return $this->fetchAll($select);
    }
}
