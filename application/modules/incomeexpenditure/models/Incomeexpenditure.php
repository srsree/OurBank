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

class Incomeexpenditure_Model_Incomeexpenditure extends Zend_Db_Table {
    protected $_name = 'ourbank_transaction';
	public function incomedetails($date) {
            $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ourbank_transaction'),array('transaction_id'),array('glsubcode_id_to','transaction_date'))
                    ->where('a.transaction_date <= "'.$date.'"')
                    ->where('a.recordstatus_id =3 OR a.recordstatus_id=1')
                    ->join(array('b'=>'ourbank_glsubcode'),'b.id=a.glsubcode_id_to',array('header'))
                    ->join(array('c'=>'ourbank_Income'),'c.glsubcode_id_to=a.glsubcode_id_to',array('sum(credit) as credit'))
                        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
                    ->group('b.header');
                    
            //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
	} 
	public function expendituredetails($date) {
            $select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ourbank_transaction'),array('transaction_id'),array('glsubcode_id_to','transaction_date'))
		->where('a.transaction_date <= "'.$date.'"')
		->where('a.recordstatus_id =3 OR a.recordstatus_id=1')
		->join(array('b'=>'ourbank_glsubcode'),'b.id=a.glsubcode_id_to',array('header'))
		->join(array('c'=>'ourbank_Expenditure'),'c.glsubcode_id_to=a.glsubcode_id_to',array('sum(credit) as credit'))
                ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
		->group('b.header');
        // die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}

