<?php
class Management_Model_Fundings extends Zend_Db_Table {
     protected $_name = 'ourbank_fundingdetails';

    public function getFundingsDetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_fundingdetails'),array('fundingupdates_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_funderdetails'),'a.funder_id = b.funder_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_currency'),'a.funding_currency_id = c.currency_id');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

     public function viewFundings($fundingupdates_id) {
        $result = $this->fetchAll( "recordstatus_id = '3' AND fundingupdates_id = $fundingupdates_id");
        return $result;
        }

    public function addFunder($post,$funder_id) {
           $data = array('funderaddress_id'=> '',
                         'funder_id'=> $funder_id,
                         'fundername'=>$post['fundername'],
                         'fundershortname'=>$post['fundershortname'],
                         'funderaddress1' =>$post['funderaddress1'],
                         'funderaddress2' =>$post['funderaddress2'],
                         'funderaddress3' =>$post['funderaddress3'],
                         'fundercity' =>$post['fundercity'],
                         'funderstate' =>$post['funderstate'],
                         'fundercountry' =>$post['fundercountry'],
                         'funderpincode' =>$post['funderpincode'],
                         'funderphone' =>$post['funderphone'],
                         'funderpincode' =>$post['funderpincode'],
                         'emailaddress' =>$post['emailaddress'],
                         'recordstatus_id'=>'3',
                         'createdby'=>'1',
                         'createddate'=>date("Y-m-d"));
            $this->insert($data);
    }

    public function SearchFunder($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_funderdetails'),array('funderaddress_id'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.fundername like "%" ? "%"',$post['field1'])
                       ->where('a.fundercountry like "%" ? "%"',$post['field2'])
                       ->where('a.funderphone like "%" ? "%"',$post['field3'])
                       ->where('a.emailaddress like "%" ? "%"',$post['field4']);
       $result = $this->fetchAll($select);
       return $result->toArray();
    }



}
