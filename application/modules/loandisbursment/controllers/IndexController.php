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
class Loandisbursment_IndexController extends Zend_Controller_Action {
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
		$this->view->pageTitle='Loan disbursment';
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
                                                $this->_redirect("/loandisbursment/index/disbursment/accountNumber/$accountnumber");
                                            } else {
                                                $this->view->accounts = $loantransactions->searchaccounts($accountNumber);
                                            }
					}
				}
			}
		}
	}

	public function disbursmentAction() {
	   $this->view->pageTitle='Loan disbursment';
	   $accountNumber= $this->_request->getParam('accountNumber');
           $this->view->accountnumber=$accountNumber;
	   $loantransactions = new Loandisbursment_Model_loan();
           $convertdate = new Creditline_Model_dateConvertor();
	   $search = $loantransactions->searchaccounts($accountNumber);

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
                    $mobileno=$this->view->mobile=$arrayroles1['mobile'];
	       }
	   }

	    $loanrepayment = new Loanrepayment_Model_loanrepayment();
            $loanDetails1 = $loanrepayment->fetchLoanDisbursementDetails($account_id);
            $totladisburseAmount=0;
            foreach($loanDetails1 as $arrayroles1) {
              $totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
            }
            $this->view->totladisburseAmount=$totladisburseAmount;

            $loan = new Loandisbursment_Form_loandisbursement();
            $this->view->loan = $loan;
            $this->view->loan->Amount->setValue(sprintf("%4.2f", $amountdelivered));
            $currentdate=date("Y-m-d");

            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                $formData = $this->_request->getPost();
                if ($this->_request->isPost()) {
                    if ($loan->isValid($formData)) {
                        $loandisbursmentdate=$this->view->loandisbursmentdate = $convertdate->phpmysqlformat($this->_request->getParam('Date1'));
                        $sms=$this->view->sms = $this->_request->getParam('sms');
                        $description=$this->view->description = $this->_request->getParam('description');
                        $sessionName = new Zend_Session_Namespace('ourbank');
                        $userId = $sessionName->primaryuserid;
                        $disbursedamount=$loansanctionedamount;
                        $totaldisbursment=$disbursedamount-$fee;

                        $loansanctionednormaldate=$convertdate->phpnormalformat($loansanctioneddate);
                        $currentnormaldate=$convertdate->phpnormalformat($currentdate);

                        if($loandisbursmentdate < $loansanctioneddate) {
                            $this->view->sanctioneddate= "Date must be greater than or equal to loan sanctioned date - '$loansanctionednormaldate'";
                        } elseif ($loandisbursmentdate > $currentdate) {
                            $this->view->currentdate= "Date must be lesser than or equal to current date - '$currentnormaldate'";
                        } else {
                            $transaction_id = $loantransactions->transactionInsert(array(
                                    'transaction_id' => '',
                                    'account_id' => $account_id,
                                    'transaction_date' => $loandisbursmentdate,
                                    'amount_to_bank' => '',
                                    'amount_from_bank' => $disbursedamount,
                                    'transaction_amount' => $disbursedamount,
                                    'paymenttype_mode'=>1,
                                    'paymenttype_details'=>'',
                                    'transaction_type' => 1,
                                    'recordstatus_id'=>3,
                                    'reffering_vouchernumber'=>'',
                                    'transaction_remarks'=>$description,
                                    'confirmation_flag'=>0,
                                    'created_by'=>$userId,
                                    'createddate'=>date("Y-m-d")));

                            $transactiondisbursmentInsertion = $loantransactions->disbursementInsertion(array('loandisbursement_id' => '',
                                          'transaction_id' => $transaction_id,
                                          'account_id' => $account_id,
                                          'disbursement_date' => $loandisbursmentdate,
                                          'accountdisbursement_id'=>1,
                                          'disbursed_by' => $userId,
                                          'amount_disbursed' => $disbursedamount,
                                          'sms' => $sms,
                                          'transaction_type' => 1,
                                          'transaction_description'=>$description,
                                          'recordstatus_id'=>3));



                            $RateperMonth=($loanintereste/100);
                            $nemerator=pow(1+$RateperMonth,$totalloanInstallments);
                            $denominator=($nemerator-1);
                            $EMI=($disbursedamount*$RateperMonth*$nemerator/$denominator);

                            $m_princinst=$disbursedamount/$totalloanInstallments;
                            $m_int=round(($EMI-$m_princinst),2);

                            $disbursedDate1 = new Zend_Date();
                            $disbursedDate1->set($loandisbursmentdate,Zend_Date::DATES);
                            $installmentDates=$loandisbursmentdate;
                            for($i=1;$i<=($totalloanInstallments);$i++) {
                                if($i=="1") {
                                    $status="4";
                                } else { 
                                    $status="3";
                                }

                                $installmentDates=$this->add_dateAction($installmentDates,30,0,0);

                                $transactioninstallments=$loantransactions->loanInstallmentInsertion(array(
                                        'Installmentserial_id' => '',
                                        'account_id' => $account_id,
                                        'accountinstallment_id' => $i,
                                        'accountinstallment_date' => $installmentDates,
                                        'accountinstallment_amount' => $EMI+$ballet,
                                        'accountinstallment_interest_amount'=> $m_int,
                                        'billet'=> $ballet,
                                        'installment_principal_amount'=>$m_princinst,
                                        'installment_principalreduceing_amount'=>'',
                                        'current_due'=>$EMI+$ballet,
                                        'installment_status' =>$status,
                                        'created_by' =>$userId,
                                        'created_date'=>date("Y-m-d"),
                                        'recordstatus_id'=>3));
                            }

                            $data = array('accountstatus_id' =>'1');
                            $loantransactions->updateaccounts($account_id,$data);

                            $data1 = array('loanstatus_id' =>'1','recordstatus_id'=>'1');
                            $loantransactions->updateloanaccounts($account_id,$data1);

                            if($this->view->type==3) {
                                $dividedAmount=$disbursedamount/$noOfGroupmembersinaccount;
                                foreach($this->view->groupmembers as $eachMember) {
                                    $data = array('groupmemberloandisbursement_id'=>'',
                                                'groupmembertransaction_id'=>$transaction_id,
                                                'groupaccount_id' => $account_id,
                                                'groupmemberaccount_id'=>$eachMember['membercode'],
                                                'loandisbursement_date'=>$loandisbursmentdate,
                                                'loanpayment_by'=>$userId,
                                                'groupmember_loanamount'=>$dividedAmount,
                                                'recordstatus_id'=>3);
                                    $insert=$loantransactions->grouploandisbursment($data);
                                }
                                $data2 = array('groupmember_account_status' =>'1');
                                $loantransactions->updategrouploanaccounts($account_id,$data2);
                            }

                            //sms
                            if($sms=='1') {
                                $smsid=$loantransactions->smsurl();
                                foreach($smsid as $smsid1) {
                                    $smsurl=$smsid1['url'];
                                }
                                $message = "Your Finance request $accountNumber for the amount of R$ $amountdelivered has been disbursed";
                                $smsconvert= new App_Model_floatconversion();
                                $url = $smsconvert->floatconversion('mmm',$mobileno,$smsconvert->floatconversion('xxx',urlencode($message),$smsurl));


                                $client = new Zend_Http_Client($url);
                                $response = $client->request();

                            }

			    $this->_redirect("/loandisbursment/index/amountdisbursed/amountdelivered/$amountdelivered/accountnumber/$accountNumber");
                        }

                    }
                }
            }
       }

	public function amountdisbursedAction() {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if(!$data){
                    $this->_redirect('index/login');
                }
		$this->view->pageTitle='Loan disbursment';
                $amountdelivered=$this->view->amountdelivered = $this->_request->getParam('amountdelivered');
                $accountnumber=$this->view->accountnumber = $this->_request->getParam('accountnumber');

	}

        function add_dateAction($givendate,$day=0,$mth=0,$yr=0) {
            $cd = strtotime($givendate);
            $newdate = date('Y-m-d', mktime(date('h',$cd),
            date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
            date('d',$cd)+$day, date('Y',$cd)+$yr));
            return $newdate;
        }
}