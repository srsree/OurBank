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
class Recurringtransaction_IndexController extends Zend_Controller_Action 
{
    public function init() {
        $this->view->pageTitle='Recurring transaction';
        $this->view->type="recurring";
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }
    }

    public function indexAction() 
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $Recurringdepositsavings = new Recurringtransaction_Form_Membersearch();
        $this->view->form = $Recurringdepositsavings;
        $recurringSavings = new Recurringtransaction_Model_recurringSavings();

        if ($this->_request->isPost() && $this->_request->getPost('Search')) {

            $formData = $this->_request->getPost();
            $membercode = $this->_request->getParam('member_id');
            if ($Recurringdepositsavings->isValid($formData)) {
                $arrayrecurringAccountSearch = $recurringSavings->recurringAccountsSearch($membercode);
                if (!$arrayrecurringAccountSearch) {
                    $accountcode=$membercode;
                    $arrayrecurringAccountSearch = $recurringSavings->recurringSearch($accountcode);
                    if (!$arrayrecurringAccountSearch) {
                            echo "No records found";
                    } else {
                        $this->view->recurringAccountsSearch = $arrayrecurringAccountSearch;
                        foreach($arrayrecurringAccountSearch as $arrayrecurringAccountSearch1) {
                            $this->view->account_id=$arrayrecurringAccountSearch1['account_id'];
                            $this->view->product_id=$arrayrecurringAccountSearch1['product_id'];
                        }
                        $this->_redirect('recurringtransaction/index/recurring/accountId/'.base64_encode($this->view->account_id).'/productId/'.base64_encode($this->view->product_id));
                    }
                }
                 else {
                    $this->view->recurringAccountsSearch = $arrayrecurringAccountSearch;
                    foreach($arrayrecurringAccountSearch as $arrayrecurringAccountSearch1) {
                        $this->view->membername = $arrayrecurringAccountSearch1['membername'];
                        $accountID=$this->view->account_id=$arrayrecurringAccountSearch1['account_id'];
                        $this->view->product_id=$arrayrecurringAccountSearch1['product_id'];
                        $this->view->account_number=$arrayrecurringAccountSearch1['account_number'];
                        $this->view->membercode=$arrayrecurringAccountSearch1['membercode'];
                        $membertypeId=$this->view->membertype_ID=$arrayrecurringAccountSearch1['membertype_ID'];
                        $memberId=$this->view->member_id=$arrayrecurringAccountSearch1['member_id'];
                        $offerproductname=$this->view->offerproductname=$arrayrecurringAccountSearch1['offerproductname'];
                    }
                    $groupNamesSearchFetch = $recurringSavings->groupNamesSearch($memberId);
                    $this->view->groupNamesSearch = $groupNamesSearchFetch;
                    foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
                        $this->view->groupname=$groupNamesSearchFetch1['groupname'];
                        $this->view->group_id=$groupNamesSearchFetch1['group_id'];
                    }
                   $membernameFetch = $recurringSavings->individualMemberName($memberId);
                    $accountIDFetch = $recurringSavings->accountIDSearch($memberId);
                    $this->view->accountIDFetch = $accountIDFetch;
                    foreach($membernameFetch as $membernameFetch1) {
                        $this->view->memberfirstname=$membernameFetch1['name'];
                    }
                }
            }
        }
    }

    function recurringAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $matureDate=0;
        $fixedInterest=0;
        $InstalmentNumber=0;
        $amountTopay=0;

        $accountId = base64_decode($this->_request->getParam('accountId'));
        $productId = base64_decode($this->_request->getParam('productId'));
//         $matured = base64_decode($this->_request->getParam('matured'));
//         $capital = base64_decode($this->_request->getParam('capital'));
//         $this->view->manualRepayment= $this->_request->getParam('manualRepayment');
//         $date = new Zend_Date();
        $this->view->accountid=$accountId;
        $this->view->productid=$productId;

        $recurringDetails=new Recurringtransaction_Model_recurringSavings();
        $fixedSavings = new Recurringtransaction_Model_fixedSavings();

        $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
        $this->view->installmentsDetails = $installmentsDetailsFetch;
        foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
            $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
            $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
            $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
            $status=$installmentsDetailsFetch1['rec_payment_status'];
        }

        $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);

        $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
        foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
            $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
            $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
            $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
            $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
            $this->view->membertypr_id=$recurringAccountDetailsFetch1['membertype_id'];
            $recurring_amount=$recurringAccountDetailsFetch1['recurring_amount'];
            $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
        }

        $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
        $this->view->recurringmemberbranchid = $recurringmemberbranchid;
        foreach($recurringmemberbranchid as $recurringmemberbranchids) {
            $memberbranch_id=$this->view->memberbransch_id=$recurringmemberbranchids['office_id'];
        }

        $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
        $this->view->recurringPaidDetails = $recurringPaidDetails;
        $paidAmount=0;
        foreach($recurringPaidDetails as $recurringPaidDetailss) {
            $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
        }
        $this->view->paidAmount=$paidAmount;

        //validate for display ( deposit, renewal, status )
        $this->view->depositcheck1 = $recurringDetails->depositcheck($accountId);
        $this->view->statuscheck1 = $recurringDetails->statuscheck($accountId);

//         $systemDate= $date->get(Zend_Date::DATES); /*system date*/
        $currentdate=date('Y-m-d');
        $this->view->currentDate=$currentdate;
        $this->view->maturedate=$matureDate;
        $RateperMonth=$fixedInterest/12;
        $this->view->installmentNumber=$InstalmentNumber;
        $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
        $capitalAmount=($amountTopay*$InstalmentNumber);
        $this->view->capitalAmount=$capitalAmount;	
        $simpleInterest=round($simpleInterest,2);
        $this->view->simpleInterest=$simpleInterest;


        $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
        $this->view->matureAmount=$matureAmount;
// 
//         $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
//         $this->view->groupNamesSearch = $groupNamesSearchFetch;
//         foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//             $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//             $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//             $accountNumber=$groupNamesSearchFetch1['account_number'];
//         }
// 
//         if($this->view->groupname) {
//             $groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//             $this->view->groupMembersDetails=$groupMembersDetails;
//         }
    } 
        /*End of Fetch all the Details Based on Account Id and Product Id on the URl*/

    function recurringsAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }
        $app = $this->view->baseUrl();
        $accountId = base64_decode($this->_request->getParam('accountId'));
        $productId = base64_decode($this->_request->getParam('productId'));
        $matured = base64_decode($this->_request->getParam('matured'));
        $capital = base64_decode($this->_request->getParam('capital'));
        $this->view->manualRepayment= $this->_request->getParam('manualRepayment');
        $date = new Zend_Date();
        $this->view->accountid=$accountId;
        $this->view->productid=$productId;

        $fixedSavings = new Recurringtransaction_Model_fixedSavings();
        $recurringDetails=new Recurringtransaction_Model_recurringSavings();

               //validate for display ( deposit, renewal, status )
        $this->view->depositcheck1 = $recurringDetails->depositcheck($accountId);
        $this->view->statuscheck1 = $recurringDetails->statuscheck($accountId);

        $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
        $this->view->installmentsDetails = $installmentsDetailsFetch;
        foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
            $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
            $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
            $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
            $status=$installmentsDetailsFetch1['rec_payment_status'];
        }
        $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);
        $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
        foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
                $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
                $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
                $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
                $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
                $this->view->membertypr_id=$recurringAccountDetailsFetch1['membertype_id'];
                $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
        }

        $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
        $this->view->recurringmemberbranchid = $recurringmemberbranchid;
        foreach($recurringmemberbranchid as $recurringmemberbranchids) {
                $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['office_id'];
        }

        $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
        $this->view->recurringPaidDetails = $recurringPaidDetails;
        $paidAmount=0;
        foreach($recurringPaidDetails as $recurringPaidDetailss) {
                $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
        }
        $this->view->paidAmount=$paidAmount;

                $systemDate= $date->get(Zend_Date::DATES); /*system date*/
                $currentdate=$date->toString('YYYY-MM-dd');
                $this->view->currentDate=$currentdate;
                $this->view->maturedate=$matureDate;
                $RateperMonth=$fixedInterest/12;
                $this->view->installmentNumber=$InstalmentNumber;
                $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
                $capitalAmount=($amountTopay*$InstalmentNumber);
                $this->view->capitalAmount=$capitalAmount;	
                $simpleInterest=round($simpleInterest,2);
                $this->view->simpleInterest=$simpleInterest;


                $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
                $this->view->matureAmount=$matureAmount;
