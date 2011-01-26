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
class Fixedtransaction_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle='Fixed transaction';
        $this->view->type= 'fixed';
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

        $fixedDepositSavings = new Fixedtransaction_Form_Membersearch();
        $this->view->form = $fixedDepositSavings;
        $fixedSavings = new Fixedtransaction_Model_fixedSavings();

        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
            $formData = $this->_request->getPost();
                $formData = $this->_request->getPost();
                $membercode= $this->_request->getParam('member_id');

                if ($fixedDepositSavings->isValid($formData)) {
                    $arrayfixedAccountSearch = $fixedSavings->fixedAccountsSearch($membercode);
                    if (!$arrayfixedAccountSearch) {
                        $accountcode=$membercode;
                        $arrayfixedAccountSearch = $fixedSavings->fixedSearch($accountcode);
                        if (!$arrayfixedAccountSearch) {
                            echo "search Messages";
                        } else {
                            $this->view->fixedAccountsSearch = $arrayfixedAccountSearch;
                            foreach($arrayfixedAccountSearch as $arrayfixedAccountSearch1) {
                                $this->view->account_id=$arrayfixedAccountSearch1['account_id'];
                                $this->view->product_id=$arrayfixedAccountSearch1['product_id'];
                            }
                            $this->_redirect('fixedtransaction/index/fixed/accountId/'.base64_encode($this->view->account_id).'/productId/'.base64_encode($this->view->product_id));
                            }
                    }
                    else {
                        $this->view->fixedAccountsSearch = $arrayfixedAccountSearch;
                        foreach($arrayfixedAccountSearch as $arrayfixedAccountSearch1) {
                            $accountID=$this->view->account_id=$arrayfixedAccountSearch1['account_id'];
                            $accountNumber=$this->view->account_number=$arrayfixedAccountSearch1['account_number'];
                            $membercode=$this->view->membercode=$arrayfixedAccountSearch1['membercode'];
                            $this->view->membername=$arrayfixedAccountSearch1['membername'];
                            $membertypeId=$this->view->membertype_ID=$arrayfixedAccountSearch1['membertype_ID'];
                            $memberId=$this->view->member_id=$arrayfixedAccountSearch1['member_id'];
                            $offerproductname=$this->view->offerproductname=$arrayfixedAccountSearch1['offerproductname'];
                            $begin=$this->view->begin_date=$arrayfixedAccountSearch1['begin_date'];
                            $mature=$this->view->mature_date=$arrayfixedAccountSearch1['mature_date'];
                        }

//                         $groupNamesSearchFetch = $fixedSavings->groupNamesSearch($memberId);
//                         $this->view->groupNamesSearch = $groupNamesSearchFetch;
//                         foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
//                             $this->view->groupname=$groupNamesSearchFetch1['groupname'];
//                             $group_id=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
//                         }
                         $membertype=substr($membercode,4,1);
//                         echo $memberId;
                        $accountIDFetch = $fixedSavings->accountIDSearch($memberId,$membertype);
                        $this->view->accountIDFetch = $accountIDFetch;
                    }
                }
        }
    }

    function fixedAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $date = new Zend_Date();
        $systemDate= $date->get(Zend_Date::DATES);/*system date*/
        $fixedSavings = new Fixedtransaction_Model_fixedSavings();
        $savingsDetails=new Fixedtransaction_Model_persnolSavings();

        $accountId = base64_decode($this->_request->getParam('accountId'));
        $productId = base64_decode($this->_request->getParam('productId'));
        $memberid= base64_decode($this->_request->getParam('member_id'));
        $this->view->memberid=$memberid;
        $this->view->accountid=$accountId;
        $this->view->productid=$productId;

        $fixeddepositaccountdetails11=$fixedSavings->fixedAccountDetails($accountId);
        foreach($fixeddepositaccountdetails11 as $fixeddetails1) {
                $begindate=$this->view->begin_date=$fixeddetails1['begin_date'];
                $maturedate=$this->view->mature_date =$fixeddetails1['mature_date'];
                $fixedamount=$this->view->fixed_amount =$fixeddetails1['fixed_amount'];
                $fixedinterest=$this->view->fixed_interest =$fixeddetails1['fixed_interest'];
                $this->view->offerproductname=$fixeddetails1['offerproductname'];
                $this->view->accountnumber=$fixeddetails1['account_number'];
                $this->view->membername = $fixeddetails1['membername'];
                $penalinterest= $this->view->penalinterest=$fixeddetails1['penal_Interest'];
                $this->view->membertype_id=$fixeddetails1['membertype_id'];
                $this->view->status_id=$fixeddetails1['status_id'];
                $memberbranch_id=$fixeddetails1['office_id'];
        }
        $currentdate=$this->view->currentdate=date('Y-m-d');

        $day = 86400; // Day in seconds
        $format = 'Y-m-d'; // Output format (see PHP date funciton)
        $sTime = strtotime($begindate); // Start as time
        $eTime = strtotime($maturedate); // End as time
        $numDays = round(($eTime - $sTime) / $day) + 1;
// Calculation = (2/100)*(91/365)*6000

        $interestamt = ($fixedinterest/100)*(abs($numDays)/365)*$fixedamount;
        $this->view->interestamount=$interestamt;
        $maturedamount = $fixedamount + $interestamt;
        $this->view->Totalamount=$maturedamount;

//         if($currentdate>=$maturedate) {
//                 $matureinterest=(((($diffY*12)+($diffM))*$fisedfinalinterest*$fixedamount)/100);
//                 $this->view->interestamountfrombank=$matureinterest;
//                 $maturedinterest=$matureinterest+$fixedamount;
//                 $this->view->maturedinterestamount=$maturedinterest;
//         } else  {
//                 $fisedfinalinterest=($fixedinterest/12);
//                 $this->view->maturedinterest=$fisedfinalinterest;
//                 $fisedfinalprematureinterest=($penalinterest/12);
//                 $this->view->prematuredinterest=$fisedfinalprematureinterest;
//                 $matureinterest=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalinterest*$fixedamount)/100);
//                 $maturedinterest1=$matureinterest+$fixedamount;
//                 $prematureamount=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalprematureinterest*$fixedamount)/100);
//                 $interestformbank=$matureinterest-$prematureamount;
//                 $this->view->interestamountfrombank=$interestformbank;
//                 $maturedinterest=$maturedinterest1-$prematureamount;
//                 $this->view->maturedinterestamount=$maturedinterest;
//         }
// 
        $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);
        foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
                $memberid=$findmemberaccountsetails1['member_id'];
                $membertypeid=$findmemberaccountsetails1['membertype_id'];
        }
