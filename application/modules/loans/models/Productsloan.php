<?php
class Loans_Model_Productsloan extends Zend_Db_Table {
     protected $_name = 'ourbank_productsloan';

    public function Addproductsloan($post,$offerproduct_id) {
$this->db = Zend_Db_Table::getDefaultAdapter();
        $data = array('productsoffer_id'=>$offerproduct_id,
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
         $this->db->insert('ourbank_productsloan',$data);
    }

    public function editLoan($table,$post,$offerproduct_id) { 
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $where='productsoffer_id = '.$offerproduct_id;
        $data = array('minmumloanamount' => $post['minmumloanamount'], 
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
        $this->db->update($table,$data,$where);
    }
}
