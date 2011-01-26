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
class Enquiry_Model_FeeDetails extends Zend_Db_Table_Abstract 
{

protected $_name = 'ourbank_productsofferdetails'; 

        public function fetchAllProducts()  {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->from('ourbank_productsofferdetails')
                        ->where('recordstatus_id=3');
            //die($select->__toString());
            return $this->fetchAll($select);
    }

        public function feeSearch($fromDate,$toDate,$productName)  {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productfee'),array('a.fee_id'))
                       ->join(array('b' => 'ourbank_feedetails'),'a.fee_id = b.fee_id')
                       ->join(array('c' => 'ourbank_productdetails'),'c.recordstatus_id = b.recordstatus_id')
                       ->join(array('d' => 'ourbank_productsofferdetails'),'d.product_id = c.product_id')
                       ->where('d.offerproduct_id = ?',$productName)
                       ->join(array('f' => 'ourbank_accounts'),'f.product_id = c.product_id')
                       ->join(array('e' => 'ourbank_transaction'),'e.account_id = f.account_id')
                       ->where('e.transaction_date >= "'.$fromDate.'" AND e.transaction_date <= "'.$toDate.'"')
                       ->join(array('j' => 'ourbank_userloginupdates'),'j.createdby = e.created_by');
           //die($select->__toString());
           return $this->fetchAll($select);
                }
}



