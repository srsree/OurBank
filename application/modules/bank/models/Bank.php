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
class Bank_Model_Bank extends Zend_Db_Table 
{
    protected $_name = 'ob_bank';
    public function addBank($table,$post) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
		$db->insert($table,$post);
		return $db->lastInsertId('id');
    }
    //bank details
    public function getBank()
    {
		$select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_bank'),array('id '))
		->order('id DESC');
		return $this->fetchAll($select);
    }
    //bank filtered details
    public function search($name)
    {
		$select = $this->select()
					->setIntegrityCheck(false)  
					->join(array('a' => 'ob_bank'),array('id '))
        			->where('a.name  like "%" ? "%"',$name)
					->order('id DESC');
		return $this->fetchAll($select);
    }
        
    public function viewBank($id)
    {
	$select = $this->select()
		->setIntegrityCheck(false)  
		->join(array('a' => 'ob_bank'),array('id '))

                ->where('a.id = ?',$id);
	//fetch filtered details
	$result = $this->fetchAll($select);
	return $result->toArray();
	 
        
    }

    	//update detail
    public function updateBank($id,$data)  
    {
	
        $where = array('id = '.$id,);
		$db = $this->getAdapter();
        $db->update('ob_bank', $data , $where);
        return;
    }
	//delete
    public function deleteBank($id)  
    {
	
        $where = array('id = '.$id,);
		$db = $this->getAdapter();
        $db->delete('ob_bank',$where);
        return;
    }

}
