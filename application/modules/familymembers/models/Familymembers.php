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
class Familymembers_Model_Familymembers  extends Zend_Db_Table {
    protected $_name = 'ourbank_member';

    public function getfamilydetails($mebmerid)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_family'),array('a.id'))
                ->where('a.member_id=?',$mebmerid)
                ->join(array('b'=>'ourbank_master_realtionshiptype'),'a.relationship_id=b.id',array('b.name as relationname'))
                ->join(array('c'=>'ourbank_master_educationtype'),'a.eductaion_id=c.id',array('c.name as qualifyname'))
                ->join(array('d'=>'ourbank_master_gender'),'a.gender_id=d.id',array('d.name as gendername'))
                ->join(array('e'=>'ourbank_master_profession'),'a.profession_id=e.id',array('e.name as proffessionname'))
                ->join(array('f'=>'ourbank_master_skills'),'a.skill=f.id',array('f.name as skillname'))
                ->join(array('h'=>'ourbank_master_maritalstatus'),'a.maritalstatus_id=h.id',array('h.name as maritalname'));
        $result=$this->fetchAll($select);
        return $result->toArray();
    }

    public function getfamilydetails1($mebmerid)
    {
        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_family'),array('a.id'))
                ->where('a.member_id=?',$mebmerid);
        $result=$this->fetchAll($select);
        return $result->toArray();
    }
    public function deleteFamily($table,$param)  
    {
        $db = $this->getAdapter();
        $db->delete($table,array('member_id = '.$param));
        return;
    }
}

?>