// 
//                 $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
//                 $this->view->groupNamesSearch = $groupNamesSearchFetch;
//                 foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//                         $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//                         $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//                         $accountNumber=$groupNamesSearchFetch1['account_number'];
//                 }
// 
//                 if($this->view->groupname) {
//                         $groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//                         $this->view->groupMembersDetails=$groupMembersDetails;
//                 }
// 
        $noOfInstalmentPaid1=$recurringDetails->noOfInstalmentPaid($accountId);
        $noOfInstalmentPaid=count($noOfInstalmentPaid1);
        $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
        $this->view->rec_principal_amount=0;
        foreach($noOfInstalmentPaid1 as $loanInstalmentDetails1) {
            $this->view->rec_principal_amount=$this->view->rec_principal_amount+$loanInstalmentDetails1['rec_payment_amount'];
        }

        $IndividualnameFetch = $recurringDetails->fetchMemberName($accountId);
        foreach($IndividualnameFetch as $IndividualnameFetch1) {
                $this->view->memberfirstname=$IndividualnameFetch1['memberfirstname'];
        }

        $this->view->currentDate=$currentdate;
        $this->view->maturedate=$matureDate;
        $recurringProductDetails=$recurringDetails->recurringProductDetails($accountId,$productId);
        foreach($recurringProductDetails as $recurringProductDetails1) {
            $recurringBeginDate=$this->view->begindate=$recurringProductDetails1['begindate'];
            $recurringClosedDate=$this->view->closedate=$recurringProductDetails1['closedate'];
            $recurringMinAmount=$this->view->minimum_deposit_amount=$recurringProductDetails1['minimum_deposit_amount'];
            $recurringMaxAmount=$this->view->maximum_deposit_amount=$recurringProductDetails1['maximum_deposit_amount'];
            $memberId=$this->view->member_id=$recurringProductDetails1['member_id'];
        }

        $RecurringAccountForm = new Recurringtransaction_Form_RecurringAccount($recurringBeginDate,$recurringClosedDate,$recurringMinAmount,$recurringMaxAmount,$app); 
        $this->view->form2 = $RecurringAccountForm;
        $this->view->form2->accountId->setValue($accountId);
        $this->view->form2->productId->setValue($productId);  /*setting values*/
        $this->view->form2->member_id->setValue($memberId);  /*setting values*/
        if($matured){
                $this->view->form2->recurringamount->setValue($matured);  /*setting values*/
        } else {
                $this->view->form2->recurringamount->setValue($capital);  /*setting values*/
        }


                $currentdate=$date->toString('YYYY-MM-dd');
                $this->view->currentDate=$currentdate;
                $this->view->maturedate=$matureDate;
                $RateperMonth=$fixedInterest/12;
                $this->view->installmentNumber=$InstalmentNumber;
                $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
                $simpleInterest=round($simpleInterest,2);
                $this->view->simpleInterest=$simpleInterest;
                $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
                $this->view->matureAmount=$matureAmount;
                $InstalmentNumber=$noOfInstalmentPaid+1;
                if($InstalmentNumber==1) {
                        $lastPaidDate=$begindate;
                } else  {
                        $recurringInstalmentpayments=$recurringDetails->recurringInstalmentpayments($accountId,$InstalmentNumber-1);
                        foreach($recurringInstalmentpayments as $recurringInstalmentpayments1) {
                                $lastPaidDate=$recurringInstalmentpayments1['rec_payment_date']; /*last instalment paid date*/
                        }
                }

                $recurringForm=new Recurringtransaction_Form_recurringTransaction($amountTopay,$currentdate,$lastPaidDate);
                $this->view->recurringForm=$recurringForm;
                $this->view->recurringForm->accountId->setValue($accountId);
                $this->view->recurringForm->productId->setValue($productId);  /*fetching all payment mode */
// 
//                 if($this->view->manualRepayment=='yes' && $this->view->groupname) {
//                         $this->view->recurringForm->amount->setAttrib('readonly', 'true');
//                         $this->view->recurringForm->amount->setAttrib('class', 'textfieldreadonly');
//                         foreach($this->view->groupMembersDetails as $arrayroles1)  {
//                                 $a='amount'.$arrayroles1['member_id'];
//                                 $this->view->recurringForm->addElement(new Zend_Form_Element_Text($a));
//                                 $this->view->recurringForm->$a->setAttrib('class', 'txt txt_put');
//                                 $this->view->recurringForm->$a->setAttrib('onchange', 'totalAmount(this.value)');
//                                 $this->view->recurringForm->$a->addValidators(array(array('Digits')));
//                         }
//                 }
// 
            $due=$this->view->dueAmount=0;
            $accountnextinstallmentdate=$recurringDetails->nextinstallmentdate($accountId);
            foreach($accountnextinstallmentdate as $accountnextinstallmentdates) {
                $nextinstallmentdate=$accountnextinstallmentdates['rec_payment_date'];
                $accountinstallment_date1=$nextinstallmentdate;
                $InstalmentNumber=$accountnextinstallmentdates['rec_payment_id'];
                $this->view->dueAmount=$this->view->dueAmount+$accountnextinstallmentdates['rec_payment_amount'];
                $due=$this->view->dueAmount;

                $systemDate= $date->get(Zend_Date::DATES);
                $date->set($nextinstallmentdate,Zend_Date::DATES);
                $nextinstallmentdate=$date->get($nextinstallmentdate,Zend_Date::DATES);

                $date->set($systemDate,Zend_Date::DATES);

                if (($date->isLater($nextinstallmentdate, Zend_Date::DATES))) {
                    $systemDate= $date->get(Zend_Date::DATES);

                    $installmentDate = new Zend_Date($nextinstallmentdate, Zend_Date::DATES);
                    $accountnextdueinstallmentdate=$installmentDate->toString('YYYY-MM-dd');

                    $systemDate = new Zend_Date($systemDate, Zend_Date::DATES);
                    $presentdatedate=$systemDate->toString('YYYY-MM-dd');

                    $date_parts1=explode("-",$accountnextdueinstallmentdate );
                    $date_parts2=explode("-",$presentdatedate);
                    $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
                    $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
                    $noOfDays= $end_date - $start_date;

                    if($noOfDays >= 1) {
                            $fineAmount = $recurringDetails->getDelayFine();
                            foreach($fineAmount as $fineData) {
                                    $DelayFine = $fineData['feevalue'];
                            }
                            if($due) {
                                    $amount = (($due * $DelayFine)/100)*$noOfDays;
                                    $amountDisplayed = $amount + $due ;
                                    $this->view->dueAmount = round($amountDisplayed,2);
                            } else {
                                    $amount = 0;
                            }
                    }	 

                    $installmentStatus='5';
                    $statusOverdue=$recurringDetails->instalmentStatus($accountId,$InstalmentNumber,$installmentStatus);
                    if (($date->isLater($accountinstallment_date1, Zend_Date::DATES))) {
                        $this->view->recurringForm->addElement(new Zend_Form_Element_Text('fine'));
                        $this->view->recurringForm->fine->setAttrib('class', 'textfield');
                        $this->view->recurringForm->fine->setRequired(true);
                        if($amount) {
                                $this->view->recurringForm->fine->setValue($amount);
                        }
                        $this->view->recurringForm->fine->setAttrib('readonly', 'true');
                        $this->view->recurringForm->fine->addValidators(array(array('Float'),
                                                            array('GreaterThan',false,array('1',
                                                            'messages' => array('notGreaterThan' => 'Min=1Rs')))));
                    }
                }
            }

            $paymentModeDetails = $recurringDetails->fetchAllPaymentMode();
            foreach ($paymentModeDetails as $paymenttype1) {
                    $recurringForm->transactionMode->addMultiOption($paymenttype1['id'],$paymenttype1['description']);
            }
//                 $freequencyofdeposit =$recurringDetails->fetchfreequencyofdeposit();
//                 foreach($freequencyofdeposit as $freequency) {
//                         $RecurringAccountForm->frequencyofdeposit->addMultiOption($freequency['timefrequncy_id'],$freequency['timefrequencytype']);
//                 }
        }

        function depositAction()
        {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data){
                    $this->_redirect('index/login');
            }

            $this->view->manualRepayment= $this->_request->getParam('manualRepayment');
            $user_id=$this->view->user_id;
            $accountId = $this->_request->getParam('accountId');
            $productId = $this->_request->getParam('productId');
            $this->view->accountid=$accountId;
            $this->view->productid=$productId;
            $date = new Zend_Date();

            $fixedSavings = new Recurringtransaction_Model_fixedSavings();
            $recurringDetails=new Recurringtransaction_Model_recurringSavings();
            $savingsDetails=new Recurringtransaction_Model_persnolSavings();

            $noOfInstalmentPaid1=$recurringDetails->noOfInstalmentPaid($accountId);
            $noOfInstalmentPaid=count($noOfInstalmentPaid1); // echo $noOfInstalmentPaid;
            $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
            $this->view->rec_principal_amount=0;
            foreach($noOfInstalmentPaid1 as $loanInstalmentDetails1) {
                $this->view->rec_principal_amount=$this->view->rec_principal_amount+$loanInstalmentDetails1['rec_payment_amount'];
            }

            $numberofinstallments=$recurringDetails->TotalnoOfInstalmentPaid($accountId);
            $totalnumberofinstallments=count($numberofinstallments);
            $this->view->TotalnoOfInstalmentPaid=$totalnumberofinstallments;

            $IndividualnameFetch = $recurringDetails->fetchMemberName($accountId);
            foreach($IndividualnameFetch as $IndividualnameFetch1) {
                    $this->view->memberfirstname=$IndividualnameFetch1['memberfirstname'];
            }

            $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
            $this->view->recurringPaidDetails = $recurringPaidDetails;
            $paidAmount=0;
            foreach($recurringPaidDetails as $recurringPaidDetailss) {
                    $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
            }
            $this->view->paidAmount=$paidAmount;
