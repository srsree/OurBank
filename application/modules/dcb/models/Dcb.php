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
 *  model page for fetch and return Dcb details, filtered search details
 */
class Dcb_Model_Dcb extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
    // loan details	
    public function fetchloanDetails() {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('d'=>'ourbank_accounts'),array('id'))
                ->where('d.status_id=3 OR d.status_id=1')
                ->join(array('c'=>'ourbank_productsoffer'),'c.product_id = d.product_id')
                ->join(array('e'=>'ourbank_installmentdetails'),'d.id = e.account_id',array('e.installment_status','e.installment_principal_amount','e.installment_interest_amount','e.installment_date'))
                ->join(array('f'=>'ourbank_member'),'f.id = d.member_id',array('f.id','f.office_id'))
                ->join(array('g'=>'ourbank_office'),'g.id = f.office_id',array('g.name as office_name','g.id as officeid'));
        $result = $this->fetchAll($select);
        return $result;
    }
    // account details	
    public function accounts() {
            $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a' => 'ourbank_accounts'),array('id'))
                    ->where('a.status_id=3 OR a.status_id=1')
                    ->join(array('D'=>'ourbank_member'),'D.id = a.member_id');
            return $this->fetchAll($select);
    }
    // office details
    public function office() {
            $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('A' => 'ourbank_member'),array('office_id','id'))
                    ->join(array('D'=>'ourbank_office'),'A.office_id = D.id',array('name as officename','id as officeid'))
                    ->group('A.office_id');
            return $this->fetchAll($select);
    }
	
}