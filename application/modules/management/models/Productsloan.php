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
class Management_Model_Productsloan extends Zend_Db_Table {
     protected $_name = 'ourbank_productsloan';

    public function Addproductsloan($post,$offerproductupdate_id) {
        $data = array('offerproductupdate_id'=>$offerproductupdate_id,
                      'minmumloanamount'=>$post['minmumloanamount'],
                      'maximunloanamount'=>$post['maximunloanamount'],
                      'interesttype_id'=>$post['interesttype_id'],
                      'minimumloaninterest'=>'',
                      'maximunloaninterest'=>'',
                      'penal_Interest'=>$post['penal_Interest'],
                      'installmenttype_id'=>'',
                      'minimumfrequency'=>$post['minimumfrequency'],
                      'maximumfrequency'=>$post['minimumfrequency'],
                      'graceperiodtype_id'=>'',
                      'graceperiodnumber'=>$post['graceperiodnumber'],
                      'fund_id'=> '',
                      'glsubcode' => '');
         $this->insert($data);
    }

    public function editproductloan($post,$offerproductupdate_id) { 
        $data = array('offerproductupdate_id' => $offerproductupdate_id,
                      'minmumloanamount' => $post['minmumloanamount'], 
                      'maximunloanamount' => $post['maximunloanamount'],
                      'interesttype_id'=>$post['interesttype_id'],
                      'minimumloaninterest' => '',
                      'maximunloaninterest' => '',
                      'penal_Interest' => $post['penal_Interest'],
                      'installmenttype_id' => '',
                      'minimumfrequency' => $post['minimumfrequency'],
                      'maximumfrequency' => $post['maximumfrequency'],
                      'fee_id' => '',
                      'graceperiodtype_id' => '',
                      'graceperiodnumber' => $post['graceperiodnumber'], 
                      'fund_id' => '',
                      'glsubcode' => '');
        $this->insert($data);
    }

public function updateLoan($offerproductupdate_id) {
                $data = array('recordstatus_id'=> 2);
		$where = 'offerproductupdate_id = '.$offerproductupdate_id;
		$this->update($data , $where);
                        }

 

}
