
<?php
class Meeting_Model_Meeting extends Zend_Db_Table 
{
    protected $_name = 'ob_meeting';

    public function fetchAllmeetingdetails() 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->join(array('a'=>'ob_meeting'),array('id'))
                ->join(array('b'=>'ob_group'),'b.id = a.group_id',array('b.id as gid','b.name as gname'))
                ->order(array('a.id DESC'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchMeetingdetailsForID($id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->join(array('a' => 'ob_meeting'),array('id'))
                ->where('a.id = '.$id)
                ->join(array('b' => 'ob_group'),'b.id = a.group_id',array('b.id as gid','b.name as gname'))
                ->join(array('c'=>'ob_bank'),'c.id = a.bank_id',array('name as bank_name'))
                ->join(array('d' => 'ob_member'),'d.id = b.group_head',array('d.member_name as grouphead_name'));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function getMeetingForGroupId($group_id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)  
                ->from('ob_meeting')
                ->where('group_id = ?',$group_id);
        $result = $this->fetchAll($select);
        return $result->toArray();
    }


    public function getDays() 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('ob_weekdays');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchGroupnames($bank_id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('ob_group')
                ->where('bank_id  =  ?',$bank_id);
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function fetchHeadName($group_id) 
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->join(array('a' => 'ob_group'),array('group_id'))
                ->where('a.id = '.$group_id)
                ->join(array('b' => 'ob_member'),'b.id = a.group_head');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function SearchMeeting($post) 
    {
        $select = $this->select()
                    ->setIntegrityCheck(false)  
                    ->join(array('a'=>'ob_meeting'),array('id'))
                    ->where('a.name like "%" ? "%"',$post['search_meeting_name'])
                    ->where('a.place like "%" ? "%"',$post['search_meeting_place'])
                    ->where('a.day like "%" ? "%"',$post['search_weekdays'])
                    ->join(array('b'=>'ob_group'),'b.id = a.group_id',array('b.name as gname'))
                    ->where('b.name like "%" ? "%"',$post['search_group_name'])
                    ->order(array('a.id desc'));
//         die ($select->__toString($select));
        $result = $this->fetchAll($select);
        return $result->toArray();
    }
}