// 
//         $offerproductdetails=$fixedSavings->offerproductdetails($productId);
//         foreach($offerproductdetails as $offerproductdetails1) {
//                 $begindate=$offerproductdetails1['begindate'];
//                 $closedate=$offerproductdetails1['closedate'];
//                 $minimum_deposit_amount=$offerproductdetails1['minimum_deposit_amount'];
//                 $maximum_deposit_amount=$offerproductdetails1['maximum_deposit_amount'];
// // 			$begindate=$offerproductdetails1->begindate;
//         }
// 
        $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
        $this->view->groupMembersDetails = $groupNamesSearchFetch;
        foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
            $this->view->groupname=$groupNamesSearchFetch1['groupname'];
            $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
            $accountNumber=$groupNamesSearchFetch1['account_number'];
        }

    }

    function interestsAction() 
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $this->_helper->layout->disableLayout();
        $fixedSavings = new Fixedtransaction_Model_fixedSavings();
        $productId = $this->_request->getParam('productId');
        $country = $this->_request->getParam('country');
        $this->view->selectedInterest=$fixedSavings->interestFromUrl($productId,$country);
    }

    function renewalAction()

    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $app = $this->view->baseUrl();
        $date = new Zend_Date();
        $systemDate= $date->get(Zend_Date::DATES);/*system date*/
        /*fetching member code*/
        if ($this->_request->isPost()) {
                /*if the information is Posted*/
        $accountId=$this->_request->getParam('accountId');
        $productId=$this->_request->getParam('productId');
        $memberId=$this->_request->getParam('memberId');
        } else {
                /*if the information is from url*/
        $accountId=base64_decode($this->_request->getParam('accountId'));
        $productId=base64_decode($this->_request->getParam('productId'));
        $memberId=base64_decode($this->_request->getParam('memberId'));
        }
        $this->view->accountid=$accountId;
        $this->view->productid=$productId;

        $fixedSavings = new Fixedtransaction_Model_fixedSavings();
        $savingsDetails=new Fixedtransaction_Model_persnolSavings();

        $fixeddepositaccountdetails11=$fixedSavings->fixedAccountDetails($accountId);
        foreach($fixeddepositaccountdetails11 as $fixeddetails1) {
                $begindate=$this->view->begin_date=$fixeddetails1['begin_date'];
                $maturedate=$this->view->mature_date =$fixeddetails1['mature_date'];
                $fixedamount=$this->view->fixed_amount =$fixeddetails1['fixed_amount'];
                $fixedinterest=$this->view->fixed_interest =$fixeddetails1['fixed_interest'];
                $this->view->offerproductname=$fixeddetails1['offerproductname'];
                $this->view->accountnumber=$fixeddetails1['account_number'];
                $penalinterest= $this->view->penalinterest=$fixeddetails1['penal_Interest'];
                $this->view->membertype_id=$fixeddetails1['membertype_id'];
                $memberbranch_id=$fixeddetails1['memberbranch_id'];
                $glsubcode=$fixeddetails1['glsubcode_id'];
        }
        $this->view->capitalAmount=$fixedamount;
        $currentdate=$date->toString('YYYY-MM-dd');
        $this->view->currentdate=$currentdate;
        $this->view->matureddate=$maturedate;

        $date->set($maturedate,Zend_Date::DATES);
        $maturedate=$date->get($maturedate,Zend_Date::DATES);
        $maturedatemonths=$date->toString(Zend_Date::MONTH_SHORT);
        $maturedateyear=$date->toString(Zend_Date::YEAR);
        $maturedatedays=$date->toString(Zend_Date::DAY_SHORT);

        $date->set($begindate,Zend_Date::DATES);
        $begindate=$date->get($begindate,Zend_Date::DATES);
        $begindatemonths=$date->toString(Zend_Date::MONTH_SHORT);
        $begindateyear=$date->toString(Zend_Date::YEAR);
        $begindatedays=$date->toString(Zend_Date::DAY_SHORT);

        $date->set($currentdate,Zend_Date::DATES);
        $currentdate=$date->get($currentdate,Zend_Date::DATES);
        $currentdatemonths=$date->toString(Zend_Date::DAY_SHORT);
        $currentdateyear=$date->toString(Zend_Date::YEAR);
        $currentdatedays=$date->toString(Zend_Date::MONTH_SHORT);

        $diffY=$maturedateyear-$begindateyear;
        $diffM=$maturedatemonths-$begindatemonths;
        $diffD=$maturedatedays-$begindatedays;

        $diffpreMY=$currentdateyear-$begindateyear;
        $diffpreMM=$currentdatemonths-$begindatemonths;
        $diffpreMD=$currentdatedays-$begindatedays;



        if($diffM<0) {
                $diffM=(-1*$diffM);
        }

        if($diffpreMM<0) {
                $diffpreMM=(-1*$diffpreMM);
        }

        $fisedfinalinterest=($fixedinterest/12);
        $this->view->maturedinterest=$fisedfinalinterest;
        $matureinterest=(((($diffY*12)+($diffM))*$fisedfinalinterest*$fixedamount)/100);
        $this->view->interestamount=$matureinterest;
        $maturedinterest=$matureinterest+$fixedamount;
        $this->view->Totalamount=$maturedinterest;

        if($currentdate>=$maturedate) {
                $matureinterest=(((($diffY*12)+($diffM))*$fisedfinalinterest*$fixedamount)/100);
                $this->view->interestamountfrombank=$matureinterest;
                $maturedinterest=$matureinterest+$fixedamount;
                $this->view->maturedinterestamount=$maturedinterest;
        } else  {
                $fisedfinalinterest=($fixedinterest/12);
                $this->view->maturedinterest=$fisedfinalinterest;
                $fisedfinalprematureinterest=($penalinterest/12);
                $this->view->prematuredinterest=$fisedfinalprematureinterest;
                $matureinterest=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalinterest*$fixedamount)/100);
                $this->view->interestamountfrombank=$matureinterest;
                $maturedinterest1=$matureinterest+$fixedamount;
                $prematureamount=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalprematureinterest*$maturedinterest1)/100);
                $this->view->prematureinterestamountfrombank=$prematureamount;
                $maturedinterest=$maturedinterest1-$prematureamount;
                $this->view->maturedinterestamount=$maturedinterest;
        }
        $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);
        foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
                $memberid=$findmemberaccountsetails1['member_id'];
                $membertypeid=$findmemberaccountsetails1['membertype_id'];
        }

        $offerproductdetails=$fixedSavings->offerproductdetails($productId);
        foreach($offerproductdetails as $offerproductdetails1) {
                $begindate=$offerproductdetails1['begindate'];
                $closedate=$offerproductdetails1['closedate'];
                $minimum_deposit_amount=$offerproductdetails1['minimum_deposit_amount'];
                $maximum_deposit_amount=$offerproductdetails1['maximum_deposit_amount'];
// 			$begindate=$offerproductdetails1->begindate;
        }
        $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
        $this->view->groupNamesSearch = $groupNamesSearchFetch;
                foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
                        $this->view->groupname=$groupNamesSearchFetch1['groupname'];
                        $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
                        $accountNumber=$groupNamesSearchFetch1['account_number'];
                }

        if($this->view->groupname) {
                $this->view->groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
        }

        $feessum = $fixedSavings->feeFetch();
        $this->view->fee=$feessum;
        $feetotal=0;
        foreach($feessum as $arrayroles1) {
                $feetotal=$feetotal+$arrayroles1['feevalue'];
                $fee=$arrayroles1['feevalue'];
                $feename=$arrayroles1['feename'];
        }
        $this->view->feeTotal=$feetotal;	

        $fixedReneval= New Transaction_Form_Reneval($begindate,$closedate,$minimum_deposit_amount,$maximum_deposit_amount,$app);
        $this->view->form2=$fixedReneval;
        $this->view->form2->accountId->setValue($accountId);
        $this->view->form2->productId->setValue($productId);
        $this->view->form2->memberId->setValue($memberid); 
        $this->view->form2->feeTotal->setValue($feetotal); 


        $this->view->form2->maturedintrestamount->setValue($this->view->maturedinterestamount);
        $this->view->form2->capitalamount->setValue($fixedamount);

        $select = $fixedSavings->fetchAll_paymenttype();
        foreach ($select as $paymenttype1){
                $fixedReneval->paymenttype->addMultiOption($paymenttype1['paymenttype_id'],$paymenttype1['paymenttype_description']);
        }

        $interestperiodsa =$fixedSavings->interestperiods($productId);
        for($i=1;$i<=$interestperiodsa;$i++) {
                $fixedReneval->perioddescription->addMultiOption($i,$i);
        }

        $matured = base64_decode($this->_request->getParam('matured'));
        $this->view->mature=$matured;
        $capital = base64_decode($this->_request->getParam('capital'));
        $this->view->capital=$capital;
        if($matured){
        $this->view->form2->recurringamount->setValue($matured);  /*setting values*/
        } else{
        $this->view->form2->recurringamount->setValue($capital);  /*setting values*/
        }

        if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                $formData = $this->_request->getPost();
                $paymenttype = $this->view->paymenttype=$this->_request->getParam('paymenttype');
                if( $paymenttype ==1 || $paymenttype ==""  ) {
                        $fixedReneval->paymenttype_details->setRequired(false);
                }
                if ($fixedReneval->isValid($formData)) {
                    $fixedInterest= $this->_request->getParam('interest');
                    if($fixedInterest) {
                        $accountid= $this->_request->getParam('accountId');
                        $memberId= $this->_request->getParam('memberId'); 
                        $productid= $this->_request->getParam('productId'); 
                        $memberid= $this->_request->getParam('memberId'); 

                        $startdate= $this->view->startdate=$this->_request->getParam('startdate');
                        $fixedamount= $this->view->recurringamount=$this->_request->getParam('recurringamount');
                        $perioddescription1= $this->view->perioddescription=$this->_request->getParam('perioddescription');
                        $fixedinterest= $this->view->interest=$this->_request->getParam('interest');
                        $modedetails= $this->view->paymenttype_details=$this->_request->getParam('paymenttype_details');
                        $description= $this->view->transactiondescription=$this->_request->getParam('transactiondescription');
                        $payableamount= $this->view->payableamount=$this->_request->getParam('payableamount');
                        $maturedamount=$this->view->maturedamount= $this->_request->getParam('totalamount');

                        $transaction_mode =$savingsDetails->gettransactionmode($paymenttype);
                        foreach($transaction_mode as $transaction_modes) {
                                $this->view->transactionModetype=$transaction_modes['paymenttype_description'];
                        }

                        $this->view->form2->startdate1->setValue($this->_request->getPost('startdate'));
                        $this->view->form2->recurringamount1->setValue($this->_request->getPost('recurringamount'));
                        $this->view->form2->perioddescription1->setValue($this->_request->getPost('perioddescription'));
                        $this->view->form2->interest1->setValue($this->_request->getPost('interest'));
                        $this->view->form2->paymenttype_details1->setValue($this->_request->getPost('paymenttype_details'));
                        $this->view->form2->transactiondescription1->setValue($this->_request->getPost('transactiondescription'));
                        $this->view->form2->paymenttype1->setValue($this->_request->getPost('paymenttype'));

                        $this->view->Submit = 'Confirm';
                    } else { 
                                    $this->view->Perioderror="please select the Periods again...."; 
                            }
                    } else {
                            $fixedReneval->perioddescription->setvalue('');
                    }
                }
            }

                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                        $sessionName = new Zend_Session_Namespace('ourbank');
                        $userId = $sessionName->primaryuserid;
                        $accountid= $this->_request->getParam('accountId');
                        $memberId= $this->_request->getParam('memberId'); 
                        $productid= $this->_request->getParam('productId'); 
                        $memberid= $this->_request->getParam('memberId'); 

                        $startdate= $this->_request->getParam('startdate1');
                        $fixedamount= $this->_request->getParam('recurringamount1');
                        $perioddescription1= $this->_request->getParam('perioddescription1');
                        $fixedinterest= $this->_request->getParam('interest1');
                        $paymenttype = $this->_request->getParam('paymenttype1');
                        $modedetails= $this->_request->getParam('paymenttype_details1');
                        $description= $this->_request->getParam('transactiondescription1');

                        $capitalamount= $this->_request->getParam('capitalamount');
                        $maturedinterestamount= $this->_request->getParam('maturedintrestamount');

                        $fixedTransactiondata = (array('transaction_id'=>'',
                                'account_id' => $accountid,
                                'glsubcode_id_to' => $glsubcode,
                                'transaction_date'=>date("Y-m-d"),
                                'amount_to_bank'=>'',
                                'amount_from_bank'=>$maturedinterest,
                                'transaction_amount'=>$maturedinterest,
                                'transaction_interest_amount' =>$this->view->interestamountfrombank,
                                'transaction_fine_amount' => '',
                                'transaction_other_amount'=>'',
                                'paymenttype_mode'=>$paymenttype,
                                'transaction_mode_details'=>$modedetails,
                                'transaction_type'=>2,
                                'recordstatus_id'=>'3',
                                'reffering_vouchernumber'=>'',
                                'transaction_remarks'=>$description,
                                'balance'=>0,
                                'confirmation_flag'=>'',
                                'updated_by'=>'',
                                'created_by'=>$userId,
                                'createddate'=>date("Y-m-d")
                        ));
                        $transaction_id=$fixedSavings->transactionInsert($fixedTransactiondata);

                        $fixedsavingsTransaction = (array('transaction_id'=>$transaction_id,
                                'account_id' =>$accountid,
                                'fixed_paymentpaid_date'=>date("Y-m-d"),
                                'fixed_amount' =>$maturedinterest,
                                'fixed_interst_amount' =>$this->view->interestamountfrombank,
                                'fixed_penalty_amount'=>'',
                                'fixed_other_deduction_amount'=>'',
                                'recordstatus_id'=>'3'
                        ));
                        $insertfixedtransaction=$fixedSavings->insertfixedsavingstransactionDetails($fixedsavingsTransaction);

                        if($this->view->membertype_id=='3') {
                                $noOfMemberinAccount=count($this->view->groupMembersDetails);
                                $individualamount=$maturedinterest/$noOfMemberinAccount;
                                if($this->view->groupname) {
                                        foreach($this->view->groupMembersDetails as $eachMember) {
                                                $data = array('groupmemberrecurringtransaction_id'=>'',
                                                        'groupmembertransaction_id'=>$transaction_id,
                                                        'groupaccount_id' => $accountid,
                                                        'groupmemberaccount_id'=>$eachMember['groupmember_id'],
                                                        'groupmembertransaction_date'=>date("Y-m-d"),
                                                        'groupmembertransaction_type' => 2,
                                                        'groupmembertransaction_amount' => $individualamount,
                                                        'groupmembertransaction_interest'=>'',
                                                        'groupmembertransaction_by'=>$userId,
                                                );
                                                $insert=$fixedSavings->groupfixedInsert($data);
                                        }
                                }
                        }




                        $transactions=new Fixedtransaction_Model_persnolSavings();

                        $banklibalitesaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'tranasction_number'=>$transaction_id,
                                                    'credit'=>'',
                                                    'debit' => $this->view->fixed_amount,
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                        $bankexpenditureaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>'20',
                                                    'tranasction_number'=>$transaction_id,
                                                    'credit'=>'',
                                                    'debit' => $this->view->interestamountfrombank,
                                                    'record_status'=>'3'));

                        $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);

                        $totaldebitamount=$this->view->fixed_amount+$this->view->interestamountfrombank;

                        if($paymenttype=='1') {
                            $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                            foreach($selectbankcashaccounts as $selectbankcashaccount) {
                                $bankcashglsubcode=$selectbankcashaccount['glsubcode_id'];
                            }

                            $bankassetsaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankcashglsubcode,
                                                    'tranasction_number'=>$transaction_id,
                                                    'credit'=>'',
                                                    'debit' => $totaldebitamount,
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        } else {
                            $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                            foreach($selectbankaccounts as $selectbankaccount) {
                                $bankglsubcode=$selectbankaccount['glsubcode_id'];
                            }

                            $bankassetsaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankglsubcode,
                                                    'tranasction_number'=>$transaction_id,
                                                    'credit'=>'',
                                                    'debit' => $totaldebitamount,
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        }


                        $updateaccount = array('accountstatus_id' =>5);
                        $fixedSavings->updateaccountnumber($accountid,$updateaccount);

                        $updatefixedaccount = array('recordstatus_id' =>5,'fixedaccountstatus_id'=>5);
                        $fixedSavings->updatefixedaccountnumber($accountid,$updatefixedaccount);

                        if($this->view->membertype_id=='3') {
                                $updategroupfixedaccount = array('groupmember_account_status' =>5);
                                $fixedSavings->updategroupaccountnumber($accountid,$updategroupfixedaccount);
                        }

                        $lastaccountinsertedId = $fixedSavings->insertAccount(array('account_id' => ''));
                        $arrayroles = $fixedSavings->accountnumber($memberId);
                        foreach($arrayroles as $transaction) {
                                $groupoffice_id=$this->view->memberbranch_id=$transaction['memberbranch_id'];
                        }

                        if($membertypeid==3) { 
                                $grouporIndividualNumber=3; $typeId=3;
                        } else { 
                                $grouporIndividualNumber=4;$typeId=4;
                        }
                        $product_id1 = 'F'; //savings account short form F
                        $b=str_pad($groupoffice_id,3,"0",STR_PAD_LEFT);
                        $t=str_pad($grouporIndividualNumber,2,"0",STR_PAD_LEFT);
                        $p=str_pad($product_id1,3,"0",STR_PAD_LEFT);
                        $a=str_pad($lastaccountinsertedId,6,"0",STR_PAD_LEFT);
                        $accountNumber=$b.$t.$p.$a;

                        $accountUpdate = array('account_number' =>$accountNumber,
                                        'member_id' => $memberid,
                                        'product_id' =>$productid,
                                        'membertype_id' =>$membertypeid,
                                        'accountcreated_by'=>$userId,
                                        'accountcreated_date' =>$startdate,
                                        'accountstatus_id'=>1,
                                        'Status_Description'=>'');
                        $fixedSavings->updateRow($lastaccountinsertedId,$accountUpdate);

                        $mature = new Zend_Date();
                        $mature->set($startdate,Zend_Date::DATES);
                        $mature->add($perioddescription1, Zend_Date::MONTH);
                        $matureDates= $mature->toString("YYY-MM-dd");
                        $systems=date("y/m/d H:i:s");

                        $ourbankfixedInsertion = $fixedSavings->ourbankFixedInsertion(array('fixedaccount_id' => '',
                                                'account_id' => $lastaccountinsertedId,
                                                'mature_date'=>$matureDates,
                                                'begin_date' => $startdate,
                                                'fixed_amount' => $fixedamount,
                                                'timefrequncy_id' => 1,
                                                'fixed_interest' => $fixedinterest,
                                                'premature_interest' => '',
                                                'recordstatus_id'=>1,
                                                'fixedaccountstatus_id'=>1,
                                                'created_date'=>$systems,
                                                'modified_by'=>$userId,
                                                'modified_date'=>1,
                                                'created_by'=>$userId
                        ));

                        if($membertypeid=='3') {
                                $updategroupaccount = array('groupmember_account_status' =>5);
                                $fixedSavings->updategroupaccountnumber($accountid,$updategroupaccount);
                                if($this->view->groupname) {
                                        foreach($this->view->groupMembersDetails as $eachMember) {
                                                $fixedSavings->groupAccountInsertion(array('groupmemberaccount_id' => '',
                                                'groupaccount_id' =>$lastaccountinsertedId,
                                                'groupmember_id' =>$eachMember['groupmember_id'],
                                                'product_id' => $productid,
                                                'groupmember_account_status' =>1,
                                                'groupcreateddate'=>$startdate,
                                                'groupcreatedby'=>$userId));
                                        }
                                }
                        }

                        $savingsTransactiondata1 = (array('transaction_id'=>'',
                                'account_id' => $lastaccountinsertedId,
                                'glsubcode_id_to' => $glsubcode,
                                'transaction_amount'=>$fixedamount,
                                'amount_to_bank'=>$fixedamount,
                                'amount_from_bank'=>'',
                                'transaction_date'=>date("Y-m-d"),
                                'transaction_interest_amount' =>'',
                                'transaction_fine_amount' => '',
                                'transaction_other_amount'=>'',
                                'paymenttype_mode'=>$paymenttype,
                                'transaction_mode_details'=>$modedetails,
                                'transaction_type'=>1,
                                'recordstatus_id'=>'3',
                                'reffering_vouchernumber'=>'',
                                'transaction_remarks'=>$description,
                                'balance'=>0,
                                'confirmation_flag'=>'',
                                'updated_by'=>'',
                                'created_by'=>$userId,
                                'createddate'=>date("Y-m-d")
                        ));
                        $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);
                        $fixedsavingsTransaction1 = (array('transaction_id'=>$transaction_id1,
                                'account_id' =>$lastaccountinsertedId,
                                'fixed_paymentpaid_date'=>date("Y-m-d"),
                                'fixed_amount' =>$fixedamount,
                                'fixed_interst_amount' =>'',
                                'fixed_penalty_amount'=>'',
                                'fixed_other_deduction_amount'=>'',
                                'recordstatus_id'=>'3'
                        ));
                        $insertfixedtransaction1=$fixedSavings->insertfixedsavingstransactionDetails($fixedsavingsTransaction1);

                        if($this->view->membertype_id=='3') {
                                $noOfMemberinAccount=count($this->view->groupMembersDetails);
                                $individualamounts=$fixedamount/$noOfMemberinAccount;
                                if($this->view->groupname) {
                                        foreach($this->view->groupMembersDetails as $eachMember) {
                                                $data = array('groupmemberrecurringtransaction_id'=>'',
                                                        'groupmembertransaction_id'=>$transaction_id1,
                                                        'groupaccount_id' => $lastaccountinsertedId,
                                                        'groupmemberaccount_id'=>$eachMember['groupmember_id'],
                                                        'groupmembertransaction_date'=>$startdate,
                                                        'groupmembertransaction_type' => 1,
                                                        'groupmembertransaction_amount' => $individualamounts,
                                                        'groupmembertransaction_interest'=>'',
                                                        'groupmembertransaction_by'=>$userId,
                                                );
                                                $insert=$fixedSavings->groupfixedInsert($data);
                                        }
                                }
                        }


                        $transactions=new Fixedtransaction_Model_persnolSavings();

                        $banklibalitesaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'tranasction_number'=>$transaction_id1,
                                                    'credit'=>$fixedamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    if($paymenttype=='1') {
                        $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                        foreach($selectbankcashaccounts as $selectbankcashaccount) {
                            $bankcashglsubcode=$selectbankcashaccount['glsubcode_id'];
                            }

                            $bankassetsaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankcashglsubcode,
                                                    'tranasction_number'=>$transaction_id1,
                                                    'credit'=>$fixedamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        } else {
                            $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                            foreach($selectbankaccounts as $selectbankaccount) {
                                $bankglsubcode=$selectbankaccount['glsubcode_id'];
                            }

                            $bankassetsaccountinsert = (array('bank_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankglsubcode,
                                                    'tranasction_number'=>$transaction_id1,
                                                    'credit'=>$fixedamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        }


                        $this->view->reneval= "This old account is closed  and new account with account number =" .$accountNumber. "is created";
                }
        }

        function transferfundsAction()
        {

//                 $storage = new Zend_Auth_Storage_Session();
//                 $data = $storage->read();
//                 if(!$data){
//                         $this->_redirect('index/login');
//                 }
// 
//                 $date = new Zend_Date();
//                 $systemDate= $date->get(Zend_Date::DATES);/*system date*/

                $fixedSavings = new Fixedtransaction_Model_fixedSavings();
                $savingsDetails=new Fixedtransaction_Model_persnolSavings();
// 
//                 /*fetching member code*/
                if ($this->_request->isPost()) {
                        /*if the information is Posted*/
                 $accountId=$this->_request->getParam('accountId');
                 $productId=$this->_request->getParam('productId');
                 $memberId=$this->_request->getParam('memberId');
                } else {
                        /*if the information is from url*/
                $accountId=base64_decode($this->_request->getParam('accountId'));
                $productId=base64_decode($this->_request->getParam('productId'));
                $memberId=base64_decode($this->_request->getParam('memberId'));
                }
                $this->view->accountid=$accountId;
                $this->view->productid=$productId;
// 
//                 $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);
//                 foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
//                         $memberid=$findmemberaccountsetails1['member_id'];
//                         $membertypeid=$findmemberaccountsetails1['membertype_id'];
//                 }
                $fixeddepositaccountdetails11=$fixedSavings->fixedAccountDetails($accountId);
                foreach($fixeddepositaccountdetails11 as $fixeddetails1) {
                        $begindate=$this->view->begin_date=$fixeddetails1['begin_date'];
                        $maturedate=$this->view->mature_date =$fixeddetails1['mature_date'];
                        $fixedamount=$this->view->fixed_amount =$fixeddetails1['fixed_amount'];
                        $fixedinterest=$this->view->fixed_interest =$fixeddetails1['fixed_interest'];
                        $this->view->offerproductname=$fixeddetails1['offerproductname'];
                        $this->view->accountnumber=$fixeddetails1['account_number'];
                        $penalinterest= $this->view->penalinterest=$fixeddetails1['penal_Interest'];
                        $this->view->membertype_id=$fixeddetails1['membertype_id'];
                        $memberbranch_id=$fixeddetails1['office_id'];
                        $glsubcode=$fixeddetails1['glsubcode_id'];

                }
//                 $this->view->capitalAmount=$fixedamount;
// 
//                 $currentdate=$date->toString('YYYY-MM-dd');
//                 $this->view->currentdate=$currentdate;
//                 $this->view->matureddate=$maturedate;
// 
//                 $date->set($maturedate,Zend_Date::DATES);
//                 $maturedate=$date->get($maturedate,Zend_Date::DATES);
//                 $maturedatemonths=$date->toString(Zend_Date::MONTH_SHORT);
//                 $maturedateyear=$date->toString(Zend_Date::YEAR);
//                 $maturedatedays=$date->toString(Zend_Date::DAY_SHORT);
// 
//                 $date->set($begindate,Zend_Date::DATES);
//                 $begindate=$date->get($begindate,Zend_Date::DATES);
//                 $begindatemonths=$date->toString(Zend_Date::MONTH_SHORT);
//                 $begindateyear=$date->toString(Zend_Date::YEAR);
//                 $begindatedays=$date->toString(Zend_Date::DAY_SHORT);
// 
//                 $date->set($currentdate,Zend_Date::DATES);
//                 $currentdate=$date->get($currentdate,Zend_Date::DATES);
//                 $currentdatemonths=$date->toString(Zend_Date::DAY_SHORT);
//                 $currentdateyear=$date->toString(Zend_Date::YEAR);
//                 $currentdatedays=$date->toString(Zend_Date::MONTH_SHORT);
// 
//                 $diffY=$maturedateyear-$begindateyear;
//                 $diffM=$maturedatemonths-$begindatemonths;
//                 $diffD=$maturedatedays-$begindatedays;
// 
//                 $diffpreMY=$currentdateyear-$begindateyear;
//                 $diffpreMM=$currentdatemonths-$begindatemonths;
//                 $diffpreMD=$currentdatedays-$begindatedays;
// 
// 
// 
//                 if($diffM<0) {
//                         $diffM=(-1*$diffM);
//                 }
// 
//                 if($diffpreMM<0) {
//                         $diffpreMM=(-1*$diffpreMM);
//                 }
// 
    function noofdays($begindate,$maturedate) {
        $day = 86400; // Day in seconds
        $format = 'Y-m-d'; // Output format (see PHP date funciton)
        $sTime = strtotime($begindate); // Start as time
        $eTime = strtotime($maturedate); // End as time
        $numDays = round(($eTime - $sTime) / $day) + 1;
        return abs($numDays);
    }
// Calculation = (interest/100)*(noofdays/365)*principal
    $numDays = noofdays($begindate,$maturedate);
    $interestamt = ($fixedinterest/100)*($numDays/365)*$fixedamount;

//         $fisedfinalinterest=($fixedinterest/12);
//         $this->view->maturedinterest=$fisedfinalinterest;
//         $matureinterest=(($numDays*$fisedfinalinterest*$fixedamount)/100);
        $this->view->interestamount=$interestamt;
//         $maturedinterest=$matureinterest+$fixedamount;
        $maturedamount = $fixedamount + $interestamt;
        $this->view->Totalamount=$maturedamount;
        $this->view->currentdate = $currentdate = date('Y-m-d');
        $numDays = noofdays($currentdate,$maturedate);
            if($currentdate >= $maturedate) {
                $matureinterest=($fixedinterest/100)*($numDays/365)*$fixedamount;;
                $this->view->interestamountfrombank=$matureinterest;
                $maturedinterest=$matureinterest+$fixedamount;
                $this->view->maturedinterestamount=$maturedinterest;
            }
            else  {
//                 $fisedfinalinterest=($fixedinterest/12);
//                 $this->view->maturedinterest=$fisedfinalinterest;
//                 $fisedfinalprematureinterest=($penalinterest/12);
//                 $this->view->prematuredinterest=$fisedfinalprematureinterest;
//                 $matureinterest=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalinterest*$fixedamount)/100);
//                 $this->view->interestamountfrombank=$matureinterest;
//                 $maturedinterest1=$matureinterest+$fixedamount;
//                 $prematureamount=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalprematureinterest*$maturedinterest1)/100);
//                 $this->view->prematureinterestamountfrombank=$prematureamount;
//                 $maturedinterest=$maturedinterest1-$prematureamount;
//                 $this->view->maturedinterestamount=$maturedinterest;

                    $matureinterest=($fixedinterest / 100) * ($numDays / 365) * $fixedamount;
                    $this->view->interestamountfrombank=$matureinterest;

                    $penalInterest=($penalinterest / 100) * ($numDays / 365) * $fixedamount;
                    $this->view->prematureinterestamountfrombank = $penalInterest;

                    $maturedinterest = $matureinterest + $fixedamount - $penalInterest;
                    $this->view->maturedinterestamount = $maturedinterest;
            }

                $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);

                foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
                        $memberid=$findmemberaccountsetails1['member_id'];
                        $membertypeid=$findmemberaccountsetails1['membertype_id'];
                }

