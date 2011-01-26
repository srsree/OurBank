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
class Management_Model_Funders extends Zend_Db_Table {
     protected $_name = 'ourbank_funderdetails';

     public function getFundersDetails() {
        $result = $this->fetchAll( "recordstatus_id = '3'"  );
        return $result;
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
                         'emailaddress' =>$post['emailaddress'],
                         'recordstatus_id'=>'3',
                         'createdby'=>'1',
                         'createddate'=>date("Y-m-d"));
            $this->insert($data);
    }

    public function viewFunders($funderaddress_id) {
        $result = $this->fetchAll( "recordstatus_id = '3' AND 
                                    funderaddress_id = $funderaddress_id");
        return $result;
   }

    public function editFunders($post) {
        $data = array('funderaddress_id'=> '',
                      'funder_id'=>$post['funder_id'],
                      'fundername'=>$post['fundername'],
                      'fundershortname'=>$post['fundershortname'],
                      'funderaddress1'=>$post['funderaddress1'],
                      'funderaddress2'=>$post['funderaddress2'],
                      'funderaddress3'=>$post['funderaddress3'],
                      'fundercity'=>$post['fundercity'],
                      'funderstate'=>$post['funderstate'],
                      'fundercountry'=>$post['fundercountry'],
                      'funderpincode'=>$post['funderpincode'],
                      'funderphone'=>$post['funderphone'],
                      'emailaddress'=>$post['emailaddress'],
                      'recordstatus_id'=>'3',
                      'createdby'=>'1',
                      'createddate'=>date("Y-m-d"));
        $this->insert($data);
    }

    public function UpdateFunders($funderaddress_id) {
        $data = array('recordstatus_id'=> 2);
        $where = 'funderaddress_id = '.$funderaddress_id;
        $this->update($data , $where );
    }

    public function deleteFunders($funderaddress_id,$remarks) {
        $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
        $where = 'funderaddress_id = '.$funderaddress_id;
        $this->update($data , $where );
	}

}
