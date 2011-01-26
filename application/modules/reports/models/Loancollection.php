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

class Reports_Model_Loancollection extends Zend_Db_Table
{
protected $_name = 'ourbank_transaction';



	
public function fetchloanDetails()
{




$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_categorydetails'),array('categoryname'))
->where('a.category_id = 2 AND a.recordstatus_id=3 OR a.recordstatus_id=1')
->join(array('b'=>'ourbank_productdetails'),'a.category_id = b.category_id')
->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.recordstatus_id=3 OR c.recordstatus_id=1')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('d.accountstatus_id=3 OR d.accountstatus_id=1')
->group('d.account_number')
->join(array('e'=>'ourbank_installmentdetails'),'d.account_id = e.account_id',array('SUM(e.accountinstallment_amount) as amount','SUM(e.accountinstallment_interest_amount) as interest'))
->where('e.installment_status=2')
->join(array('f'=>'ourbank_installmentdetails'),'d.account_id = e.account_id',array('SUM(f.accountinstallment_amount) as currentamount','SUM(f.accountinstallment_interest_amount) as currentinterest'))
->where('f.installment_status=4');

//die($select->__toString());


return $this->fetchAll($select);

}
// public function fetchloaDetails()
// {
// 
// 
// $select = $this->select()
// ->setIntegrityCheck(false)  
// ->join(array('a' => 'ourbank_categorydetails'),array('categoryname'))
// ->where('a.category_id = 2 AND a.recordstatus_id=3 OR a.recordstatus_id=1')
// ->join(array('b'=>'ourbank_productdetails'),'a.category_id = b.category_id')
// ->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
// ->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
// ->where('c.recordstatus_id=3 OR c.recordstatus_id=1')
// ->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
// ->where('d.accountstatus_id=3 OR d.accountstatus_id=1')
// ->group('d.account_number')
// ->join(array('e'=>'ourbank_installmentdetails'),'d.account_id = e.account_id')
// ->where('e.installment_status=2')
// //die($select->__toString());
// ->group('e.account_id');
// 
// 
// return $this->fetchAll($select);

}