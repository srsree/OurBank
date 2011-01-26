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
class Asset_Model_asset extends Zend_Db_Table 
{
  protected $_name = 'ourbank_membername';

     public function getnonLivingassets() {

            $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_assettypes'),array('a.asset_type','a.units'))
                ->join(array('b'=>'ourbank_assetdetails'),'a.asset_typeid = b.asset_typeid',array('b.asset_id','b.asset_name'))
                ->where('b.asset_typeid=2');
         return $result = $this->fetchAll($select);
         //die($select->__toString($select));
    }

    public function getimmovableassets() {

        $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_assettypes'),array('a.asset_type','a.units'))
                ->join(array('b'=>'ourbank_assetdetails'),'a.asset_typeid = b.asset_typeid',array('b.asset_id','b.asset_name'))
                ->where('b.asset_typeid=1');
         return $result = $this->fetchAll($select);

    }

    public function getlivingassets() {

             $select=$this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_assettypes'),array('a.asset_type','a.units'))
                ->join(array('b'=>'ourbank_assetdetails'),'a.asset_typeid = b.asset_typeid',array('b.asset_id','b.asset_name'))
                ->where('b.asset_typeid=3');
         return $result = $this->fetchAll($select);
     
    }



}
