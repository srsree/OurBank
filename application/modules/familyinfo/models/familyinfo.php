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
class Familyinfo_Model_familyinfo  extends Zend_Db_Table {
 protected $_name = 'ob_member';

 public function add_family($data) {
       $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->insert('ob_member_family',$data);
        return;
    }

    public function edit_family($member_id,$data)
    {
        $where = 'member_id = '.$member_id;
	$db = $this->getAdapter();
        $db->update('ob_member_family', $data , $where);
    }

}
