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
class Commonviewuser_Model_Usergrants extends Zend_Db_Table_Abstract {
    protected $_name = 'ob_usergrants';

    public function grantsInsert($grant_id,$user_id) {
        foreach($grant_id as $grant_id) {
            $data = array('grant_id' => $grant_id,
                        'user_id' => $user_id,
                        'recordstatus_id'=>3);
            $this->insert($data);
        }
    }

     public function EdituserLogin($post,$createby,$user_id) {
        $data = array('grant_id' => $post['grant_id'],
                      'user_id' => $user_id,
                      'createdby'=>$createby,
                      'recordstatus_id'=>3);
      $this->insert($data);
     }
}
