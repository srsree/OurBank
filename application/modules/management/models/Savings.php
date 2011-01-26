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
class Management_Model_Savings extends Zend_Db_Table {
	protected $_name = 'ourbank_productsofferdetails';

	public function fetchAllofferProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1')
			->join(array('A' => 'ourbank_productdetails'),'A.product_id = p.product_id')
			->where('A.recordstatus_id = 3 or A.recordstatus_id = 1')
			->join(array('B' => 'ourbank_categorydetails'),'A.category_id=B.category_id')
			->where('B.category_id = 1')
			->where('B.recordstatus_id = 3 or B.recordstatus_id = 1')
			->join(array('c'=>'ourbank_membertypes'),'p.applicableto = c.membertype_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
//   		die($select->__toString($select));
	}

	public function SearchofferProduct($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
			->where('b.recordstatus_id = 3 OR b.recordstatus_id = 1')
			->join(array('a' => 'ourbank_membertypes'),'b.applicableto = a.membertype_id')
			->where('b.offerproductname like "%" ? "%"',$post['field6'])
			->where('b.offerproductshortname like "%" ? "%"',$post['field2'])
			->where('b.begindate like "%" ? "%"',$post['field3'])
			->where('b.closedate like "%" ? "%"',$post['field4']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function offerProductshortname($offerproduct_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsofferdetails'),array('offerproduct_id'),array('a.recordstatus_id'))
			->where('a.offerproduct_id = ?',$offerproduct_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_productdetails'),'a.product_id = b.product_id',array('b.productshortname'))
			->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewofferProduct($offerproduct_id,$offerproductshortname) {
		if($offerproductshortname == 'ps') {
			$tablename="ourbank_productssaving";
			$fielid1 = "frequencyofdeposit";
		} else {
			$tablename="ourbank_product_fixedrecurring";
			$fielid1 = "frequency_of_deposit";
		}
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
			->where('a.offerproduct_id = ?',$offerproduct_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('b' => $tablename),'a.offerproductupdate_id = b.offerproductupdate_id')
			->join(array('c' => 'ourbank_productdetails'),'a.product_id = c.product_id')
			->where('c.recordstatus_id = 3 or c.recordstatus_id = 1')
			->join(array('d' => 'ourbank_membertypes'),'a.applicableto = d.membertype_id')
			->join(array('e' => 'ourbank_frequencyofpayment'),'b.'.$fielid1.'= e.timefrequncy_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewinterest($offerproduct_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsofferdetails'),array('offerproduct_id'))
			->where('a.offerproduct_id = ?',$offerproduct_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('c' => 'ourbank_interest_periods'),'a.offerproduct_id = c.offerproduct_id')
			->where('c.intereststatus_id = 3 or c.intereststatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
//   		die($select->__toString($select));
	}

	public function deleteofferproduct($offerproduct_id,$remarks) {
		$data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
		$where = 'offerproduct_id = '.$offerproduct_id;
		$this->update($data , $where );
	}

	public function getProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productdetails'),array('product_id'))
			->where('(a.recordstatus_id = 3 or a.recordstatus_id = 1) && category_id=1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getMemberType() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('membertype_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getfrequencyofdeposit() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_frequencyofpayment'),array('timefrequncy_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getfrequencyofdepo($frequencyofdeposit2) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_frequencyofpayment'),array('timefrequncy_id'))
			->where('a.timefrequncy_id = ?',$frequencyofdeposit2);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getproduct_id($offerproduct_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsofferdetails'),array('offerproduct_id'),array('a.offerproductupdate_id'))
			->where('a.offerproduct_id = ?',$offerproduct_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_productdetails'),'a.product_id=b.product_id',array('b.product_id'))
			->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
//   		die($select->__toString($select));
	}

	public function UpDateofferproductdetails($offerproduct_id) {
		$data = array('recordstatus_id'=> 2);
		$where = 'offerproduct_id = '.$offerproduct_id;
		$this->update($data,$where);
	}



	public function editsavings($post,$offerproduct_id,$closeddate) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		if($closeddate == "") {
			$CLOSEDDATE="0000-00-00";
		} else {
			$CLOSEDDATE=$closeddate;
		}
		$where = 'offerproduct_id = '.$offerproduct_id;
		$data = array('offerproductname'=>$post['offerproductname'],
					'offerproductshortname'=>$post['offerproductshortname'],
					'offerproduct_description'=>$post['offerproduct_description'],
					'begindate'=>$post['begindate'],
					'closedate'=>$CLOSEDDATE,
					'applicableto'=>$post['applicableto'],
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$createdby,
					'editeddate'=>date("Y-m-d"));
		$this->update($data,$where );
	}

	public function fetchAllProductName() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productdetails'),array('product_id'))
			->where('a.category_id = 1')
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchAllTimeFrequencyType() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_frequencyofpayment'),array('timefrequncy_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
//   		die($select->__toString($select));
	}

	public function fetchAllMemberType() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('membertype_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getapplicableto($applicableto2) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('membertype_id'))
			->where('a.membertype_id = ?',$applicableto2);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function product_id($productType) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productdetails'),array('product_id'))
			->where('a.productshortname = ?',$productType);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function addofferproduct($post,$offerproduct_id,$product_id,$closeddate) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$user_id = $sessionName->primaryuserid;
		if($closeddate == "") {
			$CLOSEDDATE="0000-00-00";
		} else {
			$CLOSEDDATE=$closeddate;
		}
		$data = array('offerproductupdate_id'=> '',
					'offerproduct_id'=> $offerproduct_id,
					'offerproductname'=>$post['offerproductname'],
					'offerproductshortname'=>$post['offerproductshortname'],
					'product_id'=>$product_id,
					'offerproduct_description'=>$post['offerproduct_description'],
					'begindate'=>$post['begindate'],
					'closedate'=>$CLOSEDDATE,
					'applicableto'=>$post['applicableto'],
					'capital_glsubcode_id'=>'',
					'Interest_glsubcode_id'=>'',
					'fee_glsubcode_id'=>'',
					'recordstatus_id'=>'3',
					'createdby'=>$user_id,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$user_id,
					'editeddate'=>date("Y-m-d"),
					'remarks'=>'');
		$this->insert($data);
	}

	public function addofferproductsavings($post,$offerproductupdate_id) {

		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('offerproductupdate_id'=> $offerproductupdate_id,
					'savingsindividualgroup'=> '',
					'frequencyofdeposit'=>$post['frequencyofdeposit'],
					'depo_timefrequency_id'=>'',
					'minmumdeposit'=>$post['minmumdeposit'],
					'maximumwithdrawal'=>'',
					'rateofinterest'=>'',
					'minimumbalanceforinterest'=>$post['minimumbalanceforinterest'],
					'minimumperiodforinterest'=>'',
					'frequencyofinterestupdating'=>$post['frequencyofinterestupdating'],
					'Int_timefrequency_id'=>$post['Int_timefrequency_id'],
					'amountusedforcalculateinterest'=>'');
		return $this->db->insert('ourbank_productssaving',$data);
	}

	public function addofferproductfixedrecurring($post,$offerproductupdate_id) {

		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('offerproductupdate_id'=> $offerproductupdate_id,
					'minimum_deposit_amount'=> $post['minimum_deposit_amount'],
					'maximum_deposit_amount'=>$post['maximum_deposit_amount'],
					'minimum_periodof_deposit'=>'',
					'maximum_periodof_deposit'=>'',
					'frequency_of_deposit'=>$post['frequency_of_deposit'],
					'penal_Interest'=>$post['penal_Interest'],
					'other_charges'=>'',
					'productstatus_id'=>'3');
		return $this->db->insert('ourbank_product_fixedrecurring',$data);
	}

	public function savingsUpdate($updateOlddata = array(),$updateNewdata = array(),$createdby,$offerproduct_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOlddata as $key=>$val) {
			if ($val != $updateNewdata[$key]) {
				$match[] = $key; /**field name which are modified */
			}
		}
		if(count($match) <= 0){	
			/**if no changes done in data nothing is modified */
		} else {
			/**to find table name of modified field */
			foreach($match as $savingNames1) {
				$tableName='ourbank_productsofferdetails';
				$offerdetailsUpdateing = array('productupdates_id'=>'',
									'offerproduct_id' => $offerproduct_id,
									'table_name'=>$tableName,
									'fieldname'=>$savingNames1,
									'previous_data'=>$updateOlddata[$savingNames1],
									'current_data'=>$updateNewdata[$savingNames1],
									'modified_by'=>$createdby,
									'modified_date'=>date("Y-m-d")
								);
                /**inerting a information about modified fields */
				$this->db->insert('ourbank_savingsupdates',$offerdetailsUpdateing);
			}
		}
	}

	public function getUpdatesinformation($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_savingsupdates'),array('productupdates_id'))
			->join(array('b' => 'ourbank_userloginupdates'),'a.modified_by =b.user_id')
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function insertofferproductId($input = array())
	{
        $this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert("ourbank_productsoffering",$input);
		$result = $this->db->lastInsertId('ourbank_productsoffering');
		return $result;
	}

}
