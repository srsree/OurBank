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
class Incomedetails_Model_Incomedetails  extends Zend_Db_Table {
    protected $_name = 'ourbank_member';

        public function editIncometypes()
        {
        $select=$this->select()
                                ->setIntegrityCheck(false)
                                ->join(array('a'=>'ourbank_master_income'),array('a.id'));
        $result=$this->fetchAll($select);
        return $result->toArray();
        }

	public function getIncomedetails($memberid)
        {
        $select=$this->select()
                                ->setIntegrityCheck(false)
                                ->join(array('a'=>'ourbank_incomedetails'),array('a.id'))
				->where('a.member_id=?',$memberid);
        $result=$this->fetchAll($select);
        return $result->toArray();
        }

  public function deleteincome($param)  
            {
                $db = $this->getAdapter();
                $db->delete("ourbank_incomedetails",array('member_id = '.$param));
                return;
            }

}
