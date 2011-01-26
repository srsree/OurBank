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
class Management_Model_Creditline extends Zend_Db_Table {
	protected $_name = 'ourbank_creditlineinformation';

	public function fetchAllcreditlinedetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_creditlineinformation'),array('creditline_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1')
			->join(array('Q' => 'ourbank_institutionaddress'),'p.institution_id=Q.institution_id')
			->where('Q.recordstatus_id = 3 or p.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function getUpdatesinformation($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_creditlineupdates'),array('creditlineupdates_id'))
			->join(array('b' => 'ourbank_userloginupdates'),'a.modified_by =b.user_id')
			->where('b.recordstatus_id = 1 or b.recordstatus_id = 3');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchAllinstitutiondetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_institutionaddress'),array('institution_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function SearchCreditline($post = array()) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_creditlineinformation'),array('creditline_id'))
			->where('b.recordstatus_id = 3 OR b.recordstatus_id = 1')
			->join(array('c' => 'ourbank_institutionaddress'),'b.institution_id=c.institution_id')
			->where('c.recordstatus_id = 3 OR c.recordstatus_id = 1')
			->where('c.institution_id like "%" ? "%"',$post['field1'])
			->where('b.creditlinename like "%" ? "%"',$post['field2'])
			->where('b.creditline_beginingdate like "%" ? "%"',$post['field3'])
			->where('b.creditline_closingdate like "%" ? "%"',$post['field4']);
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function viewcreditline($creditline_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_creditlineinformation'),array('creditline_id'))
			->where('a.creditline_id = ?',$creditline_id)
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->join(array('b' => 'ourbank_institutionaddress'),'a.institution_id=b.institution_id')
			->where('b.recordstatus_id = 3 or b.recordstatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray();
//  		die($select->__toString($select));
	}

	public function deletecreditline($creditline_id,$remarks) {
		$data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
		$where = 'creditline_id = '.$creditline_id;
		$this->update($data , $where );
	}

	public function fetchinstitutionamount($institution_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT SUM(fundingamount * exchangerate) institutiontotalamount from ourbank_fundingdetails where institution_id=? AND (recordstatus_id=3 or recordstatus_id=1)";
		$result = $this->db->fetchAll($sql,array($institution_id));
		return $result;
	}

	public function fetchcreditlineamountamount($institution_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$sql = "SELECT SUM(creditlineamount) totalcreditlineamount from ourbank_creditlineinformation where institution_id=? AND (recordstatus_id=3 or recordstatus_id=1)";
		$result = $this->db->fetchAll($sql,array($institution_id));
		return $result;
	}


	public function addcreditline($post,$creditline_id,$institution_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$data = array('creditlineupdates_id'=> '',
					'creditline_id'=> $creditline_id,
					'creditlinename'=>$post['creditlinename'],
					'creditline_shortname'=>$post['creditline_shortname'],
					'institution_id'=>$institution_id,
					'creditlineinterest'=>$post['creditlineinterest'],
					'creditline_currency_id'=>'',
					'creditlineamount'=>$post['creditlineamount'],
					'balance_creditlineamount'=>$post['creditlineamount'],
					'exchangerate'=>'',
					'recordstatus_id'=>3,
					'creditline_beginingdate'=>$post['creditline_beginingdate'],
					'creditline_closingdate'=>$post['creditline_closingdate'],
					'createdby'=>$createdby,
					'remarks'=>'',
					'createddate'=>date("Y-m-d"));
		$this->insert($data);
	}

	public function insertcreditlineId($input = array())
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$this->db->insert('ourbank_creditline',$input);
		$result = $this->db->lastInsertId('ourbank_creditline');
		return $result;
	}

	public function creditlineUpdate($updateOldcreditline = array(),$updateNewcreditline = array(),$createdby,$creditline_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOldcreditline as $key=>$val) {
			if ($val != $updateNewcreditline[$key]) {                           /** if the values are changed */
				$match[] = $key;
			}
		}
		if(count($match) <= 0){
		} else {
			foreach($match as $creditline) {
				$tableName ='ourbank_creditlineinformation';
				$creditlineUpdates = array('creditlineupdates_id'=>'',
										'creditline_id' => $creditline_id,
										'table_name'=>$tableName,
										'fieldname'=>$creditline,
										'previous_data'=>$updateOldcreditline[$creditline],
										'current_data'=>$updateNewcreditline[$creditline],
										'modified_by'=>$createdby,
										'modified_date'=>date("Y-m-d"));
				$this->db->insert('ourbank_creditlineupdates',$creditlineUpdates);
			}
		}
	}

	public function editcreditline($post,$creditline_id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$createdby = $sessionName->primaryuserid;
		$where = 'creditline_id = '.$creditline_id;
		$data = array('creditlinename'=>$post['creditlinename'],
					'creditline_shortname'=>$post['creditline_shortname'],
					'creditlineamount'=>$post['creditlineamount'],
					'creditlineinterest'=>$post['creditlineinterest'],
					'creditline_beginingdate'=>$post['creditline_beginingdate'],
					'creditline_closingdate'=>$post['creditline_closingdate'],
					'createdby'=>$createdby,
					'createddate'=>date("Y-m-d"));
		$this->update($data,$where );
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