//                 $offerproductdetails=$fixedSavings->offerproductdetails($productId);
//                 foreach($offerproductdetails as $offerproductdetails1) {
//                         $begindate=$offerproductdetails1['begindate'];
//                         $closedate=$offerproductdetails1['closedate'];
//                         $minimum_deposit_amount=$offerproductdetails1['minimum_deposit_amount'];
//                         $maximum_deposit_amount=$offerproductdetails1['maximum_deposit_amount'];
// // 			$begindate=$offerproductdetails1->begindate;
//                 }
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
//                         $this->view->groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//                 }

            $transaferfunds= New Fixedtransaction_Form_transferfunds();
            $this->view->form2=$transaferfunds;
            $this->view->form2->accountId->setValue($accountId);
            $this->view->form2->productId->setValue($productId);
            $this->view->form2->memberId->setValue($memberId);  /*fetching all payment mode */
            $this->view->form2->maturedinterestamount->setValue($this->view->maturedinterestamount);
            $this->view->form2->capitalamount->setValue($fixedamount);
            $this->view->form2->interestamountto->setValue($this->view->interestamountfrombank);
            $this->view->form2->penalinterest->setValue($this->view->prematureinterestamountfrombank);

            $select = $fixedSavings->fetchAll_paymenttype();
            foreach ($select as $paymenttype1) {
                $transaferfunds->paymenttype->addMultiOption($paymenttype1['id'],$paymenttype1['description']);
            }

                if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                    $formData = $this->_request->getPost();
                    $paymenttype = $this->view->paymenttype=$this->_request->getParam('paymenttype');
                    if( $paymenttype ==1 || $paymenttype ==""  ){
                            $transaferfunds->paymenttype_details->setRequired(false);
                    }
                    if ($transaferfunds->isValid($formData)) {
                        $sessionName = new Zend_Session_Namespace('ourbank');
                        $userId = $sessionName->primaryuserid;
                        $this->view->accountid=$accountid= $this->_request->getParam('accountId');
                        $this->view->memberid=$memberId= $this->_request->getParam('memberId'); 
                        $this->view->productid=$productId= $this->_request->getParam('productId'); 

                        $modedetails= $this->view->paymenttype_details=$this->_request->getParam('paymenttype_details');
                        $description= $this->view->transactiondescription=$this->_request->getParam('transactiondescription');

                        $this->view->form2->paymenttype1->setValue($this->_request->getPost('paymenttype'));
                        $this->view->form2->paymenttype_details1->setValue($this->_request->getPost('paymenttype_details'));
                        $this->view->form2->transactiondescription1->setValue($this->_request->getPost('transactiondescription'));

                        $transaction_mode =$savingsDetails->gettransactionmode($paymenttype);
                        foreach($transaction_mode as $transaction_modes) {
                                $this->view->transactionModetype=$transaction_modes['description'];
                        }

                        if($paymenttype=='5') {
                            $accountNumber= $accountid;
                            $savingsAccountsSearch = $fixedSavings->savingsAccountsSearch($accountNumber);
                            if (!$savingsAccountsSearch) {
                                    $this->view->noaccount1= "This account number does not exist";
                            } else {
                                    $this->view->Submit = 'confirm';
                            }
                        } else {
                            $this->view->Submit = 'confirm';
                        }
                    }
                }

            if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
