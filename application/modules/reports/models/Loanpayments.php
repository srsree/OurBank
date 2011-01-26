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

class Reports_Model_Loanpayments extends Zend_Db_Table
{
protected $_name = 'ourbank_transaction';



	
public function fetchloanDetails($accNum)
{

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_categorydetails'),array('categoryname'))
->where('a.category_id = 2 AND a.recordstatus_id=3 OR a.recordstatus_id=1')
->join(array('b'=>'ourbank_productdetails'),'a.category_id = b.category_id')
->where('b.recordstatus_id=3')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->where('d.account_number like "%" ? "%"',$accNum)
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id')
->where('e.recordstatus_id=3');

//die($select->__toString());
return $this->fetchAll($select);
}
public function fetchdateDetails($accNum,$fromDate,$toDate)
{

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_categorydetails'),array('categoryname'))
->where('a.category_id = 2 AND a.recordstatus_id=3 OR a.recordstatus_id=1')
->join(array('b'=>'ourbank_productdetails'),'a.category_id = b.category_id')
->where('b.recordstatus_id=3')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->where('d.account_number like "%" ? "%"',$accNum)
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id')
->where('e.recordstatus_id=3')
->where('e.transaction_date >= "'.$fromDate.'"  AND e.transaction_date <= "'.$toDate.'"');


//die($select->__toString());
return $this->fetchAll($select);
}
public function fetchallDetails()
{

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_categorydetails'),array('categoryname'))
->where('a.category_id = 2 AND a.recordstatus_id=3 OR a.recordstatus_id=1')
->join(array('b'=>'ourbank_productdetails'),'a.category_id = b.category_id')
->where('b.recordstatus_id=3')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id')
->where('e.recordstatus_id=3');



//die($select->__toString());
return $this->fetchAll($select);
}
}
