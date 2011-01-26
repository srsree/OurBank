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
 *  model page to fetch and return activity details and filtered search details
 */
class Activityaccounts_Model_activityaccounts extends Zend_Db_Table {
    protected $_name = 'ob_member';

	//get activity details
	public function getactivity_accounts($bank_id) {
			
         $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_accounts'),array('a.account_id'),array('COUNT(a.account_id)','a.account_number'))
                ->where('a.accountstatus_id=1 or a.accountstatus_id=3')
		->join(array('b'=>'ob_activity'),'b.id=a.activity_id',array('b.id','b.name'))
                ->where('b.status=1 or b.status=3')
		->group('b.id')
		->join(array('c'=>'ob_member'),'c.id=a.member_id',array('c.id','c.member_name'))
		->where('c.bank_id like "%" ? "%"',$bank_id);
         $result=$this->fetchAll($select);
         return $result->toArray();
    }

	//get bank details
    public function getBankname()
    {
          $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_bank'),array('a.id','a.name'))
                ->where('a.status=1 or a.status=3');
         $result=$this->fetchAll($select);
         return $result->toArray();
    }

	//search bankdetails
    public function getbank($bankid)
    {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a'=>'ob_bank'),array('id'),array('a.name'))
                        ->where('a.status = 3 OR a.status = 1')
			->where('a.id=?',$bankid);

       $result=$this->fetchAll($select);
        return $result->toArray();
    }

 }
