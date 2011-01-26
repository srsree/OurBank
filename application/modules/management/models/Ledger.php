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

class Management_Model_Ledger extends Zend_Db_Table
{
    protected $_name = 'ourbank_usernamesupdates';
    protected $_primary = 'user_id';

	

    public function insertRow($input = array())
    {
	$this->db = $this->getAdapter();
        $this->db->insert('ourbank_glcode',$input);
	$result = $this->db->lastInsertId('ourbank_glcode');
	return $result;
    }

    public function insertSubCodeRow($input = array())
    {
       	$this->db = $this->getAdapter();
        $this->db->insert('ourbank_glsubcode',$input);
	$result = $this->db->lastInsertId('ourbank_glsubcode');
	return $result;
    }

    public function updateSubCodeRow($gsubAuto,$input = array()) 
    {
	$this->db = $this->getAdapter();
        $where[] = "glsubcode_id  = '".$gsubAuto."'";
        $result = $this->db->update('ourbank_glsubcode',$input,$where);
    }

    public function updateRow($gAuto,$input = array()) 
    {
	$this->db = $this->getAdapter();
            $where[] = "glcode_id = '".$gAuto."'";
            $result = $this->db->update('ourbank_glcode',$input,$where);
    }

    public function insertGlcode($input = array())
    {
	$this->db = $this->getAdapter();
        $this->db->insert('ourbank_glcodeupdates',$input);
	return '1';
    } 

    public function insertGlsubcode($input = array())
    {
	$this->db = $this->getAdapter();
        $this->db->insert('ourbank_glsubcodeupdates',$input);
	return '1';
    } 
	
