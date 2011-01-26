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

class Depositsummary_Model_Depositsummary extends Zend_Db_Table
{
    protected $_name = 'ourbank_productsoffer';


    public function fetchSavingsDetails($office_id)
    {

                $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->join(array('B' => 'ourbank_productsoffer'),array('id'),array('B.name as prodoffername, count(B.name) as  countvalue'))
                                ->join(array('C'=>'ourbank_accounts'),'C.product_id = B.product_id')
                                ->where('C.status_id = 3 || C.status_id = 1')
                                ->join(array('D' =>'ourbank_product'),'D.id = B.product_id','D.name as productname')
                                ->where('D.category_id = 1')
                                ->join(array('E'=>'ourbank_member'),'E.id = C.member_id',array('E.name as membername'))
                                ->join(array('F'=>'ourbank_office'),'F.id = E.office_id',array('F.name as officename'))
                                ->where('F.id = "'.$office_id.'"');
//                                 ->group('B.name')
//                                 ->order('D.name');
//                 die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
    }

    public function accountBalanceDetails($office_id)
    {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from(array('A' => 'ourbank_accounts'))
                        ->where('A.status_id = 3 || A.status_id = 1')
                        ->join(array('B'=>'ourbank_productsoffer'),'A.product_id = B.id',array('B.id as offerprodid'))
                        ->join(array('F' =>'ourbank_transaction'),'A.id = F.account_id')
                        ->where('F.recordstatus_id = 3 || F.recordstatus_id = 1')
                        ->join(array('J' =>'ourbank_product'),'B.product_id = J.id')
                        ->where('J.category_id = 1')
                        ->join(array('E'=>'ourbank_member'),'E.id = A.member_id')
                        ->join(array('G'=>'ourbank_office'),'G.id = E.office_id')
                        ->where('G.id = "'.$office_id.'"');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
               
    }

    public function SavingsDetails()
    {

                $select = $this->select()
                                ->setIntegrityCheck(false) 
                                ->join(array('B' => 'ourbank_productsoffer'),array('id'),array('B.name as prodoffername, count(B.name) as  countvalue'))
                               ->join(array('C'=>'ourbank_accounts'),'C.product_id = B.product_id')
                               ->where('C.status_id = 3 || C.status_id = 1')

                               ->join(array('D' =>'ourbank_product'),'D.id = B.product_id','name as productname')
                               ->where('D.category_id = 1')
                                ->group('B.name')
                                ->order('D.name');
                  //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
              

    }

    public function accountBalance()
    {
         $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->from(array('A' => 'ourbank_accounts'))
                        ->where('A.status_id = 3 || A.status_id = 1')
                        ->join(array('B'=>'ourbank_productsoffer'),'A.product_id = B.product_id')
                        ->join(array('F' =>'ourbank_transaction'),'A.id = F.account_id')
                        ->where('F.recordstatus_id = 3 || F.recordstatus_id = 1')
                        ->join(array('J' =>'ourbank_product'),'B.product_id = J.id',array('name as productname'


))
                        ->where('J.category_id = 1');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
    }

        public function officeNamefetch($offie_id) {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->from('ourbank_office')
                ->where('id = ?',$offie_id);
        //die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
        }

}