//                         $sessionName = new Zend_Session_Namespace('ourbank');
//                         $userId = $sessionName->primaryuserid;

                 $accountid= $this->_request->getParam('accountId');
                 $memberId= $this->_request->getParam('memberId'); 
                 $productId= $this->_request->getParam('productId'); 
                 $paymenttype = $this->_request->getParam('paymenttype1');
                 $modedetails= $this->_request->getParam('paymenttype_details1');
                 $description= $this->_request->getParam('transactiondescription1');

                if($paymenttype=='5') {
                        $accountNumber= $accountid; 
                        $updateaccount = array('status_id' =>5);
                        $fixedSavings->updateaccountnumber($accountid,$updateaccount);
                        $updatefixedaccount = array('recordstatus_id' =>5,'fixedaccountstatus_id'=>5);
                        $fixedSavings->updatefixedaccountnumber($accountid,$updatefixedaccount);

//                         if($membertypeid=='2') {
//                                 $updategroupaccount = array('groupmember_account_status' =>5);
//                                 $fixedSavings->updategroupaccountnumber($accountid,$updategroupaccount);
//                         }

                         $transferedamount= $this->_request->getParam('maturedinterestamount');
                         $capitalamount= $this->_request->getParam('capitalamount');
                         $interestedamount= $this->_request->getParam('interestamountto');
                         $feeamount= $this->_request->getParam('penalinterest');

                        $savingsTransactiondata1 = (array('transaction_id'=>'',
                                'account_id' => $accountid,
                                'glsubcode_id_from' => '',
                                'glsubcode_id_to' => $glsubcode,
                                'transaction_date'=>date("Y-m-d"),
                                'amount_to_bank' => '',
                                'amount_from_bank' => $transferedamount,

                                'paymenttype_id'=>$paymenttype,
                                'paymenttype_details'=>$modedetails,
                                'transactiontype_id'=>2,
                                'recordstatus_id'=>'3',
                                'reffering_vouchernumber' => '',
                                'transaction_description'=>$description,
                                'balance' => '',
                                'confirmation_flag' => 0,
                                'created_by'=> 1,
                                'created_date'=>date("Y-m-d")
                        ));
                        $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);
                        $fixedsavingsTransaction1 = (array('transaction_id'=>$transaction_id1,
                                'account_id' =>$accountid,
                                'fixed_paymentpaid_date'=>date("Y-m-d"),
                                'fixed_amount' =>$transferedamount,
                                'fixed_interst_amount' =>$interestedamount,
                                'fixed_penalty_amount'=>'',
                                'fixed_other_deduction_amount'=>'',
                                'recordstatus_id'=>'3',
                        ));
                        $insertfixedtransaction1=$fixedSavings->insertfixedsavingstransactionDetails($fixedsavingsTransaction1);

