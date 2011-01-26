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
class Management_Model_Bank extends Zend_Db_Table {
	protected $_name = 'ourbank_bankaddress';

	public function fetchAllbankdetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_bankaddress'),array('bank_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getUpdatesinformation($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_bankupdates'),array('bankupdates_id'))
			->join(array('b' => 'ourbank_userloginupdates'),'a.modified_by =b.user_id')
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function SearchBank($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_bankaddress'),array('bank_id'))
			->where('b.recordstatus_id = 3 OR b.recordstatus_id = 1')
			->where('b.bankname like "%" ? "%"',$post['field2'])
			->where('b.bankshortname like "%" ? "%"',$post['field3'])
			->where('b.city like "%" ? "%"',$post['field4'])
			->where('b.state like "%" ? "%"',$post['field6']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewbank($bank_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_bankaddress'),array('bank_id'))
			->where('a.bank_id = ?',$bank_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
//  		die($select->__toString($select));
	}

        public function product_bank()
        {
                $select=$this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a'=>'ourbank_bankaddress'),array('bank_id'),array('a.bank_id','a.bankname'))
                       ->join(array('b'=>'ourbank_productbank'),'a.bank_id=b.bank_id')
                       ->join(array('c'=>'ourbank_productdetails'),'b.product_id=c.product_id')
                       ->where('a.recordstatus_id=3 or a.recordstatus_id=1')
                       ->where('c.product_id=?',$product_id);
             //   $result=$this->fetchAll($select);
               // return $result->toArray();
               die($select->__toString($select));
        }
/*	
select `a`.`bankname`, `a`.`bank_id` from  `ourbank_bankaddress` as `a` inner join `ourbank_productbank` as `b` on a.bank_id=b.bank_id inner join `ourbank_productdetails` as `c` on b.product_id=c.product_id where (a.recordstatus_id=3 or a.recordstatus_id=1) and c.product_id=14*/

	public function deletebank($bank_id,$remarks) {
		$data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
		$where = 'bank_id = '.$bank_id;
		$this->update($data , $where );
	}


	public function addbank($post,$bank_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$data = array('bankaddress_id'=> '',
					'bank_id'=> $bank_id,
					'recordstatus_id'=>3,
					'bankname'=>$post['bankname'],
					'bankshortname'=>$post['bankshortname'],
					'bankdescription'=>$post['bankdescription'],
					'address1'=>$post['address1'],
					'address2'=>$post['address2'],
					'address3'=>$post['address3'],
					'city'=>$post['city'],
					'state'=>$post['state'],
					'country'=>$post['country'],
					'pincode'=>$post['pincode'],
					'phone'=>$post['phone'],
					'fax'=>$post['fax'],
					'email_Id'=>$post['email_Id'],
					'contactperson'=>$post['contactperson'],
					'contactperson_phone1'=>$post['contactperson_phone1'],
					'contactperson_phone2'=>$post['contactperson_phone2'],
					'contactperson_email'=>$post['contactperson_email'],
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"));
		$this->insert($data);
	}



	public function bankUpdate($updateOldbank = array(),$updateNewbank = array(),$createdby,$bank_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOldbank as $key=>$val) {
			if ($val != $updateNewbank[$key]) {                           /** if the values are changed */
				$match[] = $key;
			}
		}
		if(count($match) <= 0){
		} else {
			foreach($match as $bank) {
				$tableName ='ourbank_bankaddress';
				$bankUpdates = array('bankupdates_id'=>'',
										'bank_id' => $bank_id,
										'table_name'=>$tableName,
										'fieldname'=>$bank,
										'previous_data'=>$updateOldbank[$bank],
										'current_data'=>$updateNewbank[$bank],
										'modified_by'=>$createdby,
										'modified_date'=>date("Y-m-d"));
				$this->db->insert('ourbank_bankupdates',$bankUpdates);
			}
		}
	}

	public function editbank($post,$bank_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$where = 'bank_id = '.$bank_id;
		$data = array('bankname'=>$post['bankname'],
					'bankshortname'=>$post['bankshortname'],
					'bankdescription'=>$post['bankdescription'],
					'address1'=>$post['address1'],
					'address2'=>$post['address2'],
					'address3'=>$post['address3'],
					'city'=>$post['city'],
					'state'=>$post['state'],
					'country'=>$post['country'],
					'pincode'=>$post['pincode'],
					'phone'=>$post['phone'],
					'fax'=>$post['fax'],
					'email_Id'=>$post['email_Id'],
					'contactperson'=>$post['contactperson'],
					'contactperson_phone1'=>$post['contactperson_phone1'],
					'contactperson_phone2'=>$post['contactperson_phone2'],
					'contactperson_email'=>$post['contactperson_email'],
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"));
		$this->update($data,$where );
	}

	public function insertbankId($input = array())
	{
        $this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert("ourbank_bank",$input);
		$result = $this->db->lastInsertId('ourbank_bank');
		return $result;
	}


	


// 	public function getUpdatesinformation($post = array()) {
// 		$select = $this->select()
// 			->setIntegrityCheck(false)  
// 			->join(array('a' => 'ourbank_productupdates'),array('productupdates_id'))
// 			->join(array('b' => 'ourbank_userloginupdates'),'a.modified_by =b.user_id')
// 			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
// 		$result = $this->fetchAll($select);
// 		return $result->toArray();
// 	}
// 

// 
// 	public function addExtendedproduct($input) {
// 		$db = $this->getAdapter();
// 		$db->insert("ourbank_Product_extended",$input);
// 		return ;
// 	}
}