// 
//                 $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
//                 $this->view->groupNamesSearch = $groupNamesSearchFetch;
//                         foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//                                 $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//                                 $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//                                 $accountNumber=$groupNamesSearchFetch1['account_number'];
//                         }
// 
//                 if($this->view->groupname) {
//                         $groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//                         $this->view->groupMembersDetails=$groupMembersDetails;
//                 }
// 
            $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);
            $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
            $begindate=0;$mature_date=0;
            foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
                    $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
                    $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
                    $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
                    $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
                    $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
            }

            $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
            $this->view->installmentsDetails = $installmentsDetailsFetch;
            foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
                $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
                $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
                $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
                $status=$installmentsDetailsFetch1['rec_payment_status'];
            }

            $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
            $this->view->recurringmemberbranchid = $recurringmemberbranchid;
            foreach($recurringmemberbranchid as $recurringmemberbranchids) {
                    $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['office_id'];
            }

            $currentdate=$date->toString('YYYY-MM-dd');
            $this->view->currentDate=$currentdate;
            $this->view->maturedate=$matureDate;
            $RateperMonth=$fixedInterest/12;
            $this->view->installmentNumber=$InstalmentNumber;
            $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
            $simpleInterest=round($simpleInterest,2);
            $this->view->simpleInterest=$simpleInterest;
            $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
            $this->view->matureAmount=$matureAmount;
            $InstalmentNumber=$noOfInstalmentPaid+1;
            if($InstalmentNumber==1) {
                $lastPaidDate=$begindate;
            } else  {
                $recurringInstalmentpayments=$recurringDetails->recurringInstalmentpayments($accountId,$InstalmentNumber);
                foreach($recurringInstalmentpayments as $recurringInstalmentpayments1) {
                    $lastPaidDate=$recurringInstalmentpayments1['rec_payment_date']; /*last instalment paid date*/
                }
            }
            $recurringForm=new Recurringtransaction_Form_recurringTransaction($amountTopay,$currentdate,$lastPaidDate);
            $this->view->recurringForm=$recurringForm;
            $this->view->recurringForm->accountId->setValue($accountId);
            $this->view->recurringForm->productId->setValue($productId);  /*setting the value of product id and account id in the form */
            if($this->view->manualRepayment=='yes' && $this->view->groupname) {
                $this->view->recurringForm->amount->setAttrib('readonly', 'true');
                $this->view->recurringForm->amount->setAttrib('class', 'textfieldreadonly');
                foreach($this->view->groupMembersDetails as $arrayroles1)  {
                    $a='amount'.$arrayroles1['member_id'];
                    $this->view->recurringForm->addElement(new Zend_Form_Element_Text($a));
                    $this->view->recurringForm->$a->setAttrib('class', 'txt txt_put');
                    $this->view->recurringForm->$a->setAttrib('onchange', 'totalAmount(this.value)');
                    $this->view->recurringForm->$a->addValidators(array(array('Digits')));
                }
            }
            $recurringForm=$this->view->recurringForm;

            $due=$this->view->dueAmount=0;
            $accountnextinstallmentdate=$recurringDetails->nextinstallmentdate($accountId);
//             echo "<pre>"; print_r($accountnextinstallmentdate);  
            $count=0;
            foreach($accountnextinstallmentdate as $accountnextinstallmentdates) {
                $count++;
                $nextinstallmentdate=$accountnextinstallmentdates['rec_payment_date'];
                $accountinstallment_date1=$nextinstallmentdate;
//                 $InstalmentNumber=$accountnextinstallmentdates['rec_payment_id'];
               if($count==1){
                 $InstalmentNumber1=$accountnextinstallmentdates['rec_payment_id'];}
                                 $InstalmentNumber=$accountnextinstallmentdates['rec_payment_id'];
                $this->view->dueAmount=$this->view->dueAmount+$accountnextinstallmentdates['rec_payment_amount'];
                $due=$this->view->dueAmount;

                $systemDate= $date->get(Zend_Date::DATES);
                $date->set($nextinstallmentdate,Zend_Date::DATES);
                $nextinstallmentdate=$date->get($nextinstallmentdate,Zend_Date::DATES);

                $date->set($systemDate,Zend_Date::DATES);

                if (($date->isLater($nextinstallmentdate, Zend_Date::DATES))) {
                    $systemDate= $date->get(Zend_Date::DATES);

                    $installmentDate = new Zend_Date($nextinstallmentdate, Zend_Date::DATES);
                    $accountnextdueinstallmentdate=$installmentDate->toString('YYYY-MM-dd');

                    $systemDate = new Zend_Date($systemDate, Zend_Date::DATES);
                    $presentdatedate=$systemDate->toString('YYYY-MM-dd');

                    $date_parts1=explode("-",$accountnextdueinstallmentdate );
                    $date_parts2=explode("-",$presentdatedate);
                    $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
                    $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
                    $noOfDays= $end_date - $start_date;

                    if($noOfDays >= 1) {
                        $fineAmount = $recurringDetails->getDelayFine();
                        foreach($fineAmount as $fineData) {
                            $DelayFine = $fineData['feevalue'];
                        }
                        if($due) {
                            $amount = (($due * $DelayFine)/100)*$noOfDays;
                            $amountDisplayed = $amount + $due ;
                            $this->view->dueAmount = round($amountDisplayed,2);
                        } else {
                            $amount = 0;
                        }
                    }	 

                    $installmentStatus='5';
                    $statusOverdue=$recurringDetails->instalmentStatus($accountId,$InstalmentNumber,$installmentStatus);
                    if (($date->isLater($accountinstallment_date1, Zend_Date::DATES))) {
                        $this->view->recurringForm->addElement(new Zend_Form_Element_Text('fine'));
                        $this->view->recurringForm->fine->setAttrib('class', 'textfield');
                        $this->view->recurringForm->fine->setRequired(true);
                        if($amount) {
                            $this->view->recurringForm->fine->setValue($amount);
                        }
                        $this->view->recurringForm->fine->setAttrib('readonly', 'true');
                        $this->view->recurringForm->fine->addValidators(array(array('Float'),
                                array('GreaterThan',false,array('1','messages' => array('notGreaterThan' => 'Min=1Rs')))));
                    }
                }
            }

            $paymentModeDetails = $recurringDetails->fetchAllPaymentMode();
            foreach ($paymentModeDetails as $paymenttype1){
                $recurringForm->transactionMode->addMultiOption($paymenttype1['id'],$paymenttype1['description']);
            }

            if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                $formData = $this->_request->getPost();
                $transactionMode=$this->view->transactionMode=$this->_request->getParam('transactionMode');
                if( $transactionMode ==1 || $transactionMode ==""  ) {
                        $recurringForm->paymenttype_details->setRequired(false);
                }
                if ($recurringForm->isValid($formData)) {
                    $paidAmounts=$this->view->depositamount=$this->_request->getParam('amount');
                    $recurringPaidDate=$this->view->recurringDate=$this->_request->getParam('recurringDate');
                    $transactionModeDetails =$this->view->paymenttype_details=$this->_request->getParam('paymenttype_details');

                    if($this->_request->getParam('fine')) {
                        $fine=$this->view->fine=$this->_request->getParam('fine');
                        $this->view->recurringForm->fine1->setValue($this->_request->getPost('fine'));
                    } else {
                        $fine=$this->view->fine=0;
                    }

                    $this->view->recurringForm->recurringDate1->setValue($this->_request->getPost('recurringDate'));
                    $this->view->recurringForm->amounts1->setValue($this->_request->getPost('amount'));
                    $this->view->recurringForm->transactionMode1->setValue($this->_request->getPost('transactionMode'));
                    $this->view->recurringForm->paymenttype_details1->setValue($this->_request->getPost('paymenttype_details'));

                    $transaction_mode =$savingsDetails->gettransactionmode($transactionMode);
                    foreach($transaction_mode as $transaction_modes) {
                        $this->view->transactionModetype=$transaction_modes['description'];
                    }
                    $this->view->Submit="Confirm";
                }
            }

            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                $transactionMode=$this->_request->getParam('transactionMode1');
                $sessionName = new Zend_Session_Namespace('ourbank');
                $user_id = $sessionName->primaryuserid;
                $paidAmounts=$this->_request->getParam('amounts1');
                $recurringPaidDate=$this->_request->getParam('recurringDate1');
                $transactionModeDetails = $this->_request->getParam('paymenttype_details1');
                if($this->_request->getParam('fine1')) {
                        $fine=$this->_request->getParam('fine1');
                } else {
                        $fine=0;
                }

                $data = array('rec_payment_status' =>2);
                $recurringDetails->paymentUpdates($InstalmentNumber1,$accountId,$data);
                $transactionData= array(
                                        'account_id' => $accountId,
                                        'glsubcode_id_from' => '',
                                        'glsubcode_id_to' => $glsubcode,
                                        'transaction_date'=>$recurringPaidDate,
                                        'amount_to_bank'=>$paidAmounts,
                                        'amount_from_bank'=>'',
                                        'paymenttype_id'=>$transactionMode,
                                        'paymenttype_details'=>$transactionModeDetails,
                                        'recordstatus_id'=>'3',
                                        'reffering_vouchernumber'=>'',
                                        'transaction_description'=>'' ,
                                        'balance'=>0,
                                        'confirmation_flag'=>0,
                                        'created_by'=> 1,
                                        'created_date'=>date("Y-m-d"));
                /*inserting a information to main transaction table*/
                $transaction_id=$fixedSavings->transactionInsert($transactionData);
                $data = array('rec_paymentserial_id'=>'',
                                    'transaction_id'=>$transaction_id,
                                    'account_id' => $accountId,
                                    'rec_payment_number'=>$InstalmentNumber,
                                    'rec_paymentpaid_date' => $recurringPaidDate,
                                    'rec_paid_amount' => $paidAmounts,
                                    'rec_paid_interst'=>$fine,
                                    'recordstatus_id'=>'3');
                    /*insertion to Recurring ourbank_recurring_payment table*/
                $groupmembertransaction_id=$recurringDetails->recurringPaymentInsertion($data);