//                         if($membertypeid=='3') {
//                                 $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                                 $individualamountfinalized=$transferedamount/$noOfMemberinAccount;
//                                 if($this->view->groupname) {
//                                         foreach($this->view->groupMembersDetails as $eachMember) {
//                                                 $data = array('groupmemberrecurringtransaction_id'=>'',
//                                                         'groupmembertransaction_id'=>$transaction_id1,
//                                                         'groupaccount_id' => $accountid,
//                                                         'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                         'groupmembertransaction_date'=>date("Y-m-d"),
//                                                         'groupmembertransaction_type' => 2,
//                                                         'groupmembertransaction_amount' => $individualamountfinalized,
//                                                         'groupmembertransaction_interest'=>'',
//                                                         'groupmembertransaction_by'=>$userId,
//                                                 );
//                                                 $insert=$fixedSavings->groupfixedInsert($data);
//                                         }
//                                 }
//                         }

                    $transactions=new Fixedtransaction_Model_persnolSavings();

                    $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    if($paymenttype=='1') {
                        $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                        foreach($selectbankcashaccounts as $selectbankcashaccount) {
                            $bankcashglsubcode=$selectbankcashaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>$bankcashglsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        } else {
                            $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                            foreach($selectbankaccounts as $selectbankaccount) {
                                $bankglsubcode=$selectbankaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=> '3',
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        }



                        if($currentdate<$maturedate) {
                            $bankincomeaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>'16',
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>$feeamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                        $bankincomeaccounts=$transactions->insertbankincomeaccounts($bankincomeaccountinsert);
                        }

                        $bankexpenditureaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_from' => '',
                                                    'glsubcode_id_to'=>'20',
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $interestedamount,
                                                    'record_status'=>'3'));

                        $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);

                            $transfersavingsaccountid = $fixedSavings->transferaccountid($accountNumber);
                            foreach($transfersavingsaccountid as $transfersavingsaccountid1) {
                                    $transaferaccount_id=$transfersavingsaccountid1['id'];
                                    $this->view->membertype_id=$transfersavingsaccountid1['membertype_id'];
                                    $glsubcodetransffered_id=$transfersavingsaccountid1['glsubcode_id'];
                            }


                            $savingsTransactiondata1 = (array('transaction_id'=>'',
                                    'account_id' => $transaferaccount_id,
                                    'glsubcode_id_from' => '',
                                    'glsubcode_id_to' => $glsubcodetransffered_id,
                                    'transaction_date'=>date("Y-m-d"),
                                    'amount_to_bank' => $transferedamount,
                                    'amount_from_bank' => '',
//                                     'transaction_amount'=>$transferedamount,
//                                     'transaction_interest_amount' =>'',
//                                     'transaction_fine_amount' => '',
//                                     'transaction_other_amount'=>'',
                                    'paymenttype_id'=>$paymenttype,
                                    'paymenttype_details'=>$modedetails,
                                    'transactiontype_id'=>1,
                                    'recordstatus_id'=>'3',
                                    'reffering_vouchernumber' => '',
                                    'transaction_description'=>$description,
                                    'balance' => '',
                                    'confirmation_flag' => 0,
                                    'created_by'=>1,
                                    'created_date'=>date("Y-m-d")
                            ));
                                $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);

                                $savingsTransaction1 = (array(
                                        'transaction_id' =>$transaction_id1,
                                        'account_id'=>$transaferaccount_id,
                                        'transaction_date' =>date("Y-m-d"),
                                        'transactiontype_id' =>1,
                                        'glsubcode_id_to' => '',
                                        'glsubcode_id_from' => '',
                                        'amount_to_bank'=>'',
                                        'amount_from_bank'=>$transferedamount,
                                        'paymenttype_id'=>1,
                                        'paymenttype_details'=>'',
                                        'transaction_description'=>$description,
                                        'transaction_interest'=>'',
                                        'transaction_by'=>1,
                                        'created_date'=>date("Y-m-d")

                                ));
                                $insertsavingstransaction1=$fixedSavings->insertpersnolsavingstransactionDetails($savingsTransaction1);

