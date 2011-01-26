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

class Ledger_Model_Ledger extends Zend_Db_Table
{
    protected $_name = 'ourbank_glcode';


    public function insertGlcode($input)
    {
        $this->db = $this->getAdapter();
        $this->db->insert('ourbank_glcode',$input);
        return '1';
    } 

    public function insertGlsubcode($input)
    {
        $this->db = $this->getAdapter();
        $this->db->insert('ourbank_glsubcode',$input);
        return '1';
    }

    public function fetchAllLedger()
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select B.id as id,C.id as lid,B.glcode as glcode,B.header as header from 
                ourbank_glcode B,
                ourbank_ledgertypes C
                where (B.ledgertype_id = C.id)';
        $result = $this->db->fetchALL($sql,array());
        return $result;
    }

    public function fetchAllLedger1()
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select * from ourbank_glcode';
        $result = $this->db->fetchALL($sql,array());
        return $result;
    }

    public function fetchAllSubLedger()
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select * from ourbank_glsubcode';
        $result = $this->db->fetchALL($sql,array());
        return $result;
    }

    public function ledgerSearch($glcode,$accountHeader)
    {
        $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->join(array('a' => 'ourbank_glcode'),array('id'))
                    ->where('a.glcode like "%" ? "%"',$glcode)
                    ->where('a.header like "%" ? "%"',$accountHeader);
        $result = $this->fetchAll($select);
        return $result;
    }

    public function subledgerSearch($glsubcode,$subheader)
    {
        $select = $this->select()
                    ->setIntegrityCheck(false)
                    ->join(array('a' => 'ourbank_glsubcode'),array('id'))
                    ->where('a.glsubcode like "%" ? "%"',$glsubcode)
                    ->where('a.header like "%" ? "%"',$subheader);
        $result = $this->fetchAll($select);
        return $result;
    }

    public function getLdegertype($ledgertype_id)
    {
        $this->db = $this->getAdapter();
        $sql = 'select * from ourbank_ledgertypes where id = '.$ledgertype_id;
        $result = $this->db->fetchALL($sql);
        return $result;
    }

    public function getproducts()
    {
        $this->db = $this->getAdapter();
        $sql = 'select * from ourbank_category';
        $result = $this->db->fetchALL($sql);
        return $result;
    }

    public function getLedgerTypes()
    {
        $this->db = $this->getAdapter();
        $sql = 'select * from ourbank_ledgertypes';
        $result = $this->db->fetchALL($sql);
        return $result;
    }

    public function subLedger($glocde_id)
    {
        $this->db = $this->getAdapter();
        $sql =      "SELECT *  FROM  ourbank_glsubcode  WHERE (id ='$glocde_id')";
        $result = $this->db->fetchALL($sql);
        return $result;
    }

    public function offerproductName($product_id)
    {
        $this->db = $this->getAdapter();
        $sql = 'select * from ourbank_productsoffer where  (id = "'.$product_id.'")';
        $result = $this->db->fetchALL($sql);
        return $result;
    }

    public function viewProduct($product_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select productname from ourbank_product where (id = ?)';
        $result = $this->db->fetchALL($sql,array($product_id));
        return $result;
    }

    public function viewSubFee($fee_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT fee_id, feename FROM ourbank_feedetails where (recordstatus_id = 3 && fee_id=?)';
        $result = $this->db->fetchALL($sql,array($fee_id));
        return $result;
    }

    public function viewSubFunds($funder_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select fundtype_id from ourbank_fundingdetails where (recordstatus_id = 3 && fundtype_id =?)';
        $result = $this->db->fetchALL($sql,array($funder_id));
        return $result;
    }

    public function viewOfferProduct($offerproduct_id)
    {
        $this->db = $this->getAdapter();

        $sql = 'select offerproductname from ourbank_productsofferdetails where (recordstatus_id = 3 && offerproduct_id = ?)';
        $result = $this->db->fetchALL($sql,array($offerproduct_id));
        return $result;
    }

    public function viewFunds($funder_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'select fundername from ourbank_funderdetails where (recordstatus_id = 3 && funder_id = ?)';
        $result = $this->db->fetchALL($sql,array($funder_id));
        return $result;
    }

    public function viewLedger($ledgerID)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM
                ourbank_glcode A,
                ourbank_user B
                where (A.id= ? && A.created_by = B.id)';
        $result = $this->db->fetchAll($sql,array($ledgerID));
        return $result;
    }

    public function viewSubLedger($subledgerid)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM  
                ourbank_glcode A,
                ourbank_user B,
                ourbank_glsubcode C
                    where (C.id=? && 
                C.created_by = B.id &&
                C.glcode_id = A.id)';
        $result = $this->db->fetchAll($sql,array($subledgerid));
        return $result;
    }
    public function genarateGlCode($ledgertype_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchRow("SELECT MAX(id) as id 
                                        FROM  ourbank_glcode 
                                        where (ledgertype_id = '$ledgertype_id')");

        return $result;
    }

    public function fetchGlcode($id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->db->fetchRow("SELECT glcode 
                                        FROM  ourbank_glcode 
                                        where (id = '$id')");
        return $result;
    }

    public function fetchGlcodeforledgerid($ledgertype_id) 
    {
        $db = $this->getAdapter();
        $sql = 'select *
                from ourbank_glcode 
                where ledgertype_id = '.$ledgertype_id;
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function genarateGlsubCode1($glcode_id,$ledgertype_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        return $this->db->fetchRow("SELECT MAX(glsubcode) as id 
                                        FROM  ourbank_glsubcode 
                                        where glcode_id = $glcode_id and subledger_id = ".$ledgertype_id);
    }

    public function genarateGlSubCode($glcode_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        return $this->db->fetchRow("SELECT MAX(B.glsubcode) as glsubcode FROM  
                                    ourbank_glsubcodeupdates A,
                                    ourbank_glsubcode B where 
                                    (A.glcode_id = '$glcode_id' AND
                                    A.glsubcodeupdate_id = B.glsubcode_id)");
    }

    public function existingRecord($productname)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT ledgertype_id FROM ourbank_glcodeupdates where ledgertype_id = ? ";
        $result = $this->db->fetchAll($sql,array($productname));
        return $result;
    }

    public function existingSubRecord($productname)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT * FROM ourbank_glsubcode where subledger_id = ?";
        $result = $this->db->fetchAll($sql,array($productname));
        return $result;
    }

    public function gl($glcode_id)
    {
        $this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM  ourbank_glcode  where glcode_id=?';
        $result = $this->db->fetchAll($sql,array($glcode_id));
        return $result;
    }
}
