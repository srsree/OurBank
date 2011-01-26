<?php
class Accounting_Model_Groupmembertransaction extends Zend_Db_Table {
     protected $_name = 'ourbank_groupmember_recurringtransaction';


    public function Addtransaction($savings_amount,$account_id,$createdby,$feeTotal,$interest) {
        $data = array('transaction_id' => '',
                      'account_id' => $account_id,
                      'transaction_date' => date("Y-m-d"),
                      'amount_to_bank' => $savings_amount,
                      'amount_from_bank' => '',
                      'transaction_amount' => $feeTotal,
                      'transaction_interest_amount'=> '',
                      'transaction_fine_amount' => '',
                      'transaction_other_amount' => '',
                      'paymenttype_mode' => 1,
                      'transaction_mode_details' => 1,
                      'transaction_type' => 1,
                      'recordstatus_id' =>3,
                      'reffering_vouchernumber' =>'',
                      'transaction_remarks' => '',
                      'balance' => '',
                      'confirmation_flag' =>0,
                      'updated_by' => '',
                      'created_by' => $createdby,
                      'createddate' => date("Y-m-d"));
       $this->insert($data);
	}
}
