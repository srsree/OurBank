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
class Models_Fine extends Zend_Db_Table
{
//protected $_name = 'ourbank_usernamesupdates';
protected $_primary = 'user_id';
protected $db;
public function __construct() 
{
$this->db = Zend_Registry::get('db');
} 
public function insert_row($input = array())
{
$this->db->insert('ourbank_fines',$input);
$result = $this->db->lastInsertId('ourbank_fines');
return $result;
} 
public function insert_row1($input = array())
{
$this->db->insert('ourbank_finedetails',$input);
return '1';
}
	
public function insertFeeAppliesTo($input = array())
{
$this->db->insert('ourbank_fineaplliead',$input);
return '1';
}
public function fetchAllFineDetails()
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'select * from  
ourbank_fines A,
ourbank_finedetails B
where
A.fine_id=B.fine_id AND
B.recordstatus_id=3';
$result = $this->db->fetchALL($sql);
return $result;
}

	
public function fetchAll_finefrequencytype()
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'select * from  ourbank_finefrequency';
$result = $this->db->fetchAll($sql,array());
return $result;
}
public function fetchAll_membertype()
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'select * from  ourbank_fine_appliesto';
$result = $this->db->fetchAll($sql,array());
return $result;
}
public function fetchAll_glsubcode()
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'select * from  ourbank_glsubcode a,ourbank_glsubcodeupdates b 
where a.glsubcode_id=b.glsubcode_id
AND b.recordstatus_id=3 ORDER BY a.glsubcode_id';
$result = $this->db->fetchAll($sql,array());
return $result;
}
public function glsubcode($glsubcode_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'select * from  ourbank_glsubcode a,ourbank_glsubcodeupdates b 
where a.glsubcode_id=b.glsubcode_id
AND b.recordstatus_id=3
AND  a.glsubcode_id =? ORDER BY a.glsubcode_id';
$result = $this->db->fetchAll($sql,array($glsubcode_id));
return $result;
}
public function finefrequencytype($finefrequency_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'SELECT * FROM    ourbank_finefrequency   where finefrequency_id =?';
$result = $this->db->fetchAll($sql,array($finefrequency_id));
return $result;
}
public function membertype($membertype_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'SELECT * FROM    ourbank_membertypes  where membertype_id=?';
$result = $this->db->fetchAll($sql,array($membertype_id));
return $result;
}


public function FeeView($fine_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'SELECT * FROM  
ourbank_finedetails
where 
fine_id =? AND
recordstatus_id = 3';
$result = $this->db->fetchAll($sql,array($fine_id));
return $result;
}


public function appleisTo($fine_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'SELECT * FROM  

ourbank_fineapllied B,
ourbank_fine_appliesto C
where 
B.fine_id =? AND

B.recordstatus_id = 3 AND
B.fineappliesto_id = C.fine_appliesto_id';
$result = $this->db->fetchAll($sql,array($fine_id));
return $result;
}

public function appleisToEdit($fine_id){

$this->db->setFetchMode(Zend_Db::FETCH_OBJ);

$sql = 'SELECT fine_appliesto_description,fine_appliesto_id from 
ourbank_fine_appliesto
WHERE 
fine_appliesto_id not in (select b.fineappliesto_id from  ourbank_fine_appliesto  a, ourbank_fineapllied  b where b.fine_id= ?)';



$result = $this->db->fetchAll($sql,array($fine_id));

return $result;

}

 


public function appleisTo1($fine_id)
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = 'SELECT * FROM  
ourbank_finedetails A
where A.finedetails_id =? ';
$result = $this->db->fetchAll($sql,array($fine_id));
return $result;
}



public function finesUpdate($input = array(),$updateOlddata = array(),$updateNewdata = array())
{
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
foreach($match as $fineNames1) {
$fineUpdateing = array('fineupdates_id'=>'',
'fine_id' => $input['fine_id'],
'table_name'=>'ourbank_finedetails',
'fieldname'=>$fineNames1,
'previous_data'=>$updateOlddata[$fineNames1],
'current_data'=>$updateNewdata[$fineNames1],
'modified_by'=>$input['editedby'],
'modified_date'=>date("Y-m-d")
);
/**inerting a information about modified fields */
$this->db->insert('ourbank_fineupdates',$fineUpdateing);

}
$where[] = "fine_id = '".$input['fine_id']."'";
/**seting recordstatus_id to 2 and then inserting new values in both table */
$input1=  array('recordstatus_id' => '2');
$result = $this->db->update('ourbank_finedetails',$input1,$where);
$this->db->insert('ourbank_finedetails',$input);
return '1';
}
}
public function staffsearch($input = array())
{
$this->db->setFetchMode(Zend_Db::FETCH_OBJ);
$sql = "SELECT * FROM ourbank_finedetails a,ourbank_membertypes m,ourbank_glsubcode g,ourbank_glsubcodeupdates gu
WHERE (a.finename like ? '%') 
AND (a.fineappliesto_id like ? '%') 
AND (a.glsubcode_id like  ? '%') 
AND (a.finevalue like  ? '%') 
AND (a.recordstatus_id=3)
AND (g.glsubcode_id=gu.glsubcode_id) 
AND (a.fineappliesto_id =m.membertype_id) 
AND (a.glsubcode_id=g.glsubcode_id) 
AND gu.recordstatus_id=3 
ORDER BY fine_id ";
$result=$this->db->fetchAll($sql,array($input['finename'],$input['fineappliesto_id'],$input['glsubcode_id'],$input['finevalue']));
return $result;
}
public function sample($previous = array(),$current = array(),$fine_id)
{
$result=array_keys (array_diff($previous,$current));
foreach($result as $staff) {
$table_name='ourbank_finedetails';
$fineupdates = array('fineupdates_id'=>'',
'fine_id'=>$fine_id,
'fieldname'=>$staff,
'table_name'=>$table_name,
'previous_data'=>$previous[$staff],
'current_data'=>$current[$staff],
'modified_date'=>date("Y-m-d"));
$this->db->insert('ourbank_fineupdates',$fineupdates);
}
return;
}

public function fineDelete($fineId)
{
$where[] = "fine_id = '".$fineId."'";
$where[] = "recordstatus_id = '3'";
/**seting recordstatus_id to 2 and then inserting new values in both table */
$input1=  array('recordstatus_id' => '5');
$result = $this->db->update('ourbank_finedetails',$input1,$where);
return $result;
}
}