// 
//                     $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                     if($this->view->groupname) {
//                         if($this->view->manualRepayment=='no') {
//                             $individualamount=$paidAmounts/$noOfMemberinAccount;
//                         }
//                         foreach($this->view->groupMembersDetails as $eachMember) {
//                             if($this->view->manualRepayment=='yes') {
//                                 $am='amount'.$eachMember->member_id;
//                                 $individualamount=$this->_request->getParam($am);
//                             }
//                             $data = array('groupmemberrecurringtransaction_id'=>'',
//                                         'groupmembertransaction_id'=>$groupmembertransaction_id,
//                                         'groupaccount_id' => $accountId,
//                                         'groupmemberaccount_id'=>$eachMember['membercode'],
//                                         'groupmembertransaction_date'=>$recurringPaidDate,
//                                         'groupmembertransaction_type' => $transactionMode,
//                                         'groupmembertransaction_amount' => $individualamount,
//                                         'groupmembertransaction_interest'=>'',
//                                         'groupmembertransaction_by'=>$user_id);
//                             $insert=$recurringDetails->grouprecurringInsert($data);
//                         }
//                     }
// 
                $transactions=new Recurringtransaction_Model_persnolSavings();

                $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from'=> '',
                                                'glsubcode_id_to'=>$glsubcode,
                                                'transaction_id'=>$transaction_id,
                                                'credit'=>$paidAmounts,
                                                'debit' => '',
                                                'record_status'=>'3'));
                $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                if($transactionMode=='1') {
                    $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                    foreach($selectbankcashaccounts as $selectbankcashaccount) {
                        $bankcashglsubcode=$selectbankcashaccount['id'];
                    }

                    $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                            'glsubcode_id_from'=> '',
                                            'glsubcode_id_to'=>  $bankcashglsubcode,
                                            'transaction_id'=>$transaction_id,
                                            'credit'=>$paidAmounts,
                                            'debit' => '',
                                            'record_status'=>'3'));
                    $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                }
                else {
                    $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                    foreach($selectbankaccounts as $selectbankaccount) {
                        $bankglsubcode=$selectbankaccount['id'];
                    }

                    $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                            'glsubcode_id_from'=> '',
                                            'glsubcode_id_to'=> $bankglsubcode,
                                            'transaction_id'=>$transaction_id,
                                            'credit'=>$paidAmounts,
                                            'debit' => '',
                                            'record_status'=>'3'));
                    $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                }

                if($fine) {
                    $bankincomeaccountinsert = (array('office_id' => $memberbranch_id,
                                            'glsubcode_id_from'=> '',
                                            'glsubcode_id_to'=> $bankglsubcode,
                                            'transaction_id'=>$transaction_id,
                                            'credit'=>$fine,
                                            'debit' => '',
                                            'record_status'=>'3'));
                    $bankincomeaccounts=$transactions->insertbankincomeaccounts($bankincomeaccountinsert);
                }

                $this->_redirect('recurringtransaction/index/recurring/accountId/'.base64_encode($accountId).'/productId/'.base64_encode($productId));
                }
        }
/*End of Deposit The Recurring amount Block*/

        function interestsAction() 
        {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if(!$data){
                        $this->_redirect('index/login');
                }

                $this->_helper->layout->disableLayout();
                $interests = new Recurringtransaction_Model_fixedSavings();
                $productId = $this->_request->getParam('productId');
                $country = $this->_request->getParam('country');
                $this->view->selectedInterest=$interests->interestFromUrl($productId,$country);
        }