//                                 if($this->view->membertype_id=='2') {
//                                         $groupNamesSavingsearchFetch = $fixedSavings->groupNamesSavingsearch($transaferaccount_id);
//                                         $this->view->groupNamesSavingearch = $groupNamesSavingsearchFetch;
//                                         foreach($groupNamesSavingsearchFetch as $groupNamesSavingsearchFetch1) {
//                                                 $this->view->groupname=$groupNamesSavingsearchFetch1['groupname'];
//                                                 $groupid=$this->view->group_id=$groupNamesSavingsearchFetch1['group_id'];
//                                                 $accountNumber=$groupNamesSavingsearchFetch1['account_number'];
//                                         }
// 
//                                         if($this->view->groupname) {
//                                                 $this->view->groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$groupid);
//                                         }
// 
//                                         $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                                         $individualamounts=$transferedamount/$noOfMemberinAccount;
// 
//                                         if($this->view->groupname) {
//                                                 foreach($this->view->groupMembersDetails as $eachMember) {
//                                                         $data = array('groupmembersavingtransaction_id'=>'',
//                                                                 'groupmembertransaction_id'=>$transaction_id1,
//                                                                 'groupaccount_id' => $transaferaccount_id,
//                                                                 'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                                 'groupmembertransaction_date'=>date("Y-m-d"),
//                                                                 'groupmembertransaction_type' =>1,
//                                                                 'groupmembertransaction_amount' => $individualamounts,
//                                                                 'groupmembertransaction_interest'=>'',
//                                                                 'groupmembertransaction_by'=>$userId,
//                                                         );
//                                                         $insert=$fixedSavings->groupsavingsinsert($data);
//                                                 }
//                                         }
//                                 }

                        $transactions=new Fixedtransaction_Model_persnolSavings();

                        $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$glsubcodetransffered_id,
                                                    'glsubcode_id_from' => '',
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>$capitalamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    if($paymenttype=='1') {
                        $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                        foreach($selectbankcashaccounts as $selectbankcashaccount) {
                            $bankcashglsubcode=$selectbankcashaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankcashglsubcode,
                                                    'glsubcode_id_from'=>'',
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>$capitalamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        } else {
                            $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                            foreach($selectbankaccounts as $selectbankaccount) {
                                $bankglsubcode=$selectbankaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>'',
                                                    'glsubcode_id_from'=>'',
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>$capitalamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                            $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        }

                                $this->view->noaccount=$transferedamount."Rs Has Been Transfered From Account =".$accountid."To Account =".$transaferaccount_id ;
                        }

                        else {
                                $updateaccount = array('status_id' => 5);
                                $fixedSavings->updateaccountnumber($accountid,$updateaccount);

                                $updatefixedaccount = array('recordstatus_id' =>5,'fixedaccountstatus_id'=>5);
                                $fixedSavings->updatefixedaccountnumber($accountid,$updatefixedaccount);

//                                 if($membertypeid=='3') {
//                                         $updategroupaccount = array('groupmember_account_status' =>5);
//                                         $fixedSavings->updategroupaccountnumber($accountid,$updategroupaccount);
//                                 }

                                $transferedamount= $this->_request->getParam('maturedinterestamount');
                                $capitalamount= $this->_request->getParam('capitalamount');
                                $interestedamount= $this->_request->getParam('interestamountto');
                                $feeamount= $this->_request->getParam('penalinterest');
                                $savingsTransactiondata1 = (array('transaction_id'=>'',
                                        'account_id' => $accountid,
                                        'glsubcode_id_to' => $glsubcode,
                                        'transaction_date'=>date("Y-m-d"),
                                        'amount_to_bank' => '',
                                        'amount_from_bank' => $transferedamount,

                                        'paymenttype_id'=>$paymenttype,
                                        'paymenttype_details'=>$modedetails,
                                        'transactiontype_id'=>2,
                                        'recordstatus_id'=>'3',
                                        'reffering_vouchernumber' => '',
                                        'transaction_description'=>$description,
                                        'balance' => '',
                                        'confirmation_flag' => 0,
                                        'created_by'=>1,
                                        'created_date'=>date("Y-m-d")
                                ));
                                $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);
                                $fixedsavingsTransaction1 = (array('transaction_id'=>$transaction_id1,
                                        'account_id' =>$accountid,
                                        'fixed_paymentpaid_date'=>date("Y-m-d"),
                                        'fixed_amount' =>$transferedamount,
                                        'fixed_interst_amount' =>$interestedamount,
                                        'fixed_penalty_amount'=>'',
                                        'fixed_other_deduction_amount'=>'',
                                        'recordstatus_id'=>'3'
                                ));
                                $insertfixedtransaction1=$fixedSavings->insertfixedsavingstransactionDetails($fixedsavingsTransaction1);

//                                 if($membertypeid=='3') {
//                                         $noOfMemberinAccount=count($this->view->groupMembersDetails);
//                                         $individualamountfinalized=$transferedamount/$noOfMemberinAccount;
// 
//                                         if($this->view->groupname) {
//                                                 foreach($this->view->groupMembersDetails as $eachMember) {
//                                                         $data = array('groupmemberrecurringtransaction_id'=>'',
//                                                                 'groupmembertransaction_id'=>$transaction_id1,
//                                                                 'groupaccount_id' => $accountid,
//                                                                 'groupmemberaccount_id'=>$eachMember['groupmember_id'],
//                                                                 'groupmembertransaction_date'=>date("Y-m-d"),
//                                                                 'groupmembertransaction_type' => 2,
//                                                                 'groupmembertransaction_amount' => $individualamountfinalized,
//                                                                 'groupmembertransaction_interest'=>'',
//                                                                 'groupmembertransaction_by'=>$userId,
//                                                         );
//                                                         $insert=$fixedSavings->groupfixedInsert($data);
//                                                 }
//                                         }
//                                 }

                    $transactions=new Fixedtransaction_Model_persnolSavings();

                    $banklibalitesaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$glsubcode,
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                    $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);

                    if($paymenttype=='1') {
                        $selectbankcashaccounts = $transactions->selectbankcashassetsaccount($memberbranch_id);
                        foreach($selectbankcashaccounts as $selectbankcashaccount) {
                            $bankcashglsubcode=$selectbankcashaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>'20',
                                                    'transaction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                        $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        } else {
                            $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
                            foreach($selectbankaccounts as $selectbankaccount) {
                                $bankglsubcode=$selectbankaccount['id'];
                            }

                            $bankassetsaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>$bankglsubcode,
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $capitalamount,
                                                    'record_status'=>'3'));
                        $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
                        }



                        if($currentdate<$maturedate) {
                            $bankincomeaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>'16',
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>$feeamount,
                                                    'debit' => '',
                                                    'record_status'=>'3'));
                        $bankincomeaccounts=$transactions->insertbankincomeaccounts($bankincomeaccountinsert);
                        }

                        $bankexpenditureaccountinsert = (array('office_id' => $memberbranch_id,
                                                    'glsubcode_id_to'=>'20',
                                                    'tranasction_id'=>$transaction_id1,
                                                    'credit'=>'',
                                                    'debit' => $interestedamount,
                                                    'record_status'=>'3'));

                        $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);
                        $this->_redirect('fixedtransaction/index');
                        }
                }
        }

        function statusAction()
        {
//                 $storage = new Zend_Auth_Storage_Session();
//                 $data = $storage->read();
//                 if(!$data){
//                         $this->_redirect('index/login');
//                 }
// 
//                 $date = new Zend_Date();
//                 $systemDate= $date->get(Zend_Date::DATES);/*system date*/
// 
                $fixedSavings = new Fixedtransaction_Model_fixedSavings();
                $savingsDetails=new Fixedtransaction_Model_persnolSavings();
//                 /*fetching member code*/
                if ($this->_request->isPost()) {
                        /*if the information is Posted*/
                $accountId=$this->_request->getParam('accountId');
                $productId=$this->_request->getParam('productId');
                $memberId=$this->_request->getParam('memberId');
                } 
                else {
                        /*if the information is from url*/
                $accountId=base64_decode($this->_request->getParam('accountId'));
                $productId=base64_decode($this->_request->getParam('productId'));
                $memberId=base64_decode($this->_request->getParam('memberId'));
                }
                $accountid=$accountId;
                $this->view->accountid=$accountId;
                $this->view->productid=$productId;
                $this->view->memberid=$memberId;


        $groupNamesSearchFetch = $fixedSavings->groupNamesSearchs($accountId);
        $this->view->groupMembersDetails = $groupNamesSearchFetch;

            foreach($groupNamesSearchFetch as $groupNamesSearchFetch1) {
                $this->view->groupname=$groupNamesSearchFetch1['groupname'];
                $groupid=$this->view->group_id=$groupNamesSearchFetch1['group_id'];
                $accountNumber=$groupNamesSearchFetch1['account_number'];
            }


                $fixeddepositaccountdetails11=$fixedSavings->fixedAccountDetails($accountId);
                foreach($fixeddepositaccountdetails11 as $fixeddetails1) {
                        $begindate=$this->view->begin_date=$fixeddetails1['begin_date'];
                        $maturedate=$this->view->mature_date =$fixeddetails1['mature_date'];
                        $fixedamount=$this->view->fixed_amount =$fixeddetails1['fixed_amount'];
                        $fixedinterest=$this->view->fixed_interest =$fixeddetails1['fixed_interest'];
                        $this->view->offerproductname=$fixeddetails1['offerproductname'];
                        $accountNumber=$this->view->accountnumber=$fixeddetails1['account_number'];
                        $penalinterest= $this->view->penalinterest=$fixeddetails1['penal_Interest'];
                        $this->view->membertype_id=$fixeddetails1['membertype_id'];
                        $memberbranch_id=$fixeddetails1['office_id'];
                        $this->view->status_id = $accountStatusId = $fixeddetails1['status_id'];
                        $glsubcode=$fixeddetails1['glsubcode_id'];
                }
//                 $this->view->capitalAmount=$fixedamount;
// 
// 
//                 $fixeddepositaccountinformation=$fixedSavings->fixedAccountinformation($accountId);
//                 foreach($fixeddepositaccountinformation as $fixeddepositaccountinformation1) {
//                         $categoryType=$this->view->categoryType=$fixeddepositaccountinformation1['category_id'];
//                         $membershipid = $this->view->code=$fixeddepositaccountinformation1['membercode'];
//                         $this->view->membertype_id=$fixeddepositaccountinformation1['membertype_id'];
//                 }
// 
//                 if($this->view->membertype_id==3) {
//                         /*fetch all details if member type is 	Group*/
//                         $arrayroles = $fixedSavings->fetchpersnolfixedGroupDetails($accountNumber,$categoryType);
//                         $this->view->member1 = $arrayroles;
//                         foreach($this->view->member1 as $arrayroles1) {
//                         $this->view->code=$arrayroles1['membercode'];
//                         $this->view->name=$arrayroles1['groupname'];
//                                 $this->view->categoryname=$arrayroles1['categoryname'];
//                                 $this->view->accountCode=$arrayroles1['account_number'];
//                                 $group_id=$arrayroles1['group_id'];
//                                 $this->view->Branchoffice=$arrayroles1['office_name'];
//                         }
// 
//                         $this->view->groupMembersDetails=$fixedSavings->fetchGroupAccountMembers($accountNumber,$group_id);
//                         /*count number of member of this group*/
//                         $noOfMemberinGroup=count($this->view->groupMembersDetails);
//                         $this->view->noOfMemberinGroup=$noOfMemberinGroup;
//                 }
// 
//                 $currentdate=$date->toString('YYYY-MM-dd');
//                 $this->view->currentdate=$currentdate;
//                 $this->view->matureddate=$maturedate;
// 
//                 $date->set($maturedate,Zend_Date::DATES);
//                 $maturedate=$date->get($maturedate,Zend_Date::DATES);
//                 $maturedatemonths=$date->toString(Zend_Date::MONTH_SHORT);
//                 $maturedateyear=$date->toString(Zend_Date::YEAR);
//                 $maturedatedays=$date->toString(Zend_Date::DAY_SHORT);
// 
//                 $date->set($begindate,Zend_Date::DATES);
//                 $begindate=$date->get($begindate,Zend_Date::DATES);
//                 $begindatemonths=$date->toString(Zend_Date::MONTH_SHORT);
//                 $begindateyear=$date->toString(Zend_Date::YEAR);
//                 $begindatedays=$date->toString(Zend_Date::DAY_SHORT);
// 
//                 $date->set($currentdate,Zend_Date::DATES);
//                 $currentdate=$date->get($currentdate,Zend_Date::DATES);
//                 $currentdatemonths=$date->toString(Zend_Date::DAY_SHORT);
//                 $currentdateyear=$date->toString(Zend_Date::YEAR);
//                 $currentdatedays=$date->toString(Zend_Date::MONTH_SHORT);
// 
//                 $diffY=$maturedateyear-$begindateyear;
//                 $diffM=$maturedatemonths-$begindatemonths;
//                 $diffD=$maturedatedays-$begindatedays;
// 
//                 $diffpreMY=$currentdateyear-$begindateyear;
//                 $diffpreMM=$currentdatemonths-$begindatemonths;
//                 $diffpreMD=$currentdatedays-$begindatedays;
// 
// 
// 
//                 if($diffM<0) {
//                         $diffM=(-1*$diffM);
//                 }
// 
//                 if($diffpreMM<0) {
//                         $diffpreMM=(-1*$diffpreMM);
//                 }
// 
    function noofdays($begindate,$maturedate) {
        $day = 86400; // Day in seconds
        $format = 'Y-m-d'; // Output format (see PHP date funciton)
        $sTime = strtotime($begindate); // Start as time
        $eTime = strtotime($maturedate); // End as time
        $numDays = round(($eTime - $sTime) / $day) + 1;
        return abs($numDays);
    }
// Calculation = (2/100)*(91/365)*6000
    $numDays = noofdays($begindate,$maturedate);
    $interestamt = ($fixedinterest/100)*($numDays/365)*$fixedamount;

//         $fisedfinalinterest=($fixedinterest/12);
//         $this->view->maturedinterest=$fisedfinalinterest;
//         $matureinterest=(($numDays*$fisedfinalinterest*$fixedamount)/100);
        $this->view->interestamount=$interestamt;
//         $maturedinterest=$matureinterest+$fixedamount;
        $maturedamount = $fixedamount + $interestamt;
        $this->view->Totalamount=$maturedamount;


// 
//                 if($currentdate>=$maturedate) {
//                         $matureinterest=(((($diffY*12)+($diffM))*$fisedfinalinterest*$fixedamount)/100);
//                         $this->view->interestamountfrombank=$matureinterest;
//                         $maturedinterest=$matureinterest+$fixedamount;
//                         $this->view->maturedinterestamount=$maturedinterest;
//                 } else  {
//                         $fisedfinalinterest=($fixedinterest/12);
//                         $this->view->maturedinterest=$fisedfinalinterest;
//                         $fisedfinalprematureinterest=($penalinterest/12);
//                         $this->view->prematuredinterest=$fisedfinalprematureinterest;
//                         $matureinterest=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalinterest*$fixedamount)/100);
//                         $this->view->interestamountfrombank=$matureinterest;
//                         $maturedinterest1=$matureinterest+$fixedamount;
//                         $prematureamount=(((($diffpreMY*12)+($diffpreMM))*$fisedfinalprematureinterest*$maturedinterest1)/100);
//                         $this->view->prematureinterestamountfrombank=$prematureamount;
//                         $maturedinterest=$maturedinterest1-$prematureamount;
//                         $this->view->maturedinterestamount=$maturedinterest;
//                 }
// 
//                 $findmemberaccountsetails=$fixedSavings->findmembertypeid($accountId);
//                 foreach($findmemberaccountsetails as $findmemberaccountsetails1) {
//                         $memberid=$findmemberaccountsetails1['member_id'];
//                         $membertypeid=$findmemberaccountsetails1['membertype_id'];
//                         $accountstatus=$findmemberaccountsetails1['accountstatus_id'];
//                 }
// 
                $findstatus=$fixedSavings->findstatus($accountStatusId);
                foreach($findstatus as $findstatus1) {
                        $status=$findstatus1['recordstatusdescription'];
                }
                $this->view->status=$status;
// 
//                 $offerproductdetails=$fixedSavings->offerproductdetails($productId);
//                 foreach($offerproductdetails as $offerproductdetails1) {
//                         $begindate=$offerproductdetails1['begindate'];
//                         $closedate=$offerproductdetails1['closedate'];
//                         $minimum_deposit_amount=$offerproductdetails1['minimum_deposit_amount'];
//                         $maximum_deposit_amount=$offerproductdetails1['maximum_deposit_amount'];
// // 			$begindate=$offerproductdetails1->begindate;
//                 }
                $fixedstatus = new Fixedtransaction_Form_FixedStatus();
                $this->view->form3=$fixedstatus;
//                 $this->view->form3->accountcode->setValue($this->view->accountnumber);
//                 $this->view->form3->membercode->setValue($this->view->code);
//                 $this->view->form3->categoryId->setValue($this->view->categoryType);
//                 $this->view->form3->totalamount->setValue($this->view->maturedinterestamount);
// 
                $newstatus = $fixedSavings->fixedstatus($accountStatusId);
                foreach($newstatus as $newstatus) {
                        $fixedstatus->newStatus->addMultiOption($newstatus['recordstatus_id'],$newstatus['recordstatusdescription']);
                }

// 
//                 $loanDetails1 = $fixedSavings->fetchLoanDisbursementDetails($accountId);
//                 $totladisburseAmount=0;
//                 foreach($loanDetails1 as $arrayroles1) {
//                 $totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
//                 }
//                 $this->view->totladisburseAmount=$totladisburseAmount;
// 
//                 $loanDetails1 = $fixedSavings->fetchLoanAccountDetails($accountNumber);
//                 $this->view->fetchLoanAccountDetails=$loanDetails1;
//                 $totladisburseAmount=0;
//                 foreach($loanDetails1 as $arrayroles1) {
//                         $totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
//                         $previousdisburseddate=$arrayroles1['loandisbursement_date'];
//                 }
//                 $this->view->balance=$totladisburseAmount;
//                 $this->view->disbursed= "amountHasBeenDisbursedForTheAccount";
// 
// 
//                 if($this->view->categoryType=='2' && $this->view->totladisburseAmount>0) {
//                         /*numbar of instalments already paied and its details*/
//                         $noOfInstalmentPaied1=$fixedSavings->noOfInstalmentPaied($accountId);
//                         $noOfInstalmentPaied=count($noOfInstalmentPaied1);
//                         $this->view->noOfInstalmentPaied=$noOfInstalmentPaied;
//                         $this->view->paiedAmount=0;
//                         foreach($noOfInstalmentPaied1 as $loanInstalmentDetails1) {
//                                 $this->view->paiedAmount=$this->view->paiedAmount+$loanInstalmentDetails1['accountinstallment_amount'];
//                         }
//                                 /*instalments details of still which have to pay */
//                         $loanInstalmentDetails = $fixedSavings->loanInstalmentDetails($accountId);
//                         foreach($loanInstalmentDetails as $loanInstalmentDetails1) {
//                                 $rateOfIntrest=$loanInstalmentDetails1['loan_interest'];
//                                 $noInstalment=$loanInstalmentDetails1['loan_installments'];
//                                 $this->view->loanAprovedAmount= $loanInstalmentDetails1['loan_amount'];
//                                 $disbursedDate=$loanInstalmentDetails1['loandisbursement_date'];
//                         }
//                         $this->view->rateOfIntrest=$rateOfIntrest;
//                         $this->view->noInstalment=$noInstalment;
//                         $this->view->balanceInstalment=$noInstalment-$noOfInstalmentPaied;
//                         $this->view->stillHaveToPay=$this->view->loanAprovedAmount-$this->view->paiedAmount;	
//                 }
// 

        $this->view->currentdate=$currentdate = date('Y-m-d');
        $numDays1 = noofdays($currentdate,$maturedate);
         $interestamt1 = ($fixedinterest/100)*($numDays1/365)*$fixedamount;
         $totalamount1=$interestamt1 + $fixedamount;
        $totalamount1 = round($totalamount1,2);
        $this->view->form3->totalamount->setValue($totalamount1);

                if ($this->_request->isPost() && $this->_request->getPost('Confirm')) {
                    $formData = $this->_request->getPost();

                    if ($fixedstatus->isValid($formData)) 
                    {
                        $account=$this->view->accountid;
                        $totalamount= $this->view->totalamount=$this->_request->getParam('totalamount'); 
                        $Status=$this->view->newStatus=$this->_request->getParam('newStatus');
                        $Statusdescription=$this->view->description=$this->_request->getParam('description');

                        $this->view->form3->totalamount1->setValue($this->_request->getPost('totalamount'));
                        $this->view->form3->newStatus1->setValue($this->_request->getPost('newStatus'));
                        $this->view->form3->description1->setValue($this->_request->getPost('description'));

                        $statusdetails =$savingsDetails->getrecordstatusdetails($Status);
                        foreach($statusdetails as $statusdetailsinfo) {
                            $this->view->newrecordstatus=$statusdetailsinfo['recordstatusdescription'];
                        }
                        $this->view->Submit="Confirm";
                    }
                }

                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
//                         $sessionName = new Zend_Session_Namespace('ourbank');
//                         $userId = $sessionName->primaryuserid;
                         $account=$this->view->accountid;
                         $totalamount= $this->_request->getParam('totalamount1'); echo "<br>";
                         $Status=$this->_request->getParam('newStatus1'); echo "<br>";
                         $Statusdescription=$this->_request->getParam('description1'); echo "<br>";

                        $data = array('status_id' =>$Status,'Status_Description'=>$Statusdescription);
                        $data1 = array('recordstatus_id' =>$Status,'fixedaccountstatus_id'=>$Status);
                        $data2 = array('groupmember_account_status' =>$Status);

                        $fixedSavings->accountstatusChange($account,$data);
                        $fixedSavings->fixedaccountstatusChange($account,$data1);


//                         if($this->view->membertype_id=='2') {
//                                 $fixedSavings->fixedgroupaccountaccountstatusChange($account,$data2);
//                         }
// 
//                         if($Status=='4') {
//                                 $savingsTransactiondata1 = (array('transaction_id'=>'',
//                                         'account_id' => $accountId,
//                                         'glsubcode_id_to' => $glsubcode,
//                                         'transaction_amount'=>$totalamount,
//                                         'transaction_date'=>date("Y-m-d"),
//                                         'amount_to_bank' => '',
//                                         'amount_from_bank' => $totalamount,
//                                         'transaction_interest_amount' =>'',
//                                         'transaction_fine_amount' => '',
//                                         'transaction_other_amount'=>'',
//                                         'paymenttype_mode'=>1,
//                                         'transaction_mode_details'=>'',
//                                         'transaction_type'=>2,
//                                         'recordstatus_id'=>3,
//                                         'reffering_vouchernumber' => '',
//                                         'transaction_remarks'=>$Statusdescription,
//                                         'balance' => '',
//                                         'confirmation_flag' => 0,
//                                         'updated_by' => $userId,
//                                         'created_by'=>$userId,
//                                         'createddate'=>date("Y-m-d")
//                                 ));
//                                 $transaction_id1=$fixedSavings->transactionInsert($savingsTransactiondata1);
// 
//                                 $fixedsavingsTransaction1 = (array('transaction_id'=>$transaction_id1,
//                                         'account_id' =>$accountId,
//                                         'fixed_paymentpaid_date'=>date("Y-m-d"),
//                                         'fixed_amount' =>$totalamount,
//                                         'fixed_interst_amount' =>'',
//                                         'fixed_penalty_amount'=>'',
//                                         'fixed_other_deduction_amount'=>'',
//                                         'recordstatus_id'=>'3'
//                                 ));
//                                 $insertfixedtransaction1=$fixedSavings->insertfixedsavingstransactionDetails($fixedsavingsTransaction1);
// 
//                         $transactions=new Fixedtransaction_Model_persnolSavings();
// 
// 
//                         $banklibalitesaccountinsert = (array('bank_id' => $memberbranch_id,
//                                                     'glsubcode_id_to'=>$glsubcode,
//                                                     'tranasction_number'=>$transaction_id1,
//                                                     'credit'=>'',
//                                                     'debit' => $totalamount,
//                                                     'record_status'=>'3'));
//                     $banklibalityaccounts=$transactions->insertbanklibalityaccounts($banklibalitesaccountinsert);
// 
//                     $selectbankaccounts = $transactions->selectbankassetsaccount($memberbranch_id);
//                     foreach($selectbankaccounts as $selectbankaccount) {
//                         $bankglsubcode=$selectbankaccount['glsubcode_id'];
//                     }
// 
//                     $bankassetsaccountinsert = (array('bank_id' => $memberbranch_id,
//                                                     'glsubcode_id_to'=>$bankglsubcode,
//                                                     'tranasction_number'=>$transaction_id1,
//                                                     'credit'=>'',
//                                                     'debit' => $totalamount,
//                                                     'record_status'=>'3'));
//                     $bankassetsaccounts=$transactions->insertbankassetsaccounts($bankassetsaccountinsert);
// 
// 
//                     $bankincomeaccountinsert = (array('bank_id' => $memberbranch_id,
//                                                     'glsubcode_id_to'=>'21',
//                                                     'tranasction_number'=>$transaction_id1,
//                                                     'credit'=>$fixedamount,
//                                                     'debit' => '',
//                                                     'record_status'=>'3'));
//                     $bankincomeaccounts=$transactions->insertbankincomeaccounts($bankincomeaccountinsert);
// 
//                         $bankexpenditureaccountinsert = (array('bank_id' => $memberbranch_id,
//                                                     'glsubcode_id_to'=>'20',
//                                                     'tranasction_number'=>$transaction_id1,
//                                                     'credit'=>$matureinterest,
//                                                     'debit' =>'',
//                                                     'record_status'=>'3'));
// 
//                         $bankexpenditureccounts=$transactions->insertbankexpenditureaccounts($bankexpenditureaccountinsert);
//                         }
                        $this->_redirect('fixedtransaction/index');
                }
        }
}
