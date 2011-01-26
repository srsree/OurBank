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
class Membership_Model_Individual extends Zend_Db_Table {
    protected $_name = 'ob_member';

    public function getMemberDetails() {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ob_member'),array('a.member_id'))
			->join(array('b' => 'ob_member_details'),'a.member_id = b.member_id')
                        ->where('b.recordstatus_id = 3')
			->order(array('a.member_id DESC'));   
	//die($select->__toString());		
	return $this->fetchAll($select);
    }

 }