/*Function To Renewal or New Recurring account with old payments and account Close*/
        function newaccountAction()
        {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if(!$data){
                        $this->_redirect('index/login');
                }

                $app = $this->view->baseUrl();
                $recurringDetails=new Recurringtransaction_Model_recurringSavings();
                $fixedSavings = new Recurringtransaction_Model_fixedSavings();
                $savingsDetails=new Recurringtransaction_Model_persnolSavings();

                if ($this->_request->getPost('Submit') || $this->_request->getPost('Confirm')) { /*if the information is Posted*/
                        $accountId=$this->_request->getPost('accountId');
                        $productId=$this->_request->getPost('productId');
                        $matured=$this->_request->getPost('matured');
                        $capital=$this->_request->getPost('capital');
                } else {
                        /*if the information is from url*/
                        $accountId=base64_decode($this->_request->getParam('accountId'));
                        $matured=base64_decode($this->_request->getParam('matured'));
                        $productId=base64_decode($this->_request->getParam('productId'));
                        $capital=base64_decode($this->_request->getParam('capital'));
                }
                $this->view->accountid=$accountId;
                $this->view->productid=$productId;

                $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
                $this->view->recurringPaidDetails = $recurringPaidDetails;
                $paidAmount=0;
                foreach($recurringPaidDetails as $recurringPaidDetailss) {
                        $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
                }
                $this->view->paidAmount=$paidAmount;

                $IndividualnameFetch = $recurringDetails->fetchMemberName($accountId);
                foreach($IndividualnameFetch as $IndividualnameFetch1) {
                        $this->view->memberfirstname=$IndividualnameFetch1['memberfirstname'];
                }
//                 $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
//                 $this->view->groupNamesSearch = $groupNamesSearchFetch;
//                         foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//                                 $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//                                 $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//                                 $accountNumber=$groupNamesSearchFetch1['account_number'];
//                         }
// 
                $noOfInstalmentPaid1=$recurringDetails->noOfInstalmentPaid($accountId);
                $noOfInstalmentPaid=count($noOfInstalmentPaid1);
                $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
                $this->view->rec_principal_amount=0;
                foreach($noOfInstalmentPaid1 as $loanInstalmentDetails1) {
                        $this->view->rec_principal_amount=$this->view->rec_principal_amount+$loanInstalmentDetails1['rec_payment_amount'];
                }

                $numberofinstallments=$recurringDetails->TotalnoOfInstalmentPaid($accountId);
                $totalnumberofinstallments=count($numberofinstallments);
                $this->view->TotalnoOfInstalmentPaid=$totalnumberofinstallments;

                $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);
                $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
                $begindate=0;$mature_date=0;
                foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
                        $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
                        $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
                        $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
                        $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
                        $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
                }

                $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
                $this->view->installmentsDetails = $installmentsDetailsFetch;
                foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
                        $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
                        $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
                        $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
                        $status=$installmentsDetailsFetch1['rec_payment_status'];
                }

                $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
                $this->view->recurringmemberbranchid = $recurringmemberbranchid;
                foreach($recurringmemberbranchid as $recurringmemberbranchids) {
                        $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['office_id'];
                }

                $RateperMonth=$fixedInterest/12;
                $this->view->installmentNumber=$InstalmentNumber;
                $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
                $simpleInterest=round($simpleInterest,2);
                $this->view->simpleInterest=$simpleInterest;
                $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
                $this->view->matureAmount=$matureAmount;
                $InstalmentNumber=$noOfInstalmentPaid+1;
                if($InstalmentNumber==1) {
                        $lastPaidDate=$begindate;
                } else  {
                        $recurringInstalmentpayments=$recurringDetails->recurringInstalmentpayments($accountId,$InstalmentNumber);
                        foreach($recurringInstalmentpayments as $recurringInstalmentpayments1) {
                                $lastPaidDate=$recurringInstalmentpayments1['rec_payment_date']; /*last instalment paid date*/
                        }
                }

                $recurringProductDetails=$recurringDetails->recurringProductDetails($accountId,$productId);
                foreach($recurringProductDetails as $recurringProductDetails1) {
                        $recurringBeginDate=$this->view->begindate=$recurringProductDetails1['begindate'];
                        $recurringClosedDate=$this->view->closedate=$recurringProductDetails1['closedate'];
                        $recurringMinAmount=$this->view->minimum_deposit_amount=$recurringProductDetails1['minimum_deposit_amount'];
                        $recurringMaxAmount=$this->view->maximum_deposit_amount=$recurringProductDetails1['maximum_deposit_amount'];
                        $memberId=$this->view->member_id=$recurringProductDetails1['member_id'];
                        $membertypeId= $this->view->membertypr_id=$recurringAccountDetailsFetch1['membertype_id'];
                }

                if($this->view->groupname) {
                        $groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
                        $this->view->groupMembersDetails=$groupMembersDetails;
                }


                $RecurringAccountForm = new Recurringtransaction_Form_RecurringAccount($recurringBeginDate,$recurringClosedDate,$recurringMinAmount,$recurringMaxAmount,$app); 
                $this->view->form2 = $RecurringAccountForm; /*To view the recurring account creation Form  */
                $this->view->form2->accountId->setValue($accountId);
                $this->view->form2->productId->setValue($productId);  /*setting values*/
                $this->view->form2->member_id->setValue($memberId);  /*setting values*/
                if($matured){
                        $this->view->form2->recurringamount->setValue($matured);  /*setting values*/
                } else {
                        $this->view->form2->recurringamount->setValue($capital);  /*setting values*/
                }

                $interestperiodsa =$recurringDetails->interestperiods($productId);
                for($i=1;$i<=$interestperiodsa;$i++) {
                        $RecurringAccountForm->perioddescription->addMultiOption($i,$i);
                }

                if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                    $formData = $this->_request->getPost();
                    if ($RecurringAccountForm->isValid($formData)) {
                        $recurringInterest= $this->_request->getParam('interest');
                        if($recurringInterest) {
                            $accountOpeningDate= $this->view->startdate=$this->_request->getParam('startdate'); 
                            $recurringAmount= $this->view->recurringamount=$this->_request->getParam('recurringamount');
                            $periodDescription= $this->view->perioddescription=$this->_request->getParam('perioddescription');
                            $recurringInterest= $this->view->interest=$this->_request->getParam('interest');
                            $this->view->form2->startdate1->setValue($this->_request->getPost('startdate'));
                            $this->view->form2->recurringamount1->setValue($this->_request->getPost('recurringamount'));
                            $this->view->form2->perioddescription1->setValue($this->_request->getPost('perioddescription'));
                            $this->view->form2->interest1->setValue($this->_request->getPost('interest'));
                            $this->view->Submit = 'Confirm';
                        } else { 
                                $this->view->Perioderror="please select the Periods again...."; 
                        }
                    } else {
                            $RecurringAccountForm->perioddescription->setvalue('');
                    }

                }

                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                    $sessionName = new Zend_Session_Namespace('ourbank');
                    $userId = $sessionName->primaryuserid;
                    $recurringInterest= $this->_request->getParam('interest1');

                    $status= $this->_request->getParam('accountId');
                    $memberId= $this->_request->getParam('member_id');

                    $lastaccountinsertedId = $fixedSavings->insertAccount(array('id' => ''));
                    $arrayroles = $fixedSavings->accountnumber($memberId);
                    foreach($arrayroles as $transaction) {
                            $groupofficeId=$this->view->memberbranch_id=$transaction['office_id'];
                    }
                    $product_id1 = 'R'; //savings account short form s
                    if($this->view->membertypr_id=='2') {
                            $grouporIndividualNumber=2; 
                    } else { 
                            $grouporIndividualNumber=1;
                    }

                    $b=str_pad($groupofficeId,3,"0",STR_PAD_LEFT);
                    $t=str_pad($grouporIndividualNumber,2,"0",STR_PAD_LEFT);
                    $p=str_pad($product_id1,3,"0",STR_PAD_LEFT);
                    $a=str_pad($lastaccountinsertedId,6,"0",STR_PAD_LEFT);
                    $accountOpeningDate= $this->_request->getParam('startdate1'); 
                    $accountNumber=$b.$t.$p.$a;
                    $accountUpdate = array('account_number' =>$accountNumber,
                                            'member_id' => $memberId,
                                            'product_id' =>$productId,
                                            'membertype_id' =>$membertypeId,
                                            'created_by'=>$userId,
                                            'created_date' =>$accountOpeningDate,
                                            'status_id'=>1);
                    $fixedSavings->updateRow($lastaccountinsertedId,$accountUpdate); 

                    $recurringAmount= $this->_request->getParam('recurringamount1');
                    $periodDescription= $this->_request->getParam('perioddescription1');
                    $recurringInterest= $this->_request->getParam('interest1');

                    $mature = new Zend_Date();
                    $mature->set($accountOpeningDate,Zend_Date::DATES);
                    $mature->add($periodDescription, Zend_Date::MONTH);
                    $matureDates= $mature->toString("YYY-MM-dd");
                    $systems=date("y/m/d H:i:s");
                    $ourbankRecurringInsertion = $recurringDetails->ourbankRecurringInsertion(array('recurringaccount_id' => '',
                                    'account_id' => $lastaccountinsertedId,
                                    'mature_date'=>$matureDates,
                                    'begin_date' => $accountOpeningDate,
                                    'recurring_amount' =>$recurringAmount,
                                    'timefrequncy_id' =>'',
                                    'fixed_interest' =>$recurringInterest,
                                    'premature_interest' => '',
                                    'fixedaccountstatus_id'=>1,
                                    'created_date'=>$systems,
                                    'created_by'=>$userId));
// 
//                         if($this->view->membertypr_id=='3') {
//                                 $updategroupaccount = array('groupmember_account_status' =>5);
//                                 $fixedSavings->updategroupaccountnumber($accountId,$updategroupaccount);
//                                 if($this->view->groupname) {
//                                         foreach($this->view->groupMembersDetails as $eachMember) {
//                                                 $recurringDetails->groupAccountInsertion(array('groupmemberaccount_id' => '',
//                                                 'groupaccount_id' =>$lastaccountinsertedId,
//                                                 'groupmember_id' =>$eachMember['groupmember_id'],
//                                                 'product_id' => $productId,
//                                                 'groupmember_account_status' =>1,
//                                                 'groupcreateddate'=>$systems,
//                                                 'groupcreatedby'=>$userId));
//                                         }
//                                 }
//                         }
// 
                    $installments = new Zend_Date();
                    $installments->set($accountOpeningDate,Zend_Date::DATES);
                    for($i=1;$i<=($periodDescription);$i++) {
                            if($i==1) { 
                                    $paid=2; 
                            } elseif($i==2) {
                                    $paid=4;
                            } else { 
                                    $paid=3;
                            }
                            $installments->add(1, Zend_Date::MONTH);
                            $installmentDetailsDates= $installments->toString("YYY-MM-dd");
                            $ourbankRecurringInstallmentsInsertion = 	$recurringDetails->ourbankRecurringInstalmentsInsertion(array(
                                    'paymentserial_id' => '',
                                    'rec_payment_id'=>$i,
                                    'rec_payment_date' =>$installmentDetailsDates,
                                    'account_id' => $lastaccountinsertedId,
                                    'rec_payment_amount' =>$recurringAmount,
                                    'rec_payment_penalty_amount' => '',
                                    'rec_principal_amount' => '',
                                    'rec_payment_status' => $paid,
                                    'created_by'=>$userId,
                                    'created_date'=>$systems,
                                    'recordstatus_id'=>'3'));
                    }
                    $transactionData= array(
                                    'account_id' => $lastaccountinsertedId,
                                    'glsubcode_id_from'=> '',
                                    'glsubcode_id_to'=>$glsubcode,
                                    'transaction_date'=>$accountOpeningDate,
                                    'amount_to_bank' => $recurringAmount,
                                    'amount_from_bank' => '',

                                    'paymenttype_id'=>1,
                                    'paymenttype_details'=>'',
                                    'transactiontype_id'=>'1',
                                    'recordstatus_id'=>'3',
                                    'reffering_vouchernumber' => '',
                                    'transaction_description'=>'',
                                    'balance' => '',
                                    'confirmation_flag' => 0,
                                    'created_by'=>$userId,
                                    'created_date'=>date("Y-m-d"));
                    /*inserting a information to main transaction table*/
                    $transaction_id=$fixedSavings->transactionInsert($transactionData);

                        $data = array('rec_paymentserial_id'=>'',
                                        'transaction_id'=>$transaction_id,
                                        'account_id' => $lastaccountinsertedId,
                                        'rec_payment_number'=>1,
                                        'rec_paymentpaid_date' => $accountOpeningDate,
                                        'rec_paid_amount' => $recurringAmount,
                                        'rec_paid_interst'=>'',
                                        'rec_paid_other_amount' => '',
                                        'recordstatus_id' => 3);
                        /*insertion to Recurring ourbank_recurring_payment table*/
                        $groupmembertransaction_id=$recurringDetails->recurringPaymentInsertion($data);
