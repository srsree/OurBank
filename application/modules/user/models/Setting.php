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
class Fee_Model_Setting extends Zend_Db_Table { 
 protected $_name = 'ourbank_feedetails';

 public function getFeeDetails() {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('feedetails_id'))
                        ->where('a.recordstatus_id = 3');
	//die($select->__toString());		
	return $this->fetchAll($select);
    }
public function feeSearch($post) {


                $select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('feedetails_id'))
                        ->where('a.feename like "%" ? "%"',$post['field3'])
                        ->where('a.feevalue like "%" ? "%"',$post['field2'])
			->where('a.recordstatus_id = 3');
			
        return $this->fetchAll($select);
        }
}