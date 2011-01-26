<?php
class Management_Model_Product extends Zend_Db_Table {
	protected $_name = 'ourbank_productdetails';

	public function fetchAllProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productdetails'),array('product_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1')
			->join(array('c'=>'ourbank_categorydetails'),'p.category_id = c.category_id')
			->where('c.recordstatus_id = 3 or c.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchAllProductNames() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productdetails'),array('product_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1')
			->where('p.category_id=2');
			$result = $this->fetchAll($select);
			return $result->toArray();
	}

	public function viewProduct($product_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productdetails'),array('product_id'),array('a.recordstatus_id','a.productname',
											'a.productshortname','a.product_description'))
			->where('a.product_id = ?',$product_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_categorydetails'),'a.category_id = b.category_id',array('a.recordstatus_id','b.categoryname','b.category_id'))
			->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
//  		die($select->__toString($select));
	}

	public function addProduct($post,$product_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$data = array('productupdates_id'=> '',
					'product_id'=> $product_id,
					'productname'=>$post['productname'],
					'productshortname'=>$post['productshortname'],
					'category_id'=>$post['category_id'],
					'product_description'=>$post['product_description'],
					'recordstatus_id'=>'3',
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$createdby,
					'editeddate'=>date("Y-m-d"));
		$this->insert($data);
	}

	public function UpDateProduct($product_id) {
		$data = array('recordstatus_id'=> 2);
		$where = 'product_id = '.$product_id;
		$this->update($data,$where);
	}

	public function editProduct($post,$product_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$data = array('productupdates_id'=> '',
					'product_id'=>$product_id,
					'productname'=>$post['productname'],
					'productshortname'=>$post['productshortname'],
					'category_id'=>$post['category_id'],
					'product_description'=>$post['product_description'],
					'recordstatus_id'=>'3',
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"),
					'editedby'=>$createdby,
					'editeddate'=>date("Y-m-d"));
		$this->insert($data);
	}

	public function deleteProduct($product_id,$remarks) {
		$data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
		$where = 'product_id = '.$product_id;
		$this->update($data , $where );
	}

	public function SearchProduct($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_productdetails'),array('product_id'))
			->where('b.recordstatus_id = 3 OR b.recordstatus_id = 1')
			->join(array('a' => 'ourbank_categorydetails'),'b.category_id = a.category_id')
			->where('a.recordstatus_id = 3 OR a.recordstatus_id = 1')
			->where('a.category_id like "%" ? "%"',$post['field1'])
			->where('b.productname like "%" ? "%"',$post['field2'])
			->where('b.productshortname like "%" ? "%"',$post['field3'])
			->where('b.product_description like "%" ? "%"',$post['field4']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function productstatus($product_id) {
		$data = array('recordstatus_id'=> 1);
		$where = 'product_id = '.$product_id;
		$this->update($data,$where);
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

	public function productUpdate($updateOldProduct = array(),$updateNewProduct = array(),$createdby,$product_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOldProduct as $key=>$val) {
			if ($val != $updateNewProduct[$key]) {                           /** if the values are changed */
				$match[] = $key;
			}
		}
		if(count($match) <= 0){
		} else {
			foreach($match as $product) {
				$tableName ='ourbank_productdetails';
				$productUpdates = array('productupdates_id'=>'',
										'product_id' => $product_id,
										'table_name'=>$tableName,
										'fieldname'=>$product,
										'previous_data'=>$updateOldProduct[$product],
										'current_data'=>$updateNewProduct[$product],
										'modified_by'=>$createdby,
										'modified_date'=>date("Y-m-d"));
				$this->db->insert('ourbank_productupdates',$productUpdates);
			}
		}
	}

	public function addExtendedproduct($input) {
		$db = $this->getAdapter();
		$db->insert("ourbank_Product_extended",$input);
		return ;
	}

	public function fetchAllsavingloanProductDetails($savingsloanid) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productdetails'),array('product_id'))
			->where('p.category_id =?',$savingsloanid)
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1')
			->join(array('c'=>'ourbank_categorydetails'),'p.category_id = c.category_id')
			->where('c.recordstatus_id = 3 or c.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function insertproductId($input = array())
	{
        $this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert("ourbank_product",$input);
		$result = $this->db->lastInsertId('ourbank_product');
		return $result;
	}


}
