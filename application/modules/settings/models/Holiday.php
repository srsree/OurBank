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
class Management_Model_Holiday extends Zend_Db_Table {
     protected $_name = 'ourbank_holidayupdates';


        public function getHoliday() {
                    $select = $this->select()
                               ->setIntegrityCheck(false)  
                               ->join(array('h' => 'ourbank_holidayupdates'),array('office_id'))
                               ->where('h.recordstatus_id = 3')
                               ->join(array('o'=>'ourbank_officenames'),'h.office_id = o.office_id')
                               ->where('o.recordstatus_id = 3')
                               ->join(array('r'=>'ourbank_holidayrepayment'),'h.holidayrepayment_id = r.holidayrepayment_id');
            $result = $this->fetchAll($select);
            return $result->toArray();
        }
        public function viewholiday($holidayupdate_id) {
            $holidayupdate_id = (int)$holidayupdate_id;
            $result = $this->fetchAll('holidayupdate_id = '.$holidayupdate_id);
            return $result->toArray();
        }



        public function insertHoliday($post) {
            $data = array('holidayupdate_id'=> '',
                          'holiday_id'=> '3',
                          'recordstatus_id'=>'3',
                          'holidayname'=>$post['holidayname'],
                          'office_id'=>$post['office_id'],
                          'holidayfrom'=>$post['holidayfrom'],
                          'holidayupto'=>$post['holidayupto'],
                          'holidayrepayment_id'=>$post['holidayrepayment_id']);
            $this->insert($data);
        }

        public function deleteHoliday($holidayupdate_id) {
            $data = array('recordstatus_id'=> 1);
            $where = 'holidayupdate_id = '.$holidayupdate_id;
            $this->update($data , $where );
        }
}
