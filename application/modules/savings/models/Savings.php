<?php
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
class Savings_Model_Savings extends Zend_Db_Table {
        // set ourbank_productsoffer is a base table 
	protected $_name = 'ourbank_productsoffer';

	public function fetchAllofferProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productsoffer'),array('id'),array('id as productid','name as productname','shortname as shortnames','begindate','closedate'))
	           	->join(array('A' => 'ourbank_product'),'p.product_id = A.id')
			->join(array('B' => 'ourbank_category'),'A.category_id=B.id')
                        ->where('A.category_id = 1') 
			->join(array('c'=>'ourbank_membertypes'),'p.applicableto = c.id');
		$result = $this->fetchAll($select);
		return $result->toArray();
  		// return available offerdetails
	}

	public function SearchofferProduct($post = array()) {
                $dateconvertor = new App_Model_dateConvertor();
                if($post['fromdate']){
                    $begindate = $dateconvertor->phpmysqlformat($post['fromdate']);
                } else {
                    $begindate = $post['fromdate'];
                }
            
                if($post['todate']){
                    $closedate = $dateconvertor->phpmysqlformat($post['todate']);
                } else {
                    $closedate = $post['todate'];
                }

 		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('b' => 'ourbank_productsoffer'),array('id'),array('id as productid','name as productname','begindate','closedate','shortname as shortnames'))
                ->join(array('a' => 'ob_membertypes'),'b.applicableto = a.membertype_id',array('membertype as type'))
			->where('b.name like "%" ? "%"',$post['prodname'])
			->where('b.shortname like "%" ? "%"',$post['shname'])
			->where('b.begindate like "%" ? "%"',$begindate)
			->where('b.closedate like "%" ? "%"',$closedate);
		$result = $this->fetchAll($select);
		return $result->toArray();
  		// return searched offerdetails

	}

	public function offerProductshortname($offerproduct_id) { 
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsoffer'),array('id'))
			->where('a.id = ?',$offerproduct_id)
	           	->join(array('b' => 'ourbank_product'),'a.product_id = b.id',array('b.shortname'));
		$result = $this->fetchAll($select);
		return $result->toArray(); // return get product short name
	}
// 
	public function viewofferProduct($offerproduct_id,$offerproductshortname) {
		if($offerproductshortname == 'ps') {
			$tablename="ourbank_productssaving";
			$fielid1 = "frequencyofdeposit";
		} else {
			$tablename="ourbank_product_fixedrecurring";
			$fielid1 = "frequency_of_deposit";
		}
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsoffer'),array('id'),array('name as pname','shortname as psname','begindate','closedate','description','applicableto','glsubcode_id','fee_glsubcode_id'))
			->where('a.id = ?',$offerproduct_id)
			->join(array('b' => $tablename),'a.id = b.productsoffer_id')
			->join(array('c' => 'ourbank_product'),'a.product_id = c.id',array('name as productname','shortname'))
			->join(array('d' => 'ourbank_membertypes'),'a.applicableto = d.id',array('type as applicableperson'))
			->join(array('f' => 'ourbank_glsubcode'),'a.glsubcode_id = f.id',array('header','glsubcode'))
			->join(array('e' => 'ourbank_frequencyofpayment'),'b.'.$fielid1.'= e.id',array('type as installment'));
		$result = $this->fetchAll($select);
		return $result->toArray(); // return product details for that particular id 
	}
 
	public function viewinterest($offerproduct_id) { 
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsoffer'),array('id'))
			->where('a.id = ?',$offerproduct_id)
			->join(array('c' => 'ourbank_interest_periods'),'a.id = c.offerproduct_id ')
			->where('c.intereststatus_id = 3 or c.intereststatus_id = 1');
		$result = $this->fetchAll($select);
		return $result->toArray(); // return interest details
	}

        public function getRecord($value)
                    {
                    $select = $this->select()
                            ->setIntegrityCheck(false)  
                            ->join(array('a' => 'ourbank_interest_periods'),array('id'))
                            ->where('a.offerproduct_id ='.$value);
                    $result = $this->fetchAll($select);
                    return $result->toArray();// return interest details for particular offer id
                    }
            public function updateRecordpoffer($offerproduct_id,$data,$shortname) {
                $convertdate = new App_Model_dateConvertor();

                if($data['closedate'] == "") {
			$CLOSEDDATE="0000-00-00";
		} else {
			$CLOSEDDATE= $convertdate->phpmysqlformat($data['closedate']);
		}
                if($data['feeglcode'] == "") {
                        $feesubcode = '';
                } else {
                        $feesubcode = $data['feeglcode'];
                }
                $db = $this->getAdapter();
		$data = array('name'=>$data['offerproductname'],
                              'shortname' =>$data['offerproductshortname'],
                              'product_id' =>$data['offerproduct_id'],
                              'description' =>$data['offerproduct_description'],
                              'begindate' =>$convertdate->phpmysqlformat($data['begindate']),
                             'closedate' =>$CLOSEDDATE,
                            'applicableto' =>$data['applicableto'],
                            'glsubcode_id' =>$data['glsubcode_id'],
                            'fee_glsubcode_id'=>$feesubcode);
		$where = 'id = '.$offerproduct_id;
		$db->update('ourbank_productsoffer',$data,$where); // update product offer table
	} 
        public function updateRecordps($offerproduct_id,$data) {
         $db = $this->getAdapter();

		$data = array('frequencyofdeposit'=>$data['frequencyofdeposit'],
                              'minmumdeposit' =>$data['minmumdeposit'],
                              'minimumbalanceforinterest' =>$data['minimumbalanceforinterest'],
                              'frequencyofinterestupdating' =>$data['frequencyofinterestupdating'],
                              'Int_timefrequency_id' =>$data['Int_timefrequency_id']);
		$where = 'productsoffer_id = '.$offerproduct_id;
		$db->update('ourbank_productssaving',$data,$where); // update product saving table
	} 
        public function updateRecordfd($offerproduct_id,$data) {
         $db = $this->getAdapter();
		$data = array('productsoffer_id'=>$data['offerproduct_id'],
                              'minimum_deposit_amount' =>$data['minimum_deposit_amount'],
                              'maximum_deposit_amount' =>$data['maximum_deposit_amount'],
                              'frequency_of_deposit' =>$data['frequency_of_deposit'],
                              'penal_Interest' =>$data['penal_Interest']);
		$where = 'productsoffer_id = '.$offerproduct_id;
		$db->update('ourbank_product_fixedrecurring',$data,$where);// update fixed saving table
	}
	public function getProductDetails() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_product'),array('id'))
			->where('category_id=1');
		$result = $this->fetchAll($select);
		return $result->toArray(); // return product details
	}
 	public function getfrequencyofdepo($frequencyofdeposit2) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_frequencyofpayment'),array('id'))
			->where('a.id = ?',$frequencyofdeposit2);
		$result = $this->fetchAll($select);
		return $result->toArray(); // return frequency type values with condition
	}

	public function getglsubcode_id($glsubcode_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_glsubcodeupdates'),array('glsubcode_id'))
			->where('a.glsubcode_id = ?',$glsubcode_id)
			->join(array('c' => 'ourbank_glsubcode'),'a.glsubcode_id = c.glsubcode_id');
		$result = $this->fetchAll($select);
		return $result->toArray();// return glsubcode type values
	}

	public function getproduct_id($offerproduct_id) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_productsoffer'),array('id'),array('a.id as offerid'))
			->where('a.id = ?',$offerproduct_id)
			->join(array('b' => 'ourbank_product'),'a.product_id=b.id',array('b.id'));
		$result = $this->fetchAll($select);
		return $result->toArray(); // return product value for particular offer id
	}

	public function fetchAllTimeFrequencyType() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_frequencyofpayment'),array('id'));
		$result = $this->fetchAll($select);
		return $result->toArray();// return frequency type values
	}
