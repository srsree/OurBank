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

class Reports_Model_Incomeexpenditure extends Zend_Db_Table {
    protected $_name = 'ourbank_accounts';


    public function Searchfeeincomeexpenditure($fromdate,$toddate,$categoryID) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ourbank_bankfeeaccount'),array('bank_id'),array('SUM(a.amount_to_bank) as feeamount'))
        ->where('a.transaction_date >= "'.$fromdate.'"  AND a.transaction_date <= "'.$toddate.'"')
        ->join(array('b'=>'ourbank_accounts'),'a.From_account_number=b.account_id')
        ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id=c.offerproduct_id')
        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
        ->join(array('d'=>'ourbank_productdetails'),'c.product_id=d.product_id')
        ->where('d.recordstatus_id =3 OR d.recordstatus_id=1')
        ->join(array('e'=>'ourbank_categorydetails'),'d.category_id=e.category_id')
        ->where('e.recordstatus_id =3 OR e.recordstatus_id=1')
        ->where('e.category_id ="'.$categoryID.'"');
//         die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }


    public function Searchcapitalexpenditure($fromdate,$toddate,$categoryID) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ourbank_bankcapitalaccount'),array('bank_id'),array('SUM(a.amount_from_bank) as capitalamountexpenditure'))
        ->where('a.transaction_date >= "'.$fromdate.'"  AND a.transaction_date <= "'.$toddate.'"')        ->join(array('b'=>'ourbank_accounts'),'a.From_account_number=b.account_id')
        ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id=c.offerproduct_id')
        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
        ->join(array('d'=>'ourbank_productdetails'),'c.product_id=d.product_id')
        ->where('d.recordstatus_id =3 OR d.recordstatus_id=1')
        ->join(array('e'=>'ourbank_categorydetails'),'d.category_id=e.category_id')
        ->where('e.recordstatus_id =3 OR e.recordstatus_id=1')
        ->where('e.category_id ="'.$categoryID.'"');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function Searchcapitalincome($fromdate,$toddate,$categoryID) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ourbank_bankcapitalaccount'),array('bank_id'),array('SUM(a.amount_to_bank) as capitalamountincome'))
        ->where('a.transaction_date >= "'.$fromdate.'"  AND a.transaction_date <= "'.$toddate.'"')
        ->join(array('b'=>'ourbank_accounts'),'a.From_account_number=b.account_id')
        ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id=c.offerproduct_id')
        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
        ->join(array('d'=>'ourbank_productdetails'),'c.product_id=d.product_id')
        ->where('d.recordstatus_id =3 OR d.recordstatus_id=1')
        ->join(array('e'=>'ourbank_categorydetails'),'d.category_id=e.category_id')
        ->where('e.recordstatus_id =3 OR e.recordstatus_id=1')
        ->where('e.category_id ="'.$categoryID.'"');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }



    public function Searchinterestincome($fromdate,$toddate,$categoryID) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ourbank_bankinterstaccount'),array('bank_id'),array('SUM(a.amount_to_bank) as interestamountincome'))
        ->where('a.transaction_date >= "'.$fromdate.'"  AND a.transaction_date <= "'.$toddate.'"')
        ->join(array('b'=>'ourbank_accounts'),'a.From_account_number=b.account_id')
        ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id=c.offerproduct_id')
        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
        ->join(array('d'=>'ourbank_productdetails'),'c.product_id=d.product_id')
        ->where('d.recordstatus_id =3 OR d.recordstatus_id=1')
        ->join(array('e'=>'ourbank_categorydetails'),'d.category_id=e.category_id')
        ->where('e.recordstatus_id =3 OR e.recordstatus_id=1')
        ->where('e.category_id ="'.$categoryID.'"');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function Searchinterestexpenditure($fromdate,$toddate,$categoryID) {
        $select = $this->select()
        ->setIntegrityCheck(false)  
        ->join(array('a' => 'ourbank_bankinterstaccount'),array('bank_id'),array('SUM(a.amount_from_bank) as interestamountexpenditure'))
        ->where('a.transaction_date >= "'.$fromdate.'"  AND a.transaction_date <= "'.$toddate.'"')
        ->join(array('b'=>'ourbank_accounts'),'a.From_account_number=b.account_id')
        ->join(array('c'=>'ourbank_productsofferdetails'),'b.product_id=c.offerproduct_id')
        ->where('c.recordstatus_id =3 OR c.recordstatus_id=1')
        ->join(array('d'=>'ourbank_productdetails'),'c.product_id=d.product_id')
        ->where('d.recordstatus_id =3 OR d.recordstatus_id=1')
        ->join(array('e'=>'ourbank_categorydetails'),'d.category_id=e.category_id')
        ->where('e.recordstatus_id =3 OR e.recordstatus_id=1')
        ->where('e.category_id ="'.$categoryID.'"');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

}
