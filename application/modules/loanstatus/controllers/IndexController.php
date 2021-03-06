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
class Loanstatus_IndexController extends Zend_Controller_Action {
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
		$this->view->pageTitle='Loan status';
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
                                                $this->_redirect("/loanstatus/index/status/accountNumber/$accountnumber");
                                            } else {
                                                $this->view->accounts = $loantransactions->searchaccounts($accountNumber);
                                            }
					}
				}
			}
		}
	}

	public function statusAction() {
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
           if(!$data){
               $this->_redirect('index/login');
           }
	   $this->view->pageTitle='Loan status';
	   $accountNumber= $this->_request->getParam('accountNumber');
           $this->view->accountnumber=$accountNumber;
	   $loantransactions = new Loandisbursment_Model_loan();
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
                $accountstatusId=$arrayroles1['accountstatus_id'];
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
                        $this->view->nextInstallment = $nextInstallment['accountinstallment_amount'];
                        $this->view->installment_status = $nextInstallment['installment_status'];
                    }
                    foreach($overDueInstalment as $overDueInstalment1) {
                        $this->view->dueAmount=$this->view->dueAmount+$overDueInstalment1['accountinstallment_amount'];
                        $due = $this->view->dueAmount;
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
            }

            $loanstatus=new Loanstatus_Model_loanstatus();
            $presentstatus = $loanstatus->fetchAllStatus($accountstatusId);
            foreach($presentstatus as $presentstatus){
                $this->view->presentstatus=$presentstatus['recordstatusdescription'];
            }

            $loan = new Loanstatus_Form_loanstatus();
            $this->view->loan = $loan;

            $newstatus = $loanstatus->fetchloanStatusDetails($accountstatusId);
            foreach($newstatus as $newstatus) {
                $loan->newStatus->addMultiOption($newstatus['recordstatus_id'],$newstatus['recordstatusdescription']);
            }


            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
               $formData = $this->_request->getPost();
               if ($this->_request->isPost()) {
                  if ($loan->isValid($formData)) {
                      $Status=$this->_request->getParam('newStatus');
                      $Statusdescription=$this->_request->getParam('description');
                      $sessionName = new Zend_Session_Namespace('ourbank');
                      $userId = $sessionName->primaryuserid;

                      $loanstatus=new Loanstatus_Model_loanstatus();
                      $data = array('accountstatus_id' =>$Status);
                      $loanstatus->updatemainaccountstatus($account_id,$data);

                      $data1 = array('loanstatus_id' =>$Status,'recordstatus_id' =>$Status,'created_by'=>$userId);
                      $loanstatus->updateloanaccountstatus($account_id,$data1);

                      $repayment=new Loanrepayment_Model_loanrepayment();
                      if($this->view->type==3) {
                         $data3 = array('groupmember_account_status' =>$Status);
                         $repayment->updategroupmemberloanaccountstatus($account,$data3);
                      }
                      $this->_redirect('/loanstatus');
                  }
               }
            }

       }
}