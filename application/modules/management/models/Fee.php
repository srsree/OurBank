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
class Management_Model_Fee extends Zend_Db_Table {
    protected $_name = 'ourbank_feedetails';

    public function getAppliesTo() {
        $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->join(array('a' => 'ourbank_membertypes'),array('membertype_id'));
        $result = $this->fetchAll($select);
        return $result->toArray();
        return $result;
    }
 
    public function getDuration() {
        $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->join(array('a' => 'ourbank_activity'),array('activity_id'));
        $result = $this->fetchAll($select);
        return $result->toArray();
        return $result;
    }

    public function addFee($post,$fee_id) {
        if($post['fee_id']) {
            $fee_id = $post['fee_id'];
        } else {
            $fee_id = $fee_id;
        }
	$data = array('feedetails_id'=> '',
			'fee_id'=> $fee_id,
			'feename'=>$post['feename'],
			'feedescription'=>$post['feedescription'],
			'recordstatus_id'=>'3',
			'feevalue'=>$post['feevalue'],
			'feeappliesto_id'=>$post['feeappliesto_id'],
			'fee_action_id'=>$post['feefrequency_id'],
			'feefrequency_id'=>$post['feefrequency_id'],
			'createdby'=>'1',
			'createddate'=>date("Y-m-d"),
			'editedby'=>'1',
			'editeddate'=>date("Y-m-d"));
	$this->insert($data);
    }
  
    public function getFeeDetails() {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('feedetails_id'))
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_activity'),'a.fee_action_id = b.activity_id')
			->join(array('c' => 'ourbank_membertypes'),'a.feeappliesto_id = c.membertype_id');
			
	   $result = $this->fetchAll($select);
	   return $result->toArray();
         //die($select->__toString($select));
    }

    public function viewFee($feedetails_id) {
	$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('feedetails_id'))
                        ->where('a.feedetails_id = ?',$feedetails_id)
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_activity'),'a.fee_action_id = b.activity_id')
			->join(array('c' => 'ourbank_membertypes'),'a.feeappliesto_id = c.membertype_id');
			
	$result = $this->fetchAll($select);
	return $result->toArray();
	// die($select->__toString($select));
    }
	
	public function getcurrencysymbol() {
	$select = $this->select()
	->setIntegrityCheck(false)  
	->join(array('a' => 'ourbank_country'),array('country_id'))
	->where('a.country_id = 1');
			
	$result = $this->fetchAll($select);
	return $result->toArray();
	 //die($select->__toString($select));
    }

    public function searchFee($post = array()) {
        $select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_feedetails'),array('feedetails_id'))
                        ->where('a.feeappliesto_id like "%" ? "%"',$post['field1'])
                        ->where('a.feename like "%" ? "%"',$post['field2'])
			->where('a.feevalue like "%" ? "%"',$post['field3'])
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_activity'),'a.fee_action_id = b.activity_id')
			->join(array('c' => 'ourbank_membertypes'),'a.feeappliesto_id = c.membertype_id');
        $result = $this->fetchAll($select);
	return $result->toArray();
    }

    public function updateFee($feedetails_id,$feeDelete) {
	$where = 'feedetails_id = '.$feedetails_id;
	$this->update($feeDelete , $where );
    }
}
