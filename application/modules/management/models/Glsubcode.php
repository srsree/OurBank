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
class Management_Model_Glsubcode extends Zend_Db_Table {
     protected $_name = 'ourbank_glsubcodeupdates';


     public function getGlsubcode() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_glsubcodeupdates'),array('glsubcode_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_glsubcode'),'a.glsubcode_id = b.glsubcode_id');
                        //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }


     
}
