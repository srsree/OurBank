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
class Management_Model_Loan extends Zend_Db_Table {
     protected $_name = 'ourbank_productsofferdetails';

    public function fetchAllProductdetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id','c.productname')
//                        ->where('c.category_id = 1')
                       ->where('c.recordstatus_id = 3 OR c.recordstatus_id = 1');
       $result = $this->fetchAll($select);
       return $result->toArray();
       // die($select->__toString($select));
    }

    public function fetchAllProduct_id($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
						->where('a.offerproductupdate_id = ?',$offerproductupdate_id);
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

	public function getUpdatesinformation($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productupdates'),array('productupdates_id'))
			->join(array('b' => 'ourbank_userloginupdates'),'a.modified_by =b.user_id')
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function ProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('b' => 'ourbank_productdetails'),array('product_id'))
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
			//->where('b.category_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
                //die($select->__toString($select));
	}

	public function getMembertypeDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('b' => 'ourbank_membertypes'),array('membertype_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function SearchofferProduct($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
                        ->join(array('c'=>'ourbank_productdetails'),'b.product_id = c.product_id','c.productname')
			->where('b.recordstatus_id = 3 OR b.recordstatus_id = 1')
			->where('c.product_id like "%" ? "%"',$post['field1'])
			->where('b.offerproductname like "%" ? "%"',$post['field2'])
			->where('b.begindate like "%" ? "%"',$post['field4'])
			->where('b.closedate like "%" ? "%"',$post['field6']);
		$result = $this->fetchAll($select);
		return $result->toArray(); 
               //die($select->__toString($select));
	}

	public function addofferproduct($post,$offerproduct_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$data = array('offerproductupdate_id'=> '',
					'offerproduct_id'=> $offerproduct_id,
					'offerproductname'=>$post['offerproductname'],
					'offerproductshortname'=>$post['offerproductshortname'],
					'product_id'=>$post['product_id'],
					'offerproduct_description'=>$post['offerproduct_description'],
					'begindate'=>$post['begindate'],
					'closedate'=>$post['closedate'],
					'applicableto'=>$post['applicableto'],
					'offerproduct_description'=>$post['offerproduct_description'],
					'recordstatus_id'=>'3',
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$createdby,
					'editeddate'=>date("Y-m-d"));
		$this->insert($data);
	}

	public function offerproductupdateid() {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$result = $this->db->lastInsertId('ourbank_productsofferdetails');
		return $result;
	}

	public function addproductsloan($post,$offerproductupdate_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('offerproductupdate_id'=> $offerproductupdate_id,
					'minmumloanamount'=>$post['minmumloanamount'],
					'maximunloanamount'=>$post['maximunloanamount'],
					'penal_Interest'=>$post['penal_Interest'],
					'minimumfrequency'=>$post['minimumfrequency'],
					'maximumfrequency'=>$post['maximumfrequency'],
					'graceperiodnumber'=>$post['graceperiodnumber']);
		$this->db->insert('ourbank_productsloan',$data);
	}

    public function viewLoan($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
						->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                       ->where('c.recordstatus_id = 3 OR c.recordstatus_id = 1')
                       ->join(array('d'=>'ourbank_membertypes'),'a.applicableto = d.membertype_id');
       $result = $this->fetchAll($select);
       return $result->toArray();
//  		die($select->__toString($select));
    }

    public function viewinterests($offerproduct_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_interest_periods'),array('period_id'))
                       ->where('a.intereststatus_id = 3 OR a.intereststatus_id = 1')
						->where('a.offerproduct_id = ?',$offerproduct_id);
       $result = $this->fetchAll($select);
       return $result->toArray();
//  		die($select->__toString($select));
    }

	public function deleteofferProduct($offerproductupdate_id,$remarks) {
		$data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
		$where = 'offerproductupdate_id = '.$offerproductupdate_id;
		$this->update($data , $where );
	}

	public function viewProduct($product_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productdetails'),array('product_id'))
			->where('a.product_id = ?',$product_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewapplicableto($applicableto) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('membertype_id'))
			->where('a.membertype_id = ?',$applicableto);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function offerproductUpdate($updateOldofferProduct = array(),$updateNewofferProduct = array(),$createdby,$offerproduct_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOldofferProduct as $key=>$val) {
			if ($val != $updateNewofferProduct[$key]) {                           /** if the values are changed */
				$match[] = $key;
			}
		}
		if(count($match) <= 0){
		} else {
			foreach($match as $offerproduct) {
				$tableName ='ourbank_productsofferdetails';
				$offerproductUpdates = array('offerproductupdates_id'=>'',
										'offerproduct_id' => $offerproduct_id,
										'table_name'=>$tableName,
										'fieldname'=>$offerproduct,
										'previous_data'=>$updateOldofferProduct[$offerproduct],
										'current_data'=>$updateNewofferProduct[$offerproduct],
										'modified_by'=>$createdby,
										'modified_date'=>date("Y-m-d"));
				$this->db->insert('ourbank_offerproductupdates',$offerproductUpdates);
			}
			$where[] = "offerproduct_id = $offerproduct_id";
			$input1=  array('intereststatus_id' => '2');
			$result = $this->db->update('ourbank_interest_periods',$input1,$where);
		}
	}

	public function editofferProduct($post,$offerproductupdate_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$where = 'offerproductupdate_id = '.$offerproductupdate_id;
		$data = array('offerproductname'=>$post['offerproductname'],
					'offerproductshortname'=>$post['offerproductshortname'],
					'product_id'=>$post['product_id'],
					'offerproduct_description'=>$post['offerproduct_description'],
					'begindate'=>$post['begindate'],
					'closedate'=>$post['closedate'],
					'applicableto'=>$post['applicableto'],
					'offerproduct_description'=>$post['offerproduct_description'],
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$createdby,
					'editeddate'=>date("Y-m-d"));
		$this->update($data,$where );
	}

	public function editProductloan($post,$offerproductupdate_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$where = 'offerproductupdate_id = '.$offerproductupdate_id;
		$data = array('minmumloanamount'=>$post['minmumloanamount'],
					'maximunloanamount'=>$post['maximunloanamount'],
					'penal_Interest'=>$post['penal_Interest'],
					'minimumfrequency'=>$post['minimumfrequency'],
					'maximumfrequency'=>$post['maximumfrequency'],
					'graceperiodnumber'=>$post['graceperiodnumber']);
		$this->db->update('ourbank_productsloan',$data,$where );
	}

	public function insertofferproductId($input = array())
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert('ourbank_productsoffering',$input);
		$result = $this->db->lastInsertId('ourbank_productsoffering');
		return $result;
	}

}