// 
//                         $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                         if($this->view->groupname) {
//                                 $individualamount=$recurringAmount/$noOfMemberinAccount;
//                                 foreach($this->view->groupMembersDetails as $eachMember) {
//                                         $data = array('groupmemberrecurringtransaction_id'=>'',
//                                                 'groupmembertransaction_id'=>$transaction_id,
//                                                 'groupaccount_id' => $lastaccountinsertedId,
//                                                 'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                 'groupmembertransaction_date'=>date("Y-m-d"),
//                                                 'groupmembertransaction_type' => '10',
//                                                 'groupmembertransaction_amount' => $individualamount,
//                                                 'groupmembertransaction_interest'=>'',
//                                                 'groupmembertransaction_by'=>$user_id);
//                                         $insert=$recurringDetails->grouprecurringInsert($data);
//                                 }
//                         }
// 
                        $transactions=new Recurringtransaction_Model_persnolSavings();

                $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from'=>'',
                                                'glsubcode_id_to'=>$glsubcode,
                                                'transaction_id'=>$transaction_id,
                                                'credit'=>$recurringAmount,
                                                'debit' => '',
                                                'record_status'=>'3'));
                $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                    foreach($selectbankaccounts as $selectbankaccount) {
                        $bankglsubcode=$selectbankaccount['id'];
                    }


                $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from'=>'',
                                                'glsubcode_id_to'=> $bankglsubcode,
                                                'transaction_id'=>$transaction_id,
                                                'credit'=>$recurringAmount,
                                                'debit' => '',
                                                'record_status'=>'3'));
                $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);


                        $transactionData= array(
                                        'account_id' => $accountId,
                                        'glsubcode_id_from'=> '',

                                        'glsubcode_id_to'=>$glsubcode,
                                        'transaction_date'=>date("Y-m-d"),
                                        'amount_to_bank' => '',
                                        'amount_from_bank' => $recurringAmount,
                                        'paymenttype_id'=>1,
                                        'paymenttype_details'=>'',
                                        'transactiontype_id'=>'2',
                                        'recordstatus_id'=>'3',
                                        'reffering_vouchernumber' => '',
                                        'transaction_description' => '',
                                        'balance' => '',
                                        'confirmation_flag' => 0,
                                        'created_by'=>$userId,
                                        'created_date'=>date("Y-m-d"));
                        /*inserting a information to main transaction table*/
                        $transaction_id1=$fixedSavings->transactionInsert($transactionData);

                        $data = array('rec_paymentserial_id'=>'',
                                        'transaction_id'=>$transaction_id1,
                                        'account_id' => $accountId,
                                        'rec_payment_number'=>1,
                                        'rec_paymentpaid_date' =>date("Y-m-d"),
                                        'rec_paid_amount' => $recurringAmount,
                                        'rec_paid_interst'=>'',
                                        'rec_paid_other_amount' =>'',
                                        'recordstatus_id'=>'3');
                        /*insertion to Recurring ourbank_recurring_payment table*/
                        $groupmembertransaction_id=$recurringDetails->recurringPaymentInsertion($data);
// 
//                         $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                         if($this->view->groupname) {
//                                 $individualamount=$recurringAmount/$noOfMemberinAccount;
//                                 foreach($this->view->groupMembersDetails as $eachMember) {
//                                         $data = array('groupmemberrecurringtransaction_id'=>'',
//                                                                                 'groupmembertransaction_id'=>$transaction_id1,
//                                                                                 'groupaccount_id' => $accountId,
//                                                                                 'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                                                 'groupmembertransaction_date'=>date("Y-m-d"),
//                                                                                 'groupmembertransaction_type' => '2',
//                                                                                 'groupmembertransaction_amount' => $individualamount,
//                                                                                 'groupmembertransaction_interest'=>'',
//                                                                                 'groupmembertransaction_by'=>$user_id);
//                                         $insert=$recurringDetails->grouprecurringInsert($data);
//                                 }
//                         }
// 
                    $transactions=new Recurringtransaction_Model_persnolSavings();
                    $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from'=> '',
                                                'glsubcode_id_to'=>$glsubcode,
                                                'transaction_id'=>$transaction_id1,
                                                'credit'=>'',
                                                'debit' => $recurringAmount,
                                                'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                    foreach($selectbankaccounts as $selectbankaccount) {
                        $bankglsubcode=$selectbankaccount['id'];
                    }


                    $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from'=> '',
                                                    'glsubcode_id_to' => $bankglsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $recurringAmount,
                                                    'record_status'=>'3'));
                    $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);

                    $bankexpenditureaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from'=> '',
                                                    'glsubcode_id_to'=> $bankglsubcode,
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' =>$this->view->simpleInterest,
                                                    'record_status'=>'3'));

                    $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);

                    $recurringDetails->previousAccountClose($status);
                        $this->_redirect('recurringtransaction/index/index');
                }
        }

        function transferAction()
        {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data){
                    $this->_redirect('index/login');
            }

            $date = new Zend_Date();
            $recurringDetails=new Recurringtransaction_Model_recurringSavings();
            $fixedSavings = new Recurringtransaction_Model_fixedSavings();
            $savingsDetails=new Recurringtransaction_Model_persnolSavings();

            if ($this->_request->getPost('Transfer') || $this->_request->getPost('Confirm')) { /*if the data is Posted*/
                    $accountId=$this->_request->getPost('accountId');
                    $matured=$this->_request->getPost('matured');
                    $productId=$this->_request->getPost('productId');
            } else { /*if the data is from url*/
                     $accountId=base64_decode($this->_request->getParam('accountId'));echo "<pre>";
                     $matured=base64_decode($this->_request->getParam('matured'));echo "<pre>";
                     $productId=base64_decode($this->_request->getParam('productId'));echo "<pre>";
            }
            $this->view->accountid=$accountId;
            $this->view->productid=$productId;


            //validate for display ( deposit, renewal, status )
            $this->view->depositcheck1 = $recurringDetails->depositcheck($accountId);
            $this->view->statuscheck1 = $recurringDetails->statuscheck($accountId);

            $IndividualnameFetch = $recurringDetails->fetchMemberName($accountId);
            foreach($IndividualnameFetch as $IndividualnameFetch1) {
                    $this->view->memberfirstname=$IndividualnameFetch1['memberfirstname'];
            }

            $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
            $this->view->recurringPaidDetails = $recurringPaidDetails;
            $paidAmount=0;
            foreach($recurringPaidDetails as $recurringPaidDetailss) {
                    $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
            }
            $this->view->paidAmount=$paidAmount;

//                 $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
//                 $this->view->groupNamesSearch = $groupNamesSearchFetch;
//                         foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//                                 $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//                                 $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//                                 $accountNumber=$groupNamesSearchFetch1['account_number'];
//                         }

            $transferForm = new Recurringtransaction_Form_transferSearch(); 
            $this->view->transferForm = $transferForm; /*search form for Transfer the amount*/
            $this->view->transferForm->accountId->setValue($accountId);
            $this->view->transferForm->productId->setValue($productId);

            $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
            $this->view->installmentsDetails = $installmentsDetailsFetch;
            foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
                    $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
                    $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
                    $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
                    $status=$installmentsDetailsFetch1['rec_payment_status'];
            }

            $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);
            $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
            foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
                    $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
                    $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
                    $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
                    $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
                    $this->view->membertypr_id=$recurringAccountDetailsFetch1['membertype_id'];
                    $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
            }

            $noOfInstalmentPaid1=$recurringDetails->noOfInstalmentPaid($accountId);
            $noOfInstalmentPaid=count($noOfInstalmentPaid1);
            $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
            $this->view->rec_principal_amount=0;
            foreach($noOfInstalmentPaid1 as $loanInstalmentDetails1) {
                    $this->view->rec_principal_amount=$this->view->rec_principal_amount+$loanInstalmentDetails1['rec_payment_amount'];
            }

            $numberofinstallments=$recurringDetails->TotalnoOfInstalmentPaid($accountId);
            $totalnumberofinstallments=count($numberofinstallments);
            $this->view->TotalnoOfInstalmentPaid=$totalnumberofinstallments;


            $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
            $this->view->recurringmemberbranchid = $recurringmemberbranchid;
            foreach($recurringmemberbranchid as $recurringmemberbranchids) {
                    $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['office_id'];
            }
