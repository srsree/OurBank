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

<!--
 *  get funder details and module details
!-->
<?php
class Fundercommonview_Model_fundercommon extends Zend_Db_Table {
    protected $_name = 'ob_member';

    public function getfunder($id)
    {
        $select=$this->select()
        ->setIntegrityCheck(false)
        ->join(array('a'=>'ob_funder'),array('a.id'))
        ->join(array('b'=>'ob_funder_types'),('b.id = a.type'))
        ->where('a.id=?',$id);
        $result=$this->fetchAll($select);
	//return funder details
        return $result->toArray();
    }

    public function getmodule($modulename)
    {
        $select=$this->select()
            ->setIntegrityCheck(false)
            ->join(array('ob_modules'),array('module_id'))
            ->where('module_description=?',$modulename);
        $result=$this->fetchAll($select);
	//return module details
        return $result->toArray();
    }

}
