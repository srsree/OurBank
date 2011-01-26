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
class Feecommon_Model_Feecommon extends Zend_Db_Table { 
 protected $_name = 'ob_feedetails';


 public function getfee($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_feedetails'),array('feedetails_id'))
                ->where('fee_id=?',$id)
                ->where('recordstatus_id=3')
			->join(array('b' => 'ob_member_types'),'a.feeappliesto_id = b.membertype_id');

        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
public function getmemtype($id)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_feedetails'),array('feedetails_id'))
                ->where('feedetails_id=?',$id)
                ->where('recordstatus_id=3');
        $result=$this->fetchAll($select);
        return $result->toArray();
       //die ($select->__toString($select));
    }
  public function getAppliesTo() {
        $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->join(array('a' => 'ourbank_membertypes'),array('membertype_id'));

        $result = $this->fetchAll($select);
        return $result->toArray();
        return $result;
    }

}
