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

class Reports_Model_Productwise extends Zend_Db_Table
{
protected $_name = 'ourbank_transaction';



	
public function fetchproductDetails()
{


$select = $this->select()
->setIntegrityCheck(false)
->join(array('a' => 'ourbank_product'),array('product_id'))
->join(array('b'=>'ourbank_productdetails'),'a.product_id = b.product_id')
->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id',array('SUM(amount_to_bank) as amount_to_bank','SUM(amount_from_bank) as amount_from_bank'))
->where('e.recordstatus_id=3')
->group('b.productname');
//die($select->__toString());

return $this->fetchAll($select);

}
}