// 
	public function fetchAllMemberType() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('id'));
		$result = $this->fetchAll($select);
		return $result->toArray(); // return membertype
	}
// 
	public function fetchAllglsubcode() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_glsubcode'),array('id'))
			->where('a.subledger_id = 4');
		$result = $this->fetchAll($select);
		return $result->toArray(); // return liabilities values 
	}
        public function interestcalperiod($periodid) {
		$db = $this->getAdapter();
                        $sql = "select type from ourbank_frequencyofpayment where id = $periodid";
                        $result = $db->fetchOne($sql);
	       return $result; // return frequency term for period id
	}
// 
	public function getapplicableto($applicableto2) {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_membertypes'),array('id'))
			->where('a.id = ?',$applicableto2);
		$result = $this->fetchAll($select);
		return $result->toArray(); // get membertypes for id
	}
	public function addofferproduct($post,$product_id,$closeddate) {
                // instance to convert date
                $convertdate = new App_Model_dateConvertor();
		$user_id = $sessionName->primaryuserid;
		if($closeddate == "") {
			$CLOSEDDATE="0000-00-00";
		} else {
			$CLOSEDDATE= $convertdate->phpmysqlformat($closeddate);
		}
                if($post['feeglcode'] == "") {
                        $feesubcode = '';
                } else {
                        $feesubcode = $post['feeglcode'];
                }
               	$data = array('id'=> '',
					'name'=>$post['offerproductname'],
					'shortname'=>$post['offerproductshortname'],
					'product_id'=>$product_id,
					'description'=>$post['offerproduct_description'],
					'begindate'=>$convertdate->phpmysqlformat($post['begindate']),
					'closedate'=>$CLOSEDDATE,
					'applicableto'=>$post['applicableto'],
					'glsubcode_id'=>$post['glsubcode_id'],
					'capital_glsubcode_id'=>'',
					'Interest_glsubcode_id'=>'',
					'fee_glsubcode_id'=>$feesubcode);
		$this->insert($data); //insert pffer details
	}

        public function addinterestlog($table,$data){
            $this->db = Zend_Db_Table::getDefaultAdapter();
            $this->db->insert($table,$data); // insert interest log values
        }
        public function addofferproduct1($post,$id) {
		$sessionName = new Zend_Session_Namespace('ourbank');
		$user_id = $sessionName->primaryuserid;
		$this->db = Zend_Db_Table::getDefaultAdapter();

		$data = array('record_id'=> '',
                                        'id' => $id,
					'name'=>$post['name'],
					'shortname'=>$post['shortname'],
					'product_id'=>$post['product_id'],
					'description'=>$post['description'],
					'begindate'=>$post['begindate'],
					'closedate'=>$post['closedate'],
					'applicableto'=>$post['applicableto'],
					'glsubcode_id'=>$post['glsubcode_id'],
					'capital_glsubcode_id'=>'',
					'Interest_glsubcode_id'=>'',
					'fee_glsubcode_id'=>'');
		$this->db->insert('ourbank_productsoffer_log',$data);//insert offer log values
	}

	public function addofferproductsavings($post,$offerproductupdate_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('productsoffer_id'=> $offerproductupdate_id,
                                'savingsindividualgroup'=> '',
                                'frequencyofdeposit'=>$post['frequencyofdeposit'],
                                'depo_timefrequency_id'=>'',
                                'minmumdeposit'=>$post['minmumdeposit'],
                                'maximumwithdrawal'=>'',
                                'rateofinterest'=>'',
                                'minimumbalanceforinterest'=>$post['minimumbalanceforinterest'],
                                'minimumperiodforinterest'=>'',
                                'frequencyofinterestupdating'=>$post['frequencyofinterestupdating'],
                                'Int_timefrequency_id'=>$post['Int_timefrequency_id'],
                                'amountusedforcalculateinterest'=>'');
		return $this->db->insert('ourbank_productssaving',$data); // insert personal savings value
	}

        public function addofferproductsavingslog($post,$offerproductupdate_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('record_id'=> '',
                                'productsoffer_id'=> $offerproductupdate_id,
                                'savingsindividualgroup'=> '',
                                'frequencyofdeposit'=>$post['frequencyofdeposit'],
                                'depo_timefrequency_id'=>'',
                                'minmumdeposit'=>$post['minmumdeposit'],
                                'maximumwithdrawal'=>'',
                                'rateofinterest'=>'',
                                'minimumbalanceforinterest'=>$post['minimumbalanceforinterest'],
                                'minimumperiodforinterest'=>'',
                                'frequencyofinterestupdating'=>$post['frequencyofinterestupdating'],
                                'Int_timefrequency_id'=>$post['Int_timefrequency_id'],
                                'amountusedforcalculateinterest'=>'');
		return $this->db->insert('ourbank_productssaving_log',$data); // insert personal savings log values
	}

	public function addofferproductfixedrecurring($post,$offerproductupdate_id) {

		$this->db = Zend_Db_Table::getDefaultAdapter();
                $data = array('productsoffer_id'=> $offerproductupdate_id,
                            'minimum_deposit_amount'=> $post['minimum_deposit_amount'],
                            'maximum_deposit_amount'=>$post['maximum_deposit_amount'],
                            'minimum_periodof_deposit'=>'',
                            'maximum_periodof_deposit'=>'',
                            'frequency_of_deposit'=>$post['frequency_of_deposit'],
                            'penal_Interest'=>$post['penal_Interest'],
                            'other_charges'=>'');
		return $this->db->insert('ourbank_product_fixedrecurring',$data); // insert fixed or recurring values
	}
        public function fixedrecurringlog($post,$offerproductupdate_id) {
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$data = array('record_id' =>'',
                                'productsoffer_id'=> $offerproductupdate_id,
                                'minimum_deposit_amount'=> $post['minimum_deposit_amount'],
                                'maximum_deposit_amount'=>$post['maximum_deposit_amount'],
                                'minimum_periodof_deposit'=>'',
                                'maximum_periodof_deposit'=>'',
                                'frequency_of_deposit'=>$post['frequency_of_deposit'],
                                'penal_Interest'=>$post['penal_Interest'],
                                'other_charges'=>'');
		$this->db->insert('ourbank_product_fixedrecurring_log',$data); // insert fixed or recurring log values
	}
        public function insertinterestperiodslog($data){
            $this->db = Zend_Db_Table::getDefaultAdapter();
            $this->db->insert('ourbank_interest_periods_log',$data); // insert interest log values
        } 
        public function deleteinterestRecord($value)  
            {
                $db = $this->getAdapter();
                $where[] ='offerproduct_id ='.$value;
                $db->delete('ourbank_interest_periods',$where); // delete interest values
            }
        // get status of product offer for particular id 
        public function getsavingstatus($offerid)  
                    {
                        $db = $this->getAdapter();
                        $sql ="select * from ourbank_accounts where product_id ='".$offerid."'";
                        $result = $db->fetchAll($sql);
                        return $result;
                    }
        public function getproductname($offerid)  
                    {
                        $db = $this->getAdapter();
                        $sql ="select product_id,name from ourbank_productsoffer where product_id ='".$offerid."'";
                        $result = $db->fetchAll($sql);
                        return $result; // return product id with name 
                    }
}
