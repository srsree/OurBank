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
class Expense_Model_expense  extends Zend_Db_Table {
    protected $_name = 'ourbank_expensedetails';

        public function getexpensetypes()
        {
        $select=$this->select()
                                ->setIntegrityCheck(false)
                                ->join(array('a'=>'ourbank_master_expense'),array('a.id'));
        $result=$this->fetchAll($select);
        return $result->toArray();
//         die ($select->__toString($select));
        }

	public function get_expensedetails($memberid)
        {
        $select=$this->select()
                                ->setIntegrityCheck(false)
                                ->join(array('a'=>'ourbank_expensedetails'),array('a.id'))
				->where('a.member_id=?',$memberid);
        $result=$this->fetchAll($select);
        return $result->toArray();
//         die ($select->__toString($select));
        }

     public function deleteexpense($param)  
            {
                $db = $this->getAdapter();
                            //$db->delete("ourbank_cropdetails",array('member_id = '.$param));
                $db->delete("ourbank_expensedetails",array('member_id = '.$param));
        
            // $db->exec("delete from ourbank_cropdetails where member_id = $param");
                return;
            }
/*
//update the family details with respective to member id...
    public function update($loanId,$input = array()) {
    $where[] = "id = '".$loanId."'";
    $db = $this->getAdapter();
    $result = $db->update('ourbank_loandetails',$input,$where);
    }*/

}
