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
class settings_Model_Setting extends Zend_Db_Table 
{ 
     protected $_name=''; 
//     public function fetchAllLanguage() 
//     {
//         $select = $this->select()
// 			->join(array('a' => 'ourbank_language'),array('language_id'))
// 			->order(array('language_id'));
//           $result = $this->fetchAll($select);
//           return $result->toArray();
//      //  die($select->__toString($select));
// //         $this->db = Zend_Db_Table::getDefaultAdapter();
// //         $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
// //         $result = $this->db->fetchAll('SELECT * FROM ourbank_language ORDER BY language_id');
// //         return $result;
//     }
}