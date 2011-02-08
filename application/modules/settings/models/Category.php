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
