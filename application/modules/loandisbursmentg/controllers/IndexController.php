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
class Loandisbursmentg_IndexController extends Zend_Controller_Action {
    public function init() 
    {
    	$this->view->title = "Loans";
        $this->view->pageTitle = "Loans disbursement";
		$this->view->type='loans';
        $this->view->loanModel = new Loandisbursmentg_Model_loan();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();

    }
    public function indexAction() 
    {
		$loansearch = new Loandisbursmentg_Form_Search();
		$this->view->form = $loansearch;
		$this->view->transactiontype='Loan transaction';
		if ($this->_request->getPost('Search')) {
			$formData = $this->_request->getPost();
			if ($loansearch->isValid($formData)) {
		    	$search = $this->view->loanModel->searchaccounts($this->_request->getParam('accNum'));
		    	if (!$search) {
                        echo "Enter a valid Number";
		    	} else {
					if (COUNT($search)=='1') {
						foreach($search as $account) {
							$accountnumber=$account->number;
						}
						$this->_redirect("/loandisbursmentg/index/disbursment/accNum/".base64_encode($accountnumber));
					} else {
					$this->view->accounts = $this->view->loanModel->searchaccounts($this->_request->getParam('accNum'));
					}
		   		}
		    }
		}
    }

    public function disbursmentAction() 
    {
        $this->view->pageTitle='Loan disbursement';
        $this->view->accNum = $accNum = base64_decode($this->_request->getParam('accNum'));
        $this->view->details = $this->view->loanModel->searchaccounts($accNum);
        $this->view->active = $this->view->loanModel->activeDisburs($accNum);
		if (substr($accNum,4,1) == 2) {
			$this->view->group = $this->view->loanModel->getMember($accNum);
		}
        $loanForm = $this->view->loan = new Loandisbursmentg_Form_loandisbursement();
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                if ($loanForm->isValid($formData)) {
                    $accNum = base64_decode($this->_request->getParam('accNum'));
                    //Make the loan acc active
                    $this->view->loanModel->active($accNum);
      		    $search = $this->view->loanModel->searchaccounts($accNum);
      		    //Zend_Debug::dump($search);
      		    foreach($search as $search) {
      		        $gl = $search->gl;
      		        $accId = $search->accId;
      		        $intType = $search->interesttype; // Interest type
      		        $installments = $search->installments;
      		        $interest = $search->interest;
      		        $amount = $search->amount;
					$number = $search->number;
					$sAccId = $search->sAccId; 
					$officeid = $search->officeid;
      		    }
                //Passing a transfer entry to transaction
                $data = array('account_id' => $accId,
                                  'glsubcode_id_to' => $gl,
                                  'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                  'amount_from_bank' => $this->_request->getPost('Amount'),
                                  'paymenttype_id'=> 5,
                                  'transactiontype_id' => 2,
                                  'recordstatus_id'=> 3,
                                  'transaction_description'=> $this->_request->getPost('description') ,
                                  'confirmation_flag'=>0,
                                  'created_by'=>1);
      		    $tranID = $this->view->adm->addRecord('ourbank_transaction',$data);
      		    //Passing an entry to loan disbursement table
      		    $input = array('transaction_id' => $tranID,
                                  'account_id' => $accId,
                                  'loandisbursement_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                  'accountdisbursement_id' => 1,
                                  'disbursed_by'=>1,
                                  'amount_disbursed' => $this->_request->getPost('Amount'),
                                  'transaction_description'=> $this->_request->getPost('description'),
                                  'recordstatus_id'=>3);
      		    $tranID = $this->view->adm->addRecord('ourbank_loan_disbursement',$input);
                    if ($intType == 2) {
                        $emi =0;$roi=0;
                        $cb=$amount;
                        $date = $this->view->cl->phpmysqlformat($this->_request->getPost('date'));
                        //EMI ie., decling capital
                        $rpm = $interest/100/12;
                        $emi = (($amount)*($rpm)*pow((1+$rpm),$installments))/(pow((1+$rpm),$installments)-1);

                        for ($i=0; $i<$installments; $i++) {
                             $date = $this->dateAction($date,30,0,0);
                             //$roi = rate of interest
                             $status = ($i == 0) ? 4: 3;
                              $roi =$cb*$rpm;
			      			  $cb = $cb - ($emi - $roi);
                             //echo "<br>Date: ".$date." Roi: ".$roi." Emi: ".$emi." Balance: ".$cb."<br>";
                             $instl = array('account_id' => $accId,
                                            'installment_id' => $i+1,
                                            'installment_date' => $date,
                                            'installment_amount' => $emi,
                                            'installment_interest_amount'=> $roi,
                                            'installment_principal_amount' => round(($emi - $roi),2),
                                            'reduced_prinicipal_balance'=> round($cb,2),
                                            'installment_status' => $status,
                                            'created_by' => 1);
                           $this->view->adm->addRecord('ourbank_installmentdetails',$instl);
                        }
                    }
                    $sglData = $this->view->loanModel->getSavingGl($sAccId);
                    foreach($sglData as $sglData) 
                    {
                        $sgl = $sglData->glsubcode_id;
                        $balance = $sglData->balance;

                    }
                $bankData = $this->view->loanModel->glBank($officeid);
      		foreach ($bankData as $bankData) {
      		    $bankGl = $bankData->id;
      		}
      		// Bank Asset Dt entry
      		$bankEntry = array('office_id'=>$officeid,
                            'glsubcode_id_to'=>$bankGl,
                            'transaction_id'=>$tranID,
                            'debit' => $this->_request->getPost('Amount'),
                            'record_status'=>'3');
      		$this->view->adm->addRecord('ourbank_Assets',$bankEntry);
      		$glbankEntry = array('office_id'=>$officeid,
                            'glsubcode_id_to'=>$gl,
                            'transaction_id'=>$tranID,
                            'debit' => $this->_request->getPost('Amount'),
                            'record_status'=>'3');
                $this->view->adm->addRecord('ourbank_Assets',$glbankEntry);
		// An entry into transaction (saving transfer)
		$input = array('account_id' => $sAccId,
                                      'glsubcode_id_to' => $sgl,
                                      'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                      'amount_to_bank' => $this->_request->getPost('Amount'),
                                      'paymenttype_id' => 1,
                                      'transactiontype_id' => 1,
                                      'recordstatus_id' => 3,
                                      'transaction_description'=> "Transfer from loan disbursemnet",
                                      'balance' => $balance + $this->_request->getPost('amount'),
                                      'confirmation_flag' => 0,
                                      'created_by' => 1);
      		$stranID = $this->view->adm->addRecord('ourbank_transaction',$input);
      		// Insertion into saving transaction 
      		$saving = array('transaction_id' => $stranID,
      		                      'account_id' => $sAccId,
                                      'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                      'transactiontype_id' => 1,
                                      'glsubcode_id_to' => $sgl,
                                      'amount_to_bank' => $this->_request->getPost('Amount'),
                                      'paymenttype_id' => 1,
                                      'transaction_description'=> "Transfer from loan disbursemnet",
                                      'transaction_by' => 1);
      		$this->view->adm->addRecord('ourbank_savings_transaction',$saving);
      		$bankData = $this->view->loanModel->glBank($officeid);
      		foreach ($bankData as $bankData) {
      		    $bankGl = $bankData->id;
      		}
      		// Bank Liabality Cr entry
      		$crEntry = array('office_id'=>$officeid,
                            'glsubcode_id_to'=>$bankGl,
                            'transaction_id'=>$stranID,
                            'credit' => $this->_request->getPost('Amount'),
                            'record_status'=>'3');
      		$this->view->adm->addRecord('ourbank_Assets',$crEntry);
      		$glcrEntry = array('office_id'=>$officeid,
                            'glsubcode_id_to'=>$sgl,
                            'transaction_id'=>$stranID,
                            'credit' => $this->_request->getPost('Amount'),
                            'record_status'=>'3');
                $this->view->adm->addRecord('ourbank_Liabilities',$glcrEntry);
		if (substr($accNum,4,1) == 2) {
			$this->view->loanModel->goupAcc($accNum,
											$accId,
											$this->view->cl->phpmysqlformat($this->_request->getPost('date')),
											$this->_request->getPost('Amount'),
											$tranID);
		}
		$this->_redirect("/loandisbursmentg/index/message/amt/".base64_encode($this->_request->getPost('Amount'))."/accNum/".base64_encode($number));

                }
            }
        }
    }

    public function messageAction() 
    {
        $this->view->amt = base64_decode($this->_request->getParam('amt'));
        $this->view->accNum = base64_decode($this->_request->getParam('accNum'));
    }

    function dateAction($givendate,$day=0,$mth=0,$yr=0) 
    {
        $cd = strtotime($givendate);
        $newdate = date('Y-m-d', mktime(date('h',$cd),
        date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
        date('d',$cd)+$day, date('Y',$cd)+$yr));
        return $newdate;
    }
    
}