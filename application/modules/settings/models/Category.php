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
class Management_Model_Category extends Zend_Db_Table {
     protected $_name = 'ourbank_categorydetails';

     public function getCategoryDetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_categorydetails'),array('category_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_userloginupdates'),'a.createdby = b.user_id')
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
        }
    public function viewCategory($category_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_categorydetails'),array('category_id'))
                       ->where('a.category_id = ?',$category_id)
                       ->where('a.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
        }

    public function addCategory($post,$category_id) {
        if($category_id) {
           $data = array('categoryupdates_id'=> '',
                         'category_id'=> $category_id,
                         'categoryname'=>$post['categoryname'],
                         'categorydescription'=>$post['categorydescription'],
                         'recordstatus_id'=>'3',
                         'createdby'=>'1',
                         'createddate'=>'೨೦೧0-೦೨-೦೯',
                         'editedby'=>'1',
                         'editeddate'=>'೨೦೧0-೦೨-೦೯');
            $this->insert($data);
        } else {
            $data = array('categoryupdates_id'=> '',
                          'category_id'=>$post['category_id'],
                          'categoryname'=>$post['categoryname'],
                          'categorydescription'=>$post['categorydescription'],
                          'recordstatus_id'=>'3',
                          'createdby'=>'1',
                          'createddate'=>'೨೦೧0-೦೨-೦೯',
                          'editedby'=>'1',
                          'editeddate'=>'೨೦೧0-೦೨-೦೯');
            $this->insert($data);
            }
    }

        public function deleteCategory($category_id) {
            $data = array('recordstatus_id'=> 1);
            $where = 'category_id = '.$category_id;
            $this->update($data , $where );
        }

        public function UpDateCategory($category_id) {
            $data = array('recordstatus_id'=> 2);
            $where = 'category_id = '.$category_id;
            $this->update($data , $where );
        }

    public function SearchCategory($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_categorydetails'),array('category_id'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.categoryname like "%" ? "%"',$post['field3'])
                       ->where('a.categorydescription like "%" ? "%"',$post['field2']);

       $result = $this->fetchAll($select);
       return $result->toArray();
    }
}
