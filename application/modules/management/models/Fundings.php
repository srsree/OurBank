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
class Management_Model_Fundings extends Zend_Db_Table {
     protected $_name = 'ourbank_fundingdetails';

    public function getFundingsDetails() {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_fundingdetails'),array('fundingupdates_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_funderdetails'),'a.funder_id = b.funderaddress_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_currency'),'a.funding_currency_id = c.currency_id');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

  public function SearchFundings($post = array()) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_fundingdetails'),array('fundingupdates_id'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.fundingname like "%" ? "%"',$post['field2'])
                       ->where('a.fundingamount like "%" ? "%"',$post['field3'])
                       ->join(array('b'=>'ourbank_funderdetails'),'a.funder_id = b.funder_id')
                       ->where('b.recordstatus_id = 3')
                       ->where('b.fundername like "%" ? "%"',$post['field1'])
                       ->join(array('c'=>'ourbank_currency'),'a.funding_currency_id = c.currency_id')
                       ->where('c.currencyname like "%" ? "%"',$post['field5']);
           //die($select->__toString());
       $result = $this->fetchAll($select);
       return $result->toArray();
    }
     public function viewFundings($fundingupdates_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_fundingdetails'),array('fundingupdates_id'))
                       ->where('a.recordstatus_id = 3')
                       ->where('a.fundingupdates_id  = ?',$fundingupdates_id)
                       ->join(array('b'=>'ourbank_funderdetails'),'a.funder_id = b.funderaddress_id')
                       ->where('b.recordstatus_id = 3')
                       ->join(array('c'=>'ourbank_currency'),'a.funding_currency_id = c.currency_id')
                       ->join(array('d'=>'ourbank_institutionaddress'),'a.institution_id  = d.institution_id')
                       ->where('d.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
        }

    public function addFundings($post,$funding_id,$createby) {
           $data = array('fundingupdates_id'=> '',
                         'funding_id'=> $funding_id,
                         'fundingname'=>$post['fundingname'],
						 'institution_id'=>$post['institutionname'],
						 'interest'=>$post['interest'],
						 'exchangerate' =>$post['exchangerate'],
						 
                         'funder_id' =>$post['funder_id'],
                         'funding_currency_id' =>$post['funding_currency_id'],
                         'fundingamount' =>$post['fundingamount'],
                         'fund_beginingdate' =>$post['fund_beginingdate'],
                         'fund_closingdate' =>$post['fund_closingdate'],
                         'recordstatus_id'=>'3',
                         'createdby'=> $createby,
                         'createddate'=>date("Y-m-d"));
            $this->insert($data);
    }

    public function UpdateFundings($fundingupdates_id) {
        $data = array('recordstatus_id'=> 2);
        $where = 'fundingupdates_id = '.$fundingupdates_id;
        $this->update($data , $where );
    }

    public function editFundings($post,$createby) {
        $data = array('fundingupdates_id'=> '',
                      'funding_id'=>$post['funding_id'],
                      'fundingname'=>$post['fundingname'],
                      //'fundtype_id'=>$post['fundtype_id'],
		'institution_id'=>$post['institutionname'],
                      'funder_id'=>$post['funder_id'],
                      'funding_currency_id'=>$post['funding_currency_id'],
                      'fundingamount'=>$post['fundingamount'],
			'interest'=>$post['interest'],
                      'exchangerate'=>$post['exchangerate'],
                      //'accounting_line'=> '',
                      'recordstatus_id'=> 3,
                      'fund_beginingdate'=>$post['fund_beginingdate'],
                      'fund_closingdate'=>$post['fund_closingdate'],
                      'createdby'=>$createby,
                      'createddate'=>date("Y-m-d"));
        $this->insert($data);
     }

    public function deleteFundings($fundingupdates_id,$remarks) {
        $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
        $where = 'fundingupdates_id = '.$fundingupdates_id;
        $this->update($data , $where );
	}

	public function fetchAllinstitutiondetails() {
	$select = $this->select()
	->setIntegrityCheck(false)  
	->join(array('p' => 'ourbank_institutionaddress'),array('institution_id'))
	->where('p.recordstatus_id = 3 or p.recordstatus_id = 1');
	$result = $this->fetchAll($select);
	return $result->toArray();
	}


}
