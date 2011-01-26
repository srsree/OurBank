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
class Loanrepayment_IndexController extends Zend_Controller_Action {
	public function init() {
		$this->view->title = "Loan transactions";
                $sessionName = new Zend_Session_Namespace('ourbank');
                $userid=$this->view->createdby = $sessionName->primaryuserid;
                $login=new App_Model_Users();
                $loginname=$login->username($userid);
                foreach($loginname as $loginname) {
                $this->view->username=$loginname['username'];
                }
	}

	public function indexAction() {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if(!$data){
                    $this->_redirect('index/login');
                }
		$this->view->pageTitle='Loan repayment';
		$loansearch = new Loandisbursment_Form_Membersearch();
		$this->view->form = $loansearch;
		$this->view->transactiontype='Loan transaction';

		$loantransactions = new Loandisbursment_Model_loan();

		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
			$formData = $this->_request->getPost();
			if ($this->_request->isPost()) {
				$formData = $this->_request->getPost();
				$accountNumber= $this->_request->getParam('member_id');
				if ($loansearch->isValid($formData)) {
					$search = $loantransactions->searchaccounts($accountNumber);
					if(!$search) {
                                            echo "Enter a valid Number";
				        } else {
                                            if(COUNT($search)=='1') {
                                                foreach($search as $account) {
                                                   $accountnumber=$account['account_number'];
                                                }
                                                $this->_redirect("/loanrepayment/index/repayment/accountNumber/$accountnumber");
                                            } else {
                                                $this->view->accounts = $loantransactions->searchaccounts($accountNumber);
                                            }
					}
				}
			}
		}
	}

	public function repaymentAction() {
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
           if(!$data){
               $this->_redirect('index/login');
           }
	   $this->view->pageTitle='Loan repayment';
	   $accountNumber= $this->_request->getParam('accountNumber');
           $this->view->accountnumber=$accountNumber;
	   $loantransactions = new Loandisbursment_Model_loan();
           $convertdate = new Creditline_Model_dateConvertor();
	   $search = $loantransactions->searchaccounts($accountNumber);
           $date = new Zend_Date();


            foreach($search as $arrayroles1) {
                $account_id=$this->view->account_id=$arrayroles1['account_id'];
                $this->view->type=$arrayroles1['membertype_id'];
                $this->view->membertype=$arrayroles1['membertype'];
                $loansanctionedamount=$this->view->loansanctionedamount=$arrayroles1['loan_amount'];
                $loansanctioneddate=$this->view->loansanctioneddate=$arrayroles1['loansanctioned_date'];
                $loanintereste=$this->view->loaninterest=$arrayroles1['loan_interest'];
                $totalloanInstallments=$this->view->totalloanInstallments=$arrayroles1['loan_installments'];
                $ballet=$this->view->ballet=$arrayroles1['billet'];
                $fee=$this->view->fee=$arrayroles1['fee'];
                $amountdelivered=$this->view->amountdelivered=$loansanctionedamount-$fee;
            }

            if($this->view->type==3) {
                $arrayroles = $loantransactions->search($accountNumber,$this->view->type);
                $this->view->member = $arrayroles;
                foreach($arrayroles as $arrayroles1) {
                    $this->view->code=$arrayroles1['groupcode'];
                    $this->view->name=$arrayroles1['group_name'];
                    $this->view->type=$arrayroles1['membertype_id'];
                    $this->view->creditlineid=$arrayroles1['creditline_id'];
                    $mobileno=$this->view->mobile=$arrayroles1['mobile'];
	       }
               $groupmembers= $this->view->groupmembers = $loantransactions->groupmembers($account_id);
               $noOfGroupmembersinaccount=COUNT($groupmembers);
	   } 


            if($this->view->type==4) {
                /**fetch all details if member type is 	Individual*/
                $arrayroles = $loantransactions->search($accountNumber,$this->view->type);
                $this->view->member = $arrayroles;
                foreach($arrayroles as $arrayroles1) {
                    $this->view->code=$arrayroles1['membercode'];
                    $this->view->name=$arrayroles1['member_name'];
                    $this->view->type=$arrayroles1['membertype_id'];
                    $this->view->creditlineid=$arrayroles1['creditline_id'];
                    $mobileno=$this->view->mobile=$arrayroles1['mobile'];
	       }
	   }

	   $loanrepayment = new Loanrepayment_Model_loanrepayment();
           $loanDetails1 = $loanrepayment->fetchLoanDisbursementDetails($account_id);
           $totladisburseAmount=0;
           foreach($loanDetails1 as $arrayroles1) {
              $totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
              $disburseddate=$arrayroles1['disbursement_date'];
           }
           $this->view->totladisburseAmount=$totladisburseAmount;

           if($totladisburseAmount) {
                $overDueInstalment=$loanrepayment->overDueInstalment($account_id);
                $this->view->noOfOverDueInstalment=count($overDueInstalment);
                if($this->view->noOfOverDueInstalment>="0") {
                    $due = $this->view->dueAmount="0";	

                    $next = $loanrepayment->loanNextInstalmentDetails($account_id);
                    foreach($next as $nextInstallment){
                        $this->view->nextInstallment = $nextInstallment['current_due'];
                        $this->view->nextInstallmentdate = $nextInstallment['accountinstallment_date'];
                        $this->view->installment_status = $nextInstallment['installment_status'];
                    }
                    foreach($overDueInstalment as $overDueInstalment1) {
                        $this->view->dueAmount=$this->view->dueAmount+$overDueInstalment1['current_due'];
                        $due = $this->view->dueAmount;
                        $this->view->overdueInstallmentdate = $overDueInstalment1['accountinstallment_date'];
                        $this->view->installment_status = $overDueInstalment1['installment_status'];
                    }
                } else {
                    $due = "0";
                }

                $InstalmentPaid=$loanrepayment->noOfInstalmentPaied($account_id);
                $noOfInstalmentPaid=count($InstalmentPaid);
                $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
                $this->view->paidAmount=0;
                foreach($InstalmentPaid as $InstalmentPaid) {
                    $this->view->paidAmount=$this->view->paidAmount+$InstalmentPaid['accountinstallment_amount'];
                }

                $this->view->balanceInstallment=$totalloanInstallments-$noOfInstalmentPaid;

                $loanstillHaveToPay = $loanrepayment->loanstilltopay($account_id);
                foreach($loanstillHaveToPay as $loanstilltopayamount) {
                    $this->view->stillHaveToPay=$loanstilltopayamount['stilltopayamount'];
                }

                if($noOfInstalmentPaid==$totalloanInstallments) {
                    $data = array('accountstatus_id' =>'5');
                    $loanrepayment->updatemainaccountstatus($account_id,$data);
                    $data1 = array('loanstatus_id' =>'5','recordstatus_id' =>'5');
                    $loanrepayment->updateloanaccountstatus($account_id,$data1);
    
                    if($this->view->type==3) {
                        $data3 = array('groupmember_account_status' =>'5');
                        $loanrepayment->updategroupmemberloanaccountstatus($account_id,$data3);
                    }
                    $this->_redirect('loanrepayment');
                }

                $loanInstalmentDetails = $loanrepayment->loanInstalmentDetails($account_id);
                foreach($loanInstalmentDetails as $loanInstalmentDetails1) {
                    $rateOfIntrest=$loanInstalmentDetails1['loan_interest'];
                    $noInstalment=$loanInstalmentDetails1['loan_installments'];
                    $this->view->loanAmount=$loanInstalmentDetails1['loan_amount'];
                    $this->view->loanAmountSanctioned = $loanInstalmentDetails1['loan_amount'];
                    $disbursedDate=$loanInstalmentDetails1['disbursement_date'];
                }
                $this->view->rateOfIntrest=$rateOfIntrest;
                $this->view->noInstalment=$noInstalment;

                $InstalmentNumber=$noOfInstalmentPaid+1;
                $currinstalmentNumber=$InstalmentNumber;

                $loanInstalmentDetailsOfInstalmentNo = $loanrepayment->loanInstalmentDetailsOfInstalmentNo($account_id,$InstalmentNumber);
                foreach($loanInstalmentDetailsOfInstalmentNo as $loanInstalmentDetailsOfInstalmentNo1) {
                    $nextInstalmentDate=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_date'];
                    $haveToPay=$loanInstalmentDetailsOfInstalmentNo1['current_due'];
                    $loanInterestAmount=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_interest_amount'];
                    $accountinstallment_date=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_date'];
                    $accountinstallmentpaid_date=$loanInstalmentDetailsOfInstalmentNo1['paid_date'];
                    $accountinstallment_date1=$accountinstallment_date;
                    $currentdate=$date->toString('YYYY-MM-dd');

                    $loanInstalmentPayied=$loanrepayment->loanInstalmentPaid($account_id,$InstalmentNumber-1);
                    if($loanInstalmentPayied) {
                        foreach($loanInstalmentPayied as $loanInstalmentDetailsOfInstalmentNo1) {
                            $lastPaidDate=$loanInstalmentDetailsOfInstalmentNo1['loaninstallmentpaid_date'];
                        }
                    } else { 
                        $lastPaidDate=$disbursedDate;
                    }
                }


                $loan = new Loanrepayment_Form_loanrepayment();
                $this->view->loan = $loan;
                $this->view->loan->installment_status->setValue($this->view->installment_status);
                $this->view->loan->interestamount->setValue($loanInterestAmount);
                $currentdate=date("Y-m-d");
    
                $fine=0;
                /**comparing system date with repayment date*/
                foreach($loanInstalmentDetails as $loanInstalmentDetails2) {
                    $accountinstallment_date=$loanInstalmentDetails2['accountinstallment_date'];
                    $InstalmentNumber=$loanInstalmentDetails2['accountinstallment_id'];
                    /**date of every instalment*/
                    $todaydate=date("Y-m-d");

                    if($todaydate > $accountinstallment_date) {

                        if($accountinstallmentpaid_date=="") {
                            $accountlastinstallmentdate=$accountinstallment_date;
                        } else { 
                            $accountlastinstallmentdate=$accountinstallmentpaid_date;
                        }


                        $presentdatedate=$todaydate;
                        $date_parts1=explode("-",$accountlastinstallmentdate );
                        $date_parts2=explode("-",$presentdatedate);
                        $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
                        $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
                        $this->view->noofdays=$noOfDays= $end_date - $start_date;



                                $penaltydetails=$loanrepayment->penaltydetails($this->view->creditlineid);
                                foreach($penaltydetails as $penaltydetail) {
                                    $penaltyflat=$penaltydetail['interest_of_delay'];
                                    $penaltydays=$penaltydetail['penalty_per_delay'];
                                }

                                $penaltyflatamount=(($this->view->dueAmount)*($penaltyflat/100));

                                $penaltydaysamount=((($this->view->dueAmount)*($penaltydays/100))*$noOfDays);
                                $amount=$penaltyflatamount+$penaltydaysamount;
                                $this->view->duetotalAmount=Round($amount+$this->view->dueAmount,2);


                        $instalmentStstus='5';
                        $statusOverdue=$loanrepayment->instalmentStatus($account_id,$InstalmentNumber,$instalmentStstus,$this->view->duetotalAmount);

                        if ($todaydate>$accountinstallment_date1) {
                            $this->view->loan->addElement(new Zend_Form_Element_Text('finedays'));
                            $this->view->loan->finedays->setAttrib('class', 'textfield');
                            $this->view->loan->finedays->setRequired(true);
                            $this->view->loan->finedays->setAttrib('readonly', 'true');
                            $this->view->loan->finedays->addValidators(array(array('Float')));


                            $this->view->loan->addElement(new Zend_Form_Element_Text('fineflat'));
                            $this->view->loan->fineflat->setAttrib('class', 'textfield');
                            $this->view->loan->fineflat->setRequired(true);
                            $this->view->loan->fineflat->setAttrib('readonly', 'true');
                            $this->view->loan->fineflat->addValidators(array(array('Float')));

                            $this->view->loan->addElement(new Zend_Form_Element_Text('instamount'));
                            $this->view->loan->instamount->setAttrib('class', 'textfield');
                            $this->view->loan->instamount->setRequired(true);
                            $this->view->loan->instamount->setAttrib('readonly', 'true');
                            $this->view->loan->instamount->addValidators(array(array('Float')));

                            if($amount) {
                                $this->view->loan->finedays->setValue($penaltydaysamount);
                                $this->view->loan->fineflat->setValue($penaltyflatamount);
                                $this->view->loan->instamount->setValue($this->view->dueAmount);
                            }
                        }
                    }
                }

                $paymentModeDetails = $loanrepayment->fetchAll_paymenttype_idforloans();
                foreach ($paymentModeDetails as $paymenttype1){
                    $loan->transactionMode->addMultiOption($paymenttype1['paymenttype_id'],$paymenttype1['paymenttype_description']);
                }

                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                    $formData = $this->_request->getPost();
                    if ($this->_request->isPost()) {
                        $paymentmode=$this->view->paymentmode = $this->_request->getParam('transactionMode');
                        if( $paymentmode ==1 ||$paymentmode =="" ) {
                            $loan->paymenttype_details->setRequired(false);
                        }
                        if ($loan->isValid($formData)) {
                            $loanrepaymentdate=$this->view->loanrepaymentdate = $convertdate->phpmysqlformat($this->_request->getParam('Date1'));
                            $repaymentamount=$this->view->repaymentamount = $this->_request->getParam('Amount');
                            $interestamount=$this->view->interestamount = $this->_request->getParam('interestamount');
                            $paymenttype_details=$this->view->paymenttype_details = $this->_request->getParam('paymenttype_details');
                            $description=$this->view->description = $this->_request->getParam('description');
                            $installmentstatus=$this->_request->getParam('installment_status');
                            $sms=$this->view->sms = $this->_request->getParam('sms');
                            $finedays=$this->_request->getParam('finedays');
                            $fineflat=$this->_request->getParam('fineflat');
                            $fineamounts=$finedays+$fineflat;
                            if($fineamounts) {
                                $repaymentfine=$fineamounts;
                            } else {
                                $repaymentfine='0';
                            }
                            $sessionName = new Zend_Session_Namespace('ourbank');
                            $userId = $sessionName->primaryuserid;
                            $currentdate=date("Y-m-d");
    
                            if($this->view->noOfOverDueInstalment>0) {
                                $amounttopay=$this->view->duetotalAmount;
                            } else {
                                $amounttopay=$this->view->nextInstallment;
                            }

                            $lastPaidnormalDate=$convertdate->phpnormalformat($lastPaidDate);
                            $currentnormaldate=$convertdate->phpnormalformat($currentdate);

                            if($loanrepaymentdate < $lastPaidDate) {
                                $this->view->repaydate= "Date must be grater than or equal to ->".$lastPaidnormalDate;
                            } elseif($loanrepaymentdate > $currentdate) { 
                                $this->view->currentdate= "Date must be smaller than or equal to->".$currentnormaldate;
                            } else {
                                $loanrepayment = new Loanrepayment_Model_loanrepayment();
                                $transactionData= array('transaction_id'=>'',
                                                    'account_id' => $account_id,
                                                    'transaction_date' => $loanrepaymentdate,
                                                    'amount_to_bank' => $repaymentamount,
                                                    'amount_from_bank' => '',
                                                    'transaction_amount' => $repaymentamount,
                                                    'paymenttype_mode'=>$paymentmode,
                                                    'paymenttype_details'=>$paymenttype_details,
                                                    'transaction_type' => 1,
                                                    'recordstatus_id'=>3,
                                                    'reffering_vouchernumber'=>'',
                                                    'transaction_remarks'=>$description,
                                                    'confirmation_flag'=>0,
                                                    'created_by'=>$userId,
                                                    'createddate'=>date("Y-m-d"));
                                $transaction_id=$loanrepayment->transactionInsert($transactionData);

                                $currentdue=$amounttopay-$repaymentamount;
                                $data = array('loanrepayment_id'=>'',
                                            'transaction_id'=>$transaction_id,
                                            'account_id' => $account_id,
                                            'loaninstallment_number'=>$currinstalmentNumber,
                                            'loaninstallmentpaid_date' => $loanrepaymentdate,
                                            'loaninstallmentpaid_amount' => $repaymentamount,
                                            'loaninstallmentpaid_interst'=>$interestamount,
                                            'loaninstallmentpaid_other_amount'=>$repaymentfine,
                                            'sms'=>$sms,
                                            'recordstatus_id'=>'3');
                                /**inserting a information to loan repament transaction table*/
                                $groupmembertransaction_id=$loanrepayment->loanRepaymentInsert($data,$installmentstatus,$loanrepaymentdate,$currentdue);



                                $nextduedata=$loanrepayment->nextdue($account_id);
                                foreach($nextduedata as $nextduedata55) {
                                   $accountinstallment_id=$nextduedata55['accountinstallment_id'];
                                   $Installmentstatusid=$nextduedata55['installment_status'];
                                }

                                $nextduedatainsert=$loanrepayment->nextdueinsert($account_id,$accountinstallment_id+1,$Installmentstatusid);


                                if($this->view->type==3) {
                                    $eachMemberLoanInterestAmountPaied=$interestamount/$noOfGroupmembersinaccount;
                                    $eachMemberAmountPaied=$repaymentamount/$noOfGroupmembersinaccount;
                                    $eachMemberFine=$repaymentfine/$noOfGroupmembersinaccount;
                                    foreach($this->view->groupmembers as $eachMember) {
                                        $data = array('groupmemberloanrepayment_id'=>'',
                                            'groupmembertransaction_id'=>$transaction_id,
                                            'groupaccount_id' => $account_id,
                                            'groupmemberaccount_id'=>$eachMember['membercode'],
                                            'groupmemberloaninstallment_number'=>$currinstalmentNumber,
                                            'groupmemberloaninstallmentpaid_date' => $loanrepaymentdate,
                                            'groupmemberloaninstallmentpaid_amount' => $eachMemberAmountPaied,
                                            'groupmemberloaninstallmentpaid_interst'=>$eachMemberLoanInterestAmountPaied,
                                            'groupmemberloaninstallmentpaid_other_amount'=>$eachMemberFine,
                                            'groupmemberloaninstallmentpaid_mode'=>$paymentmode,
                                            'groupmemberloaninstallmentpaid_details'=>$paymenttype_details,
                                            'recordstatus_id'=>'3');
                                        $insert=$loanrepayment->grouploanrepayment($data);
                                    }
                                }

                                if($sms=='1') {
                                    $smsid=$loantransactions->smsurl();
                                    foreach($smsid as $smsid1) {
                                        $smsurl=$smsid1['url'];
                                    }
                                    $message = "Your Finance request $accountNumber for the amount of R$ $repaymentamount has been repayed";
                                    $smsconvert= new App_Model_floatconversion();
                                    $url = $smsconvert->floatconversion('mmm',$mobileno,$smsconvert->floatconversion('xxx',urlencode($message),$smsurl));
                                    $client = new Zend_Http_Client($url);
                                    $response = $client->request();
                                }

			        $this->_redirect('/loanrepayment/index/repayment/accountNumber/'.$accountNumber);
                           }

                       }
                   }
               }
           }
       }
}