    public function fetchAllLedger()
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'select * from 
		ourbank_glcodeupdates A,
		ourbank_glcode B,
                ourbank_ledgertypes C
 		where (A.recordstatus_id = 3 && A.glcode_id = B.glcode_id
                && A.ledgertype_id = C.ledgertype_id)
                ';
	$result = $this->db->fetchALL($sql,array());
	return $result;
    }
	
    public function getLdegertype($ledgertype_id)
    {
	$this->db = $this->getAdapter();
	$sql = 'select * from ourbank_ledgertypes where (ledgertype_id = "'.$ledgertype_id.'")';
	$result = $this->db->fetchALL($sql);
	return $result;
    }

    public function getproducts()
    {
	$this->db = $this->getAdapter();

	$sql = 'select * from ourbank_categorydetails where (recordstatus_id = 3 || recordstatus_id = 1)';

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

	$sql =      "SELECT *  FROM
                   ourbank_glsubcodeupdates A,
		   ourbank_glsubcode B
                   WHERE (A.glcode_id ='$glocde_id' &&
		   A.glsubcode_id = B.glsubcode_id &&
		   A.recordstatus_id = 3
		   )";

	$result = $this->db->fetchALL($sql);

	return $result;
    }

    public function offerproductName($product_id)
    {
	$this->db = $this->getAdapter();

	$sql = 'select * from ourbank_productsofferdetails where (recordstatus_id = 3 || recordstatus_id = 1) && (product_id = "'.$product_id.'")';

	$result = $this->db->fetchALL($sql);

 	return $result;
    }
    public function viewProduct($product_id)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'select productname from ourbank_productdetails where (recordstatus_id = 3 && product_id = ?)';
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

    public function viewLedger($glcodeUpdateId)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'SELECT * FROM  
		ourbank_glcodeupdates A,
		ourbank_userloginupdates B,
		ourbank_glcode C
 		where (A.glcodeupdate_id=? && 
		A.createdby = B.user_id &&
		A.glcode_id = C.glcode_id)';
	$result = $this->db->fetchAll($sql,array($glcodeUpdateId));
        return $result;
    }

    public function viewSubLedger($glsubcodeupdate_id)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'SELECT * FROM  
		ourbank_glcodeupdates A,
		ourbank_userloginupdates B,
		ourbank_glcode C,
		ourbank_glsubcode D,
		ourbank_glsubcodeupdates E
 		where (E.glsubcodeupdate_id=? && 
		E.createdby = B.user_id &&
		E.glcode_id = C.glcode_id &&
		E.glsubcode_id = D.glsubcode_id )';
	$result = $this->db->fetchAll($sql,array($glsubcodeupdate_id));
        return $result;
    }
    public function genarateGlCode($ledgertype_id)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	return $this->db->fetchRow("SELECT MAX(B.glcode) FROM  
                                    ourbank_glcodeupdates A,
                                    ourbank_glcode B where 
                                    (A.ledgertype_id = '$ledgertype_id' AND
                                    A.glcode_id = B.glcode_id)");
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
	$sql = "SELECT subledger_id FROM ourbank_glsubcodeupdates where subledger_id = ?";
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

    public function g($glcodeupdate_id)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'SELECT * FROM  ourbank_glcodeupdates where glcodeupdate_id=?';
	$result = $this->db->fetchAll($sql,array($glcodeupdate_id));
        return $result;
    }

    public function fetchAllSubLedger()
    {	
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'select * from
		ourbank_glsubcodeupdates A,
		ourbank_glsubcode B 
		where (A.recordstatus_id = 3 && A.glsubcode_id = B.glsubcode_id)';
	$result = $this->db->fetchALL($sql,array());
	return $result;
    }

    public function ledgerUpdate($id,$input = array())
    {
	$this->db = $this->getAdapter();
        $where[] = "glcodeupdate_id = '".$id."'";
	$result = $this->db->update('ourbank_glcodeupdates',$input,$where);
    }

    public function ledgerSubcodeUpdate($id,$input = array())
    {
	$this->db = $this->getAdapter();
        $where[] = "glsubcodeupdate_id = '".$id."'";
	$result = $this->db->update('ourbank_glsubcodeupdates',$input,$where);
    }

    public function subUpdate($id,$input = array())
    {
	$this->db = $this->getAdapter();
        $where[] = "glcode_id = '".$id."'";
	$result = $this->db->update('ourbank_glsubcodeupdates',$input,$where);
    }

    public function ledgerSearch($input = array())
    {
	$this->db = $this->getAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = "SELECT * FROM 
		ourbank_glcode A,
		ourbank_glcodeupdates B,
		ourbank_glsubcode C,
		ourbank_glsubcodeupdates D
                WHERE 
                (A.glcode LIKE ? '%') AND 
		(C.glsubcode LIKE ? '%') AND
		(B.accountheader LIKE ? '%') AND
               	(D.subheader LIKE ? '%') AND
		(A.glcode_id = B.glcode_id) AND
		(B.glcode_id = D.glcode_id) AND
		(C.glsubcode_id = D.glsubcode_id) AND
		(B.recordstatus_id = 3) AND
		(D.recordstatus_id = 3) AND
                (C.glsubcode_id = D.glsubcode_id)";
                $result=$this->db->fetchAll($sql,array($input['glcode'],$input['glsubcode'],
					$input['accountheader'],$input['subheader']));
	return $result;
    }


    public function editLedger($glcodeUpdateId)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'SELECT * FROM  
		ourbank_glcodeupdates A,
		ourbank_glcode B
 		where (A.glcodeupdate_id=? &&
		A.glcode_id = B.glcode_id &&
		A.recordstatus_id = 3)';
	$result = $this->db->fetchAll($sql,array($glcodeUpdateId));
        return $result;
    }

    public function editSubLedger($glsubcodeupdate_id)
    {
	$this->db = $this->getAdapter();
	$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
	$sql = 'SELECT * FROM  
		ourbank_glcodeupdates A,
		ourbank_glcode B,
		ourbank_glsubcode C,
		ourbank_glsubcodeupdates D
 		where (D.glsubcodeupdate_id=? &&
		D.glcode_id = B.glcode_id &&
		D.glsubcode_id = C.glsubcode_id &&
		D.recordstatus_id = 3)';
	$result = $this->db->fetchAll($sql,array($glsubcodeupdate_id));
        return $result;
    }


    public function insertUpdates($previous = array(),$current = array(),$glcode_id)
    {
	$this->db = $this->getAdapter();
       	$result=array_keys (array_diff($previous,$current));
        foreach($result as $ledger) {
            $table_name='ourbank_glcodeupdates';
            $glcodeupdates = array('ledgerupdates_id'=>'',
            				'glcode_id'=>$glcode_id,
            				'fieldname'=>$ledger,
            				'table_name'=>$table_name,
           				'previous_data'=>$previous[$ledger],
            				'current_data'=>$current[$ledger],
            				'modified_date'=>date("Y-m-d"));
            $this->db->insert('ourbank_glupdates',$glcodeupdates);
	}
	return;
    }

    public function insertSubcodeUpdates($previous = array(),$current = array(),$glsubcode_id)
    {
	$this->db = $this->getAdapter();
       	$result=array_keys (array_diff($previous,$current));
        foreach($result as $ledger) {
            $table_name='ourbank_glsubcodeupdates';
            $glcodeupdates = array('subledgerupdates_id'=>'',
            				'glsubcode_id'=>$glsubcode_id,
            				'fieldname'=>$ledger,
            				'table_name'=>$table_name,
           				'previous_data'=>$previous[$ledger],
            				'current_data'=>$current[$ledger],
            				'modified_date'=>date("Y-m-d"));
            $this->db->insert('ourbank_glsubupdates',$glcodeupdates);
	}
	return;
    }
}