//                 if($this->view->groupname) {
//                         $groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//                         $this->view->groupMembersDetails=$groupMembersDetails;
//                 }

            $systemDate= $date->get(Zend_Date::DATES);/*system date*/
            $currentdate=$date->toString('YYYY-MM-dd');
            $this->view->currentDate=$currentdate;
            $this->view->maturedate=$matureDate;
            $RateperMonth=$fixedInterest/12;
            $this->view->installmentNumber=$InstalmentNumber;
            $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
            $capitalAmount=($amountTopay*$InstalmentNumber);
            $this->view->capitalAmount=$capitalAmount;	
            $simpleInterest=round($simpleInterest,2);
            $this->view->simpleInterest=$simpleInterest;
            $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
            $this->view->matureAmount=$matureAmount;
            $this->view->currentDate=$currentdate;
            $this->view->maturedate=$matureDate;

            $bankinterestamount=($fixedInterest/100)*($noOfInstalmentPaid/$totalnumberofinstallments)*($this->view->paidAmount);
            $totalamountpresent=$this->view->paidAmount+$bankinterestamount;
            $this->view->transferForm->matured->setValue($totalamountpresent);

            if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                $formData = $this->_request->getPost();
                if ($transferForm->isValid($formData)) {
                    $accountNumber = $this->view->account_number=$this->_request->getParam('account_number');
                    $maturedAmount= $this->view->matured=$this->_request->getParam('matured');

                    $this->view->transferForm->account_number1->setValue($this->_request->getPost('account_number'));
                    $this->view->transferForm->matured1->setValue($this->_request->getPost('matured'));

                    $savingsAccountsSearch = $fixedSavings->savingsAccountsSearch($accountNumber);
                    if (!$savingsAccountsSearch) {
                            $this->view->noaccounts="Invalid Savings Account Number Please Try Again";
                    } else {
                            $this->view->Submit="Confirm";
                    }
                }
            }

            if ($this->_request->isPost() && $this->_request->getPost('Transfer')) {
                    $sessionName = new Zend_Session_Namespace('ourbank');
                    $userId = $sessionName->primaryuserid;
                    $accountNumber = $this->_request->getParam('account_number1');
                    $maturedAmount= $this->_request->getParam('matured1');

                    $savingsAccountsSearch = $fixedSavings->savingsAccountsSearch($accountNumber);
                    $accountNumberSearch = $recurringDetails->accountNumberSearch($accountId);
                    foreach($accountNumberSearch as $accountNumberSearch1) {
                            $oldAccountNumber=$accountNumberSearch1['account_number'];
                    }
//                         $recurringDetails->previousAccountClose($accountId);
//                         $data2 = array('groupmember_account_status' =>'5');
//                         if($this->view->membertypr_id=='2') {
//                                 $fixedSavings->fixedgroupaccountaccountstatusChange($accountId,$data2);
//                         }
// 
//                         /*closing savings Recurring accounts For previous recurring account Created*/
                        foreach($savingsAccountsSearch as $savingsAccountsSearch1) {
                                $searchedAccountId=$savingsAccountsSearch1['id'];
                                $searchedAccountIdNumber=$savingsAccountsSearch1['account_number'];
                                $this->view->transferedmembertype_id=$savingsAccountsSearch1['membertype_id'];
                                $searchedglsubcode=$savingsAccountsSearch1['glsubcode_id'];
                        }

                        $savingsTransactiondata = (array(
                                        'account_id' => $searchedAccountId,
                                        'glsubcode_id_from' => '',
                                        'glsubcode_id_to' => $searchedglsubcode,
                                        'transaction_date'=>date("Y-m-d"),
                                        'amount_to_bank' => $maturedAmount,
                                        'amount_from_bank' => '',
                                        'paymenttype_id'=>1,
                                        'paymenttype_details'=>'',
                                        'transactiontype_id'=>1,
                                        'recordstatus_id'=>'3',
                                        'reffering_vouchernumber' => '',
                                        'transaction_description'=>'',
                                        'balance' => '',
                                        'confirmation_flag' => 0,
                                        'created_by'=>$userId,
                                        'created_date'=>date("Y-m-d")));
                        $transactionId=$fixedSavings->transactionInsert($savingsTransactiondata);

                        $savingsTransaction = (array('transaction_id'=>$transactionId,
                                        'account_id' => $searchedAccountId,
                                        'transaction_date'=>date("Y-m-d"),
                                        'transactiontype_id' =>1,
                                        'amount_from_bank' => '',
                                        'amount_to_bank' =>$maturedAmount,
                                        'paymenttype_id'=>1,
                                        'transaction_interest'=>'',
                                        'transaction_description'=>'',
                                        'paymenttype_details'=>'',
                                        'transaction_by'=> 1,
                                        'created_date'=>date("Y-m-d")));
                        $groupmembertransaction_id=$fixedSavings->insertpersnolsavingstransactionDetails($savingsTransaction);
// 
//                         if($this->view->transferedmembertype_id=='2') {
//                                 $groupNamesSavingsearchFetch = $recurringDetails->groupNamesSavingsearch($searchedAccountId);
//                                 $this->view->groupNamesSavingearch = $groupNamesSavingsearchFetch;
//                                 foreach($groupNamesSavingsearchFetch as $groupNamesSavingsearchFetch1) {
//                                         $this->view->groupname=$groupNamesSavingsearchFetch1['groupname'];
//                                         $groupid=$this->view->group_id=$groupNamesSavingsearchFetch1['group_id'];
//                                         $account_number=$groupNamesSavingsearchFetch1['account_number'];
//                                 }
// 
//                                 if($this->view->groupname) {
//                                         $this->view->groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($account_number,$groupid);
//                                 }
// 
//                                 $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                                 $individualamounts=$maturedAmount/$noOfMemberinAccount;
// 
//                                 if($this->view->groupname) {
//                                         foreach($this->view->groupMembersDetails as $eachMember) {
//                                                 $data = array('groupmembersavingtransaction_id'=>'',
//                                                         'groupmembertransaction_id'=>$transactionId,
//                                                         'groupaccount_id' => $searchedAccountId,
//                                                         'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                         'groupmembertransaction_date'=>date("Y-m-d"),
//                                                                                         'groupmembertransaction_type' =>1,
//                                                                                         'groupmembertransaction_amount' => $individualamounts,
//                                                                                         'groupmembertransaction_interest'=>'',
//                                                                                         'groupmembertransaction_by'=>$userId,
//                                         );
//                                         $insert=$fixedSavings->groupsavingsInsert($data);
//                                         }
//                                 }
//                         }
// 
                $transactions=new Recurringtransaction_Model_persnolSavings();

                $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from' => '',
                                                'glsubcode_id_to'=>$searchedglsubcode,
                                                'transaction_id'=>$transactionId,
                                                'credit'=>$this->view->paidAmount,
                                                'debit' => '',
                                                'record_status'=>'3'));
                $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                foreach($selectbankaccounts as $selectbankaccount) {
                    $bankglsubcode=$selectbankaccount['id'];
                }


                $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from' => '',
                                                'glsubcode_id_to'=> $bankglsubcode,
                                                'transaction_id'=>$transactionId,
                                                'credit'=>$this->view->paidAmount,
                                                'debit' => '',
                                                'record_status'=>'3'));
                $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);


                $transactionData= array(
                                'account_id' => $accountId,
                                'glsubcode_id_from' => '',
                                'glsubcode_id_to' => $glsubcode,
                                'transaction_date'=>date("Y-m-d"),
                                'amount_to_bank' => '',
                                'amount_from_bank' => $maturedAmount,

                                'paymenttype_id'=>'1',
                                'paymenttype_details'=>'',
                                'transactiontype_id'=>'2',
                                'recordstatus_id'=>'3',
                                'reffering_vouchernumber' => '',
                                'transaction_description'=>'',
                                'balance' => '',
                                'confirmation_flag' => 0,
                                'created_by'=> 1,
                                'created_date'=>date("Y-m-d"));
                        /*inserting a information to main transaction table*/
                $transaction_id1=$fixedSavings->transactionInsert($transactionData);

                        $data = array('rec_paymentserial_id'=>'',
                                'transaction_id'=>$transaction_id1,
                                'account_id' => $accountId,
                                'rec_payment_number'=>1,
                                'rec_paymentpaid_date' =>date("Y-m-d"),
                                'rec_paid_amount' => $maturedAmount,
                                'rec_paid_interst'=>'',
                                'rec_paid_other_amount'=>'',
                                'recordstatus_id'=>'3');
                        /*insertion to Recurring ourbank_recurring_payment table*/
                        $groupmembertransaction_id=$recurringDetails->recurringPaymentInsertion($data);

