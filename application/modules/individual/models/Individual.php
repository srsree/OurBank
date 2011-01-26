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
class Individual_Model_Individual extends Zend_Db_Table {
    protected $_name = 'ob_member';

//getting all member list...
    public function getMemberDetails() {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ob_member'),array('a.id'))
                        ->join(array('c' => 'gender'),'c.id = a.member_gender',array('c.sex'))
                        ->join(array('d' => 'ob_bank'),'d.id = a.bank_id',array('d.name'))
                        ->order(array('a.id DESC'));   
	//die($select->__toString($select));		
	return $this->fetchAll($select);
    }

//searching member with four different searching options name, gender, code, bank name...
    public function searchDetails($post = array()) {
	$select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ob_member'),array('a.id'))
                        ->join(array('c' => 'gender'),'c.id = a.member_gender',array('c.sex'))
                        ->join(array('d' => 'ob_bank'),'d.id = a.bank_id',array('d.name'))
                        ->where('a.membercode like "%" ? "%"',$post['code'])
                        ->where('a.member_name like "%" ? "%"',$post['name'])
                        ->where('a.member_gender like "%" ? "%"',$post['gender_id'])
                        ->where('a.bank_id like "%" ? "%"',$post['office'])
                        ->order(array('a.id DESC'));   
	//die($select->__toString($select));	
	return $this->fetchAll($select);
    }

 }
