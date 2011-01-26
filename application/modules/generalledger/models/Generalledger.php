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
class Generalledger_Model_Generalledger extends Zend_Db_Table
{
    protected $_name = 'ourbank_transaction';
//     public function fetchAllProductNames() 
//     {
//         $select = $this->select()
// 		->setIntegrityCheck(false)  
// 		->join(array('p' => 'ourbank_product'),array('id'));
// 	$result = $this->fetchAll($select);
// 	return $result->toArray();
//     }
    
//     public function getGlsubocde() 
//     {
//         $select = $this->select()
// 		->setIntegrityCheck(false)  
//                         ->from(array('A' => 'ourbank_glsubcode'))
//                         ->join(array('C'=>'ourbank_glsubcodeupdates'),'C.glsubcode_id = A.glsubcode_id')
//                         ->where('C.recordstatus_id =3 OR C.recordstatus_id =1')
// 			->order('A.glsubcode');
// 	$result = $this->fetchAll($select);
// 	return $result->toArray();
//     }
    
    public function generalLedger($date1,$date2,$glsubcode) 
    {
        $db = $this->getAdapter();
        $sql = "select 
                    D.id as glsubcode_id,
		    D.glsubcode as glsubcode,
                    D.header as subheader,
                    sum(A.credit) as credit,
                    sum(A.debit) as debit
                    from 
		    ourbank_Liabilities A,
		    ourbank_glcode B,
		    ourbank_glsubcode D,
		    ourbank_transaction E
		    where (
		    (D.id = '".$glsubcode."' '%') AND  
                    A.glsubcode_id_to = D.id AND 
		    B.id = D.glcode_id AND
		    B.ledgertype_id = 4 AND
		    A.transaction_id = E.transaction_id AND
                    E.transaction_date BETWEEN '$date1' AND '$date2')
		    group by D.id";
        $result=$db->fetchAll($sql);
        return $result;

    }
    
    public function openingBalance($date,$glsubcode) 
    {
        $db = $this->getAdapter();
        $sql = "select 
                    F.id as glsubcode_id,
		    F.glsubcode as glsubcode,
                    F.header as subheader,
                    (sum(A.credit)-sum(A.debit)) as openingCash
                    from 
		    ourbank_Liabilities A,
		    ourbank_glcode B,
	            ourbank_transaction E,
		    ourbank_glsubcode F
		    where (
		    (F.id = '".$glsubcode."' '%') AND  
                    A.glsubcode_id_to = F.id AND 
		    B.id = F.glcode_id AND
		    B.ledgertype_id = 4 AND
		    A.transaction_id = E.transaction_id AND
                    E.transaction_date < '$date') 
		    group by F.id";
        $result=$db->fetchAll($sql);
        return $result;

    }
    public function generalLedgerAssets($date1,$date2,$glsubcode) 
    {
        $db = $this->getAdapter();
        $sql = "select 
                    F.id as glsubcode_id,
		    F.glsubcode as glsubcode,
                    F.header as subheader,
                    sum(A.credit) as credit,
                    sum(A.debit) as debit
                    from 
		    ourbank_Assets A,
		    ourbank_glcode B,
		    ourbank_transaction E,
		    ourbank_glsubcode F
		    where (
		    (F.id = '".$glsubcode."' '%') AND  
                    A.glsubcode_id_to = F.id AND 
		    B.id = F.glcode_id AND
		    B.ledgertype_id = 3 AND
		    A.transaction_id = E.transaction_id AND
                    E.transaction_date BETWEEN '$date1' AND '$date2') 
		    group by F.id";
         $result=$db->fetchAll($sql);
         return $result;

    }
    
    public function openingBalanceAssets($date,$glsubcode) 
    {
        $db = $this->getAdapter();
        $sql = "select 
                    F.id as glsubcode_id,
                    F.header as subheader,
		    F.glsubcode as glsubcode,
                    (sum(A.credit)-sum(A.debit)) as openingCash
                    from 
		    ourbank_Assets A,
		    ourbank_glcode B,
		    ourbank_transaction E,
		    ourbank_glsubcode F
		    where (
		    (F.id = '".$glsubcode."' '%') AND  
                    A.glsubcode_id_to = F.id AND
		    B.id = F.glcode_id AND
		    B.ledgertype_id = 3 AND
		    A.transaction_id = E.transaction_id AND
                    E.transaction_date < '$date') 
		    group by F.id";
        $result=$db->fetchAll($sql);
        return $result;

    }
}