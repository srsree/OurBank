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

class Reports_Model_Saccountsummary extends Zend_Db_Table
{
    protected $_name = 'ourbank_productsofferdetails';


    public function fetchSavingsDetails($office_id)
    {

                $select = $this->select()
                                ->setIntegrityCheck(false)  
                                ->from(array('B' => 'ourbank_productsofferdetails'))
                                ->where('B.recordstatus_id = 3 || B.recordstatus_id = 1')
                                ->join(array('C'=>'ourbank_accounts'),'C.product_id = B.offerproduct_id')
                                ->where('C.accountstatus_id = 3 || C.accountstatus_id = 1')
                                ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id','productname')
                                ->where('D.recordstatus_id = 3 AND D.category_id = 1 || D.recordstatus_id = 1')
                                ->join(array('E'=>'ourbank_members'),'E.member_id = C.member_id')
                                ->join(array('F'=>'ourbank_officenames'),'F.office_id = E.memberbranch_id')
                                ->where('F.recordstatus_id = 3 AND F.office_id = "'.$office_id.'" || F.recordstatus_id = 1')
                                ->group('D.productname');
                                
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
               

    }

    public function accountBalanceDetails($office_id)
    {
         $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from(array('A' => 'ourbank_accounts'))
                        ->where('A.accountstatus_id = 3 || A.accountstatus_id = 1')
                        ->join(array('B'=>'ourbank_productsofferdetails'),'A.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 || B.recordstatus_id = 1')
                        ->join(array('F' =>'ourbank_transaction'),'A.account_id = F.account_id')
                        ->where('F.recordstatus_id = 3 || F.recordstatus_id = 1')
                        ->join(array('J' =>'ourbank_productdetails'),'B.product_id = J.product_id')
                        ->where('J.recordstatus_id = 3 AND J.category_id = 1 || J.recordstatus_id = 1')
                        ->join(array('E'=>'ourbank_members'),'E.member_id = A.member_id')
                        ->join(array('G'=>'ourbank_officenames'),'G.office_id = E.memberbranch_id')
                        ->where('G.recordstatus_id = 3 AND G.office_id = "'.$office_id.'" || G.recordstatus_id = 1');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
               
    }

    public function SavingsDetails()
    {

                $select = $this->select()
                                ->setIntegrityCheck(false) 
                                ->from(array('B' => 'ourbank_productsofferdetails'))
                                ->where('B.recordstatus_id = 3 || B.recordstatus_id = 1')
                               ->join(array('C'=>'ourbank_accounts'),'C.product_id = B.offerproduct_id')
                               ->where('C.accountstatus_id = 3 || C.accountstatus_id = 1')
                               ->join(array('D' =>'ourbank_productdetails'),'D.product_id = B.product_id','productname')
                               ->where('D.recordstatus_id = 3 || D.recordstatus_id = 1')
                               ->where('D.category_id = 1');
                               
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
              

    }

    public function accountBalance()
    {
         $select = $this->select()
                        ->setIntegrityCheck(false) 
                        ->from(array('A' => 'ourbank_accounts'))
                        ->where('A.accountstatus_id = 1')
                        ->join(array('B'=>'ourbank_productsofferdetails'),'A.product_id = B.offerproduct_id')
                        ->where('B.recordstatus_id = 3 || B.recordstatus_id = 1')
                        ->join(array('F' =>'ourbank_transaction'),'A.account_id = F.account_id')
                        ->where('F.recordstatus_id = 3 || F.recordstatus_id = 1')
                        ->join(array('J' =>'ourbank_productdetails'),'B.product_id = J.product_id')
                        ->where('J.recordstatus_id = 3 AND J.category_id = 1 || J.recordstatus_id = 1 ');
                //die($select->__toString());
                $result = $this->fetchAll($select);
                return $result->toArray();
              
    }

    public function branchDetails() {
            $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_officenames')
                        ->where('recordstatus_id = 3 || recordstatus_id = 1');
            //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
    }

public function officeNamefetch($offie_id) {
            $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_officenames')
                        ->where('recordstatus_id = 3 || recordstatus_id = 1')
                        ->where('office_id = ?',$offie_id);
            //die($select->__toString());
            $result = $this->fetchAll($select);
            return $result->toArray();
    }

}
