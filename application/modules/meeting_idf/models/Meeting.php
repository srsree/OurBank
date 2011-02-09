
<?php
class Meeting_Model_Meeting extends Zend_Db_Table 
{
    protected $_name = 'ourbank_meeting';

    public function fetchAllmeetingdetails() 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ourbank_meeting'),array('id'))
                ->join(array('b'=>'ourbank_group'),'b.id = a.group_id',array('b.id as gid','b.name as gname'))
                ->order(array('a.id DESC'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function getBranch()
     {
       $db = $this->getAdapter();
        $sql = 'select * from ourbank_office
                       where officetype_id in
                   (select id from ourbank_officehierarchy
                       where Hierarchy_level in
                   (select max(Hierarchy_level) from ourbank_officehierarchy))';
       $result = $db->fetchAll($sql);
       return $result;
   }




    public function fetchGroupnames($officeId) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('ourbank_group')
                ->where('village_id =  ?',$officeId);
//         die ($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchMeetingdetailsForID($id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ourbank_meeting'),array('id'))
                ->where('a.id = '.$id)
                ->join(array('b' => 'ourbank_group'),'b.id = a.group_id',array('b.id as gid','b.name as gname'))
                ->join(array('c'=>'ourbank_office'),'c.id = a.village_id',array('name as bank_name'))
                ->join(array('d' => 'ourbank_member'),'d.id = b.head',array('d.name as grouphead_name'))
                ->join(array('e' => 'ourbank_master_weekdays'),'e.id = a.day',array('e.id as wid','e.name as day'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function SearchMeeting($post) 
    {
        $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a'=>'ourbank_meeting'),array('id'))
                    ->where('a.name like "%" ? "%"',$post['search_meeting_name'])
                    ->where('a.place like "%" ? "%"',$post['search_meeting_place'])
                    ->where('a.day like "%" ? "%"',$post['search_weekdays'])
                    ->join(array('b'=>'ourbank_group'),'b.id = a.group_id',array('b.name as gname'))
                    ->where('b.name like "%" ? "%"',$post['search_group_name'])
                    ->order(array('a.id desc'));
//         die ($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}