//                         $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                         if($this->view->groupname) {
//                                 $individualamount=$maturedAmount/$noOfMemberinAccount;
//                                 foreach($this->view->groupMembersDetails as $eachMember) {
//                                         $data = array('groupmemberrecurringtransaction_id'=>'',
//                                                                                         'groupmembertransaction_id'=>$transaction_id1,
//                                                                                         'groupaccount_id' => $accountId,
//                                                                                         'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                                                         'groupmembertransaction_date'=>date("Y-m-d"),
//                                                                                         'groupmembertransaction_type' => '2',
//                                                                                         'groupmembertransaction_amount' => $individualamount,
//                                                                                         'groupmembertransaction_interest'=>'',
//                                                                                         'groupmembertransaction_by'=>$userId);
//                                         $insert=$recurringDetails->grouprecurringInsert($data);
//                                 }
//                         }
// 
                $transactions=new Recurringtransaction_Model_persnolSavings();

                $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from'=> '',
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $this->view->paidAmount,
                                                    'record_status'=>'3'));
                $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                foreach($selectbankaccounts as $selectbankaccount) {
                    $bankglsubcode=$selectbankaccount['id'];
                }


                $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                'glsubcode_id_from'=> '',
                                                'glsubcode_id_to'=> $bankglsubcode,
                                                'transaction_id'=>$transaction_id1,
                                                'credit'=>'',
                                                'debit' => $this->view->paidAmount,
                                                'record_status'=>'3'));
                $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);


                $bankexpenditureaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from'=> '',
                                                    'glsubcode_id_to'=>  $bankglsubcode,
                                                    'tranasction_id'=> $transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $bankinterestamount,
                                                    'record_status'=>'3'));

                $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);

                $this->view->noaccount=$maturedAmount."Rs Has Been Transfered From Account   ".$oldAccountNumber."To Account".$searchedAccountIdNumber ;
                }
        }

        function statusAction()
        {
            $storage = new Zend_Auth_Storage_Session();
            $data = $storage->read();
            if(!$data){
                $this->_redirect('index/login');
            }

            $this->recurringAction();
            $date = new Zend_Date();
            if ($this->_request->getPost('Confirm') || $this->_request->getPost('Submit')) { /*if the data is Posted*/
                $accountId=$this->_request->getPost('accountId');
                $productId=$this->_request->getPost('productId');
            } else { /*if the data is from url*/
                $accountId=base64_decode($this->_request->getParam('accountId'));
                $productId=base64_decode($this->_request->getParam('productId'));
            }

            $this->view->accountid=$accountId;
            $this->view->productid=$productId;

            $fixedSavings = new Recurringtransaction_Model_fixedSavings();
            $savingsDetails=new Recurringtransaction_Model_persnolSavings();
            $recurringDetails=new Recurringtransaction_Model_recurringSavings();

//             validate display ( renewal, status, deposit)
            $this->view->depositcheck1 = $recurringDetails->depositcheck($accountId);
            $this->view->statuscheck1 = $recurringDetails->statuscheck($accountId);

            $recurringAccountDetailsFetch = $recurringDetails->recurringAccountDetails($accountId,$productId);
//             echo "<pre>"; print_r($recurringAccountDetailsFetch);
            $this->view->recurringAccountDetails = $recurringAccountDetailsFetch;
            foreach($recurringAccountDetailsFetch as $recurringAccountDetailsFetch1) {
                $begindate=$this->view->begin_date=$recurringAccountDetailsFetch1['begin_date'];
                $matureDate=$this->view->mature_date=$recurringAccountDetailsFetch1['mature_date'];
                $penalty=$this->view->penal_Interest=$recurringAccountDetailsFetch1['penal_Interest'];
                $fixedInterest=$this->view->fixed_interest=$recurringAccountDetailsFetch1['fixed_interest'];
                $this->view->membertypr_id=$recurringAccountDetailsFetch1['membertype_id'];
                $accountStatusId=$this->view->accountstatus_id=$recurringAccountDetailsFetch1['status_id'];
                $glsubcode=$recurringAccountDetailsFetch1['glsubcode_id'];
            }

            $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);
            foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
                    $memberid=$findmemberaccountsetails1['member_id'];
                    $membertypeid=$this->view->membertype_id=$findmemberaccountsetails1['membertype_id'];
                    $accountstatus=$findmemberaccountsetails1['status_id'];
            }

            $installmentsDetailsFetch = $recurringDetails->installmentsDetails($accountId,$productId);
            $this->view->installmentsDetails = $installmentsDetailsFetch;
            foreach($installmentsDetailsFetch as $installmentsDetailsFetch1) {
                $this->view->rec_payment_date=$installmentsDetailsFetch1['rec_payment_date'];
                $InstalmentNumber=$this->view->rec_payment_id=$installmentsDetailsFetch1['rec_payment_id'];
                $amountTopay=$installmentsDetailsFetch1['rec_payment_amount'];
                $status=$installmentsDetailsFetch1['rec_payment_status'];
            }

            $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
            $this->view->recurringmemberbranchid = $recurringmemberbranchid;
            foreach($recurringmemberbranchid as $recurringmemberbranchids) {
                    $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['office_id'];
            }
// 
//                 $recurringmemberbranchid = $recurringDetails->recurringmemberbranchid($accountId);
//                 $this->view->recurringmemberbranchid = $recurringmemberbranchid;
//                 foreach($recurringmemberbranchid as $recurringmemberbranchids) {
//                         $memberbranch_id=$this->view->memberbranch_id=$recurringmemberbranchids['memberbranch_id'];
//                 }
// 
//                 $noOfInstalmentPaid1=$recurringDetails->noOfInstalmentPaid($accountId);
//                 $noOfInstalmentPaid=count($noOfInstalmentPaid1); // echo $noOfInstalmentPaid;
// 
//                 $numberofinstallments=$recurringDetails->TotalnoOfInstalmentPaid($accountId);
//                 $totalnumberofinstallments=count($numberofinstallments);
// 
// 
                $recurringPaidDetails = $recurringDetails->recurringPaidDetails($accountId);
                $this->view->recurringPaidDetails = $recurringPaidDetails;
                $paidAmount=0;
                foreach($recurringPaidDetails as $recurringPaidDetailss) {
                        $paidAmount=$paidAmount+$recurringPaidDetailss['rec_paid_amount'];
                }
                $this->view->paidAmount=$paidAmount;

                $systemDate= $date->get(Zend_Date::DATES); /*system date*/
                $currentdate=$date->toString('YYYY-MM-dd');
                $this->view->currentDate=$currentdate;
                $this->view->maturedate=$matureDate;
                $RateperMonth=$fixedInterest/12;
                $this->view->installmentNumber=$InstalmentNumber;
                $simpleInterest=((($amountTopay*$InstalmentNumber)*$InstalmentNumber*$RateperMonth)/100);
                $capitalAmount=($amountTopay*$InstalmentNumber);
                $this->view->capitalAmount=$capitalAmount;	
                $simpleInterest=round($simpleInterest,2);
                $this->view->simpleInterest=$simpleInterest;


                $matureAmount=($amountTopay*$InstalmentNumber)+$simpleInterest;
                $this->view->matureAmount=$matureAmount;
// 
// 
                $findstatus=$fixedSavings->findstatus($accountStatusId);
                foreach($findstatus as $findstatus1) {
                        $status=$findstatus1['recordstatusdescription'];
                }
                $this->view->status=$status;
// 
// 
// 
                $RecurringstatusForm = new Recurringtransaction_Form_recurringstatus();
                $this->view->recurringstatus=$RecurringstatusForm;
                $this->view->recurringstatus->accountId->setValue($accountId);
                $this->view->recurringstatus->productId->setValue($productId); 

                $newstatus = $fixedSavings->fixedstatus($accountStatusId);
                foreach($newstatus as $newstatus) {
                        $RecurringstatusForm->newStatus->addMultiOption($newstatus['recordstatus_id'],$newstatus['recordstatusdescription']);
                }

                if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                    $formData = $this->_request->getPost();
                    if ($RecurringstatusForm->isValid($formData)) {
                        $status =$this->view->newStatus= $this->_request->getParam('newStatus');
                        $description =$this->view->description= $this->_request->getParam('description');

                        $this->view->recurringstatus->newStatus1->setValue($status);
                        $this->view->recurringstatus->description1->setValue($description);

                        $statusdetails =$savingsDetails->getrecordstatusdetails($status);
                        foreach($statusdetails as $statusdetailsinfo) {
                                $this->view->newrecordstatus=$statusdetailsinfo['recordstatusdescription'];
                        }
                        $this->view->Submit="Confirm";
                    }
                }

                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                    $status = $this->_request->getParam('newStatus1');
                    $description = $this->_request->getParam('description1');
                    $sessionName = new Zend_Session_Namespace('ourbank');
                    $userId = $sessionName->primaryuserid;

                    $data = array('status_id' =>$status,'Status_Description'=>$description);
                    $data1 = array('fixedaccountstatus_id'=>$status);
//                         $data2 = array('groupmember_account_status' =>$status);
                    $data3 = array('recordstatus_id' =>$status);
// 
                    $fixedSavings->accountstatusChange($accountId,$data);
                    $recurringDetails->recurringaccountstatusChange($accountId,$data1);
                    $recurringDetails->recurringpaydetailsChange($accountId,$data3);
//                         if($this->view->membertype_id=='2') {
//                                 $fixedSavings->fixedgroupaccountaccountstatusChange($accountId,$data2);
//                         }
// 
                    if($status=='4') {
                        $savingsTransactiondata1 = (array(
                                'account_id' => $accountId,
                                'glsubcode_id_from' => '',
                                'glsubcode_id_to' => $glsubcode,
                                'transaction_date'=>date("Y-m-d"),
                                'amount_to_bank' => '',
                                'amount_from_bank' => $this->view->paidAmount,
                                'paymenttype_id'=>1,
                                'paymenttype_details'=>'',
                                'transactiontype_id'=>2,
                                'recordstatus_id'=>3,
                                'reffering_vouchernumber' => '',
                                'transaction_description'=>$description,
                                'balance' => '',
                                'confirmation_flag' => 0,
                                'created_by'=>$userId,
                                'created_date'=>date("Y-m-d")
                        ));
                    $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);

                    $transactions=new Recurringtransaction_Model_persnolSavings();
                    $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $this->view->paidAmount,
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                    foreach($selectbankaccounts as $selectbankaccount) {
                        $bankglsubcode=$selectbankaccount['id'];
                    }

                    $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>$bankglsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $this->view->paidAmount,
                                                    'record_status'=>'3'));
                    $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);


                    $bankincomeaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>  $bankglsubcode,
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>$this->view->paidAmount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                    $bankincomeaccounts=$transactions->insertbankincomeaccounts($bankincomeaccountinsert);

                    $bankinterestamount=($fixedInterest/100)*($noOfInstalmentPaid/$totalnumberofinstallments)*($this->view->paidAmount);

                        $bankexpenditureaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=> $bankglsubcode,
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=> $bankinterestamount,
                                                    'debit' =>'',
                                                    'record_status'=>'3'));
                        $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);
                        }
                        $this->_redirect('recurringtransaction/index');
                }
        }
}
