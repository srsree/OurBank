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
class Recurringaccount_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
        $this->view->pageTitle = 'Recurring';
        $this->view->title = 'Accounting';
        $this->view->accounts = new Recurringaccount_Model_Accounts();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();
    }

    public function indexAction()
    {
        $accountsForm = $this->view->form = new Recurringaccount_Form_Accounts();
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                $formData = $this->_request->getPost();
                if ($accountsForm->isValid($formData)) {
                    $result = $this->view->accounts->search($this->_request->getParam('membercode'));
                    if($result) {
                        $this->view->result =$result;
                    } else {
                        $this->view->errormsg = "No records found";
                    }
                }
            }
        }
    }

    public function detailsAction() 
    {
        $memberId= base64_decode($this->_request->getParam('Id'));
        $memberCode= base64_decode($this->_request->getParam('code'));
        $this->view->result = $this->view->accounts->getDetails($memberCode);
        $this->view->memberId = $memberId;
        $applicableto=substr($memberCode,4,1);
        $this->view->savingsProducts = $this->view->accounts->fetchSavingsProducts($applicableto);
        $this->view->account = $this->view->accounts->accountsSearch($memberCode);
    }

    public function createaccountAction()
    {
        $path=$this->view->baseUrl();
        $recurringForm = new Recurringaccount_Form_Recurring($path);
        $this->view->fixedForm = $recurringForm;
        $productId = base64_decode($this->_request->getParam('Id'));
        $memberId = base64_decode($this->_request->getParam('memberId'));
        $membercode = base64_decode($this->_request->getParam('code'));
        //EXTRACTING GROUP ID FROM MEMBER CODE
        if(substr($membercode,4,1)=='2') {
            $this->view->gp_members=$this->view->accounts->fetchmembers($memberId);
        }

        $recurringForm->Id->setValue(base64_encode($productId));
        $recurringForm->memberId->setValue(base64_encode($memberId));
        $recurringForm->code->setValue(base64_encode($membercode));
        $interestperiods=$this->view->accounts->interestperiods($productId);
        foreach($interestperiods  as $interestperiods) { $interestperiods1 = $interestperiods['maxperiod'];}

        for($i=1;$i<=$interestperiods1;$i++)  {
                $recurringForm->period->addMultiOption($productId.'-'.$i,$i);
        }
        $this->view->account = $this->view->accounts->details($productId,$membercode);
        $this->view->interestRates = $this->view->accounts->getInterestRates($productId);
        if ($this->_request->getPost('Submit')) 
        {
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                if ($recurringForm->isValid($formData)) {
                    foreach ($this->view->account as $account) {
                        $begindate = $account->begindate;
                        $officeid = $account->officeid;
                        $typeID = $account->typeID;
                        $glsubID = $account->glsubID;
                    }

//                         Insertion into ourbank_account 
                    $data = array('account_number' => 1,
                                'member_id' => $memberId,
                                'product_id' => $productId,
                                'begin_date' => $begindate,
                                'membertype_id' => $typeID,
                                'accountcreated_date'=> $this->view->cl->phpmysqlformat($this->_request->getPost('date1')),
                                'created_by' => 1,
                                'status_id'=>1);
                    $accId = $this->view->adm->addRecord('ourbank_accounts',$data);
                    // Account number formation 
                    // <-----------14 digit number ---------->
                    // <--3-->/<--2-->/<---->/<--3-->/<--6-->
                    // 00office_id/0membertype_id/00typeofacc [L/S/F/R]/00000account_id
                    $b=str_pad($officeid,3,"0",STR_PAD_LEFT); 
                    $t=str_pad($typeID,2,"0",STR_PAD_LEFT);
                    $pid=str_pad($productId,2,"0",STR_PAD_LEFT);
                    $p=str_pad("R",1,"0",STR_PAD_LEFT);
                    $a=str_pad($accId,6,"0",STR_PAD_LEFT);
                    $account = array('account_number' =>$b.$t.$pid.$p.$a);

                    $this->view->accounts->accUpdate($accId,$account);
                    // Insertion into transaction 
                    $input = array('account_id' => $accId,
                                'glsubcode_id_to' => $glsubID,
                                'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date1')),
                                'amount_from_bank' => '',
                                'amount_to_bank' => $this->_request->getPost('tAmount'),
                                'paymenttype_id' => 1,
                                'transactiontype_id' => 1,
                                'recordstatus_id' => 3,
                                'transaction_description'=> "Opening amount",
                                'balance' => $this->_request->getPost('tAmount'),
                                'confirmation_flag' => 0,
                                'created_by' => 1);
                    $tranID = $this->view->adm->addRecord('ourbank_transaction',$input);

                    $interest = (($this->_request->getPost('tAmount'))*($this->_request->getParam('interest')))/100;

                    $begindate1=$this->view->cl->phpmysqlformat($this->_request->getPost('date1'));
                    $period1=$this->_request->getPost('period');
                    $id1=explode('-',$period1);
                    $maturedate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($begindate1)) . " +".$id1[1]." months"));
                    $periods = $id1[1];

                    // Insertion into ourbank_recurring_payment
                    $rec_payment = array(
                                'transaction_id' => $tranID,
                                'account_id' => $accId,
                                'rec_payment_number' => 1,
                                'rec_paymentpaid_date' => date('Y-m-d'),
                                'rec_paid_amount' => $this->_request->getPost('tAmount'),
                                'rec_paid_interst' => $interest,
                                'rec_paid_other_amount' => '',
                                'recordstatus_id' => '3');
                    $tranID = $this->view->adm->addRecord('ourbank_recurring_payment',$rec_payment);

                    // Insertion into ourbank_paydetails
                    
                    $date=$this->view->cl->phpmysqlformat($this->_request->getPost('date1'));
                    for($i=1; $i<=$periods; $i++) 
                    {
                        if($i == 1){
                            $status = '2';
                            $today = $date;
                        } else if($i == 2) {
                            $status = '4';
                            $today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +".($i-1)." months"));
                        } else {
                            $status = '3';
                            $today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +".($i-1)." months"));
                        }
                    $rec_paydetails = array(
                                'account_id' => $accId,
                                'rec_payment_id' => $i,
                                'rec_payment_date' => $today,
                                'rec_payment_amount' => $this->_request->getPost('tAmount'),
                                'rec_payment_penalty_amount' => '',
                                'rec_principal_amount' => '',
                                'rec_payment_status' => $status,
                                'created_by' => 1,
                                'created_date' => date('Y-m-d'),
                                'recordstatus_id' => '3',);
                    $tranID = $this->view->adm->addRecord('ourbank_recurringpaydetails',$rec_paydetails);
                    }


                    // Insertion into saving transaction 
                    $recacc = array(
                                    'account_id' => $accId,
                                    'begin_date' => $begindate1,
                                    'mature_date' => $maturedate,
                                    'recurring_amount' => $this->_request->getPost('tAmount'),
                                    'timefrequncy_id' => $id1[1],
                                    'fixed_interest'=> $this->_request->getParam('interest'),
                                    'premature_interest' => 1,
                                    'fixedaccountstatus_id' => 1,
                                    'created_by' => 1,
                                    'created_date' => date('Y-m-d'));
                    $this->view->adm->addRecord('ourbank_recurringaccounts',$recacc);
                    // Insertion into Liabilities
                    $liabilities = array('office_id' => $officeid,
                                        'glsubcode_id_from' => '',
                                        'glsubcode_id_to' => $glsubID,
                                        'transaction_id' => $tranID,
                                        'credit' => $this->_request->getPost('tAmount'),
                                        'record_status'=> 3);
                    $this->view->adm->addRecord('ourbank_Liabilities',$liabilities);
                    $glresult = $this->view->accounts->getGlcode($officeid);
                    foreach ($glresult as $glresult) {
                        $cashglsubocde = $glresult->id;
                    }


//                     Insertion into groupmemmbers_accounts 

                if($_POST['members']){
                    $member_array = $_POST['members'];

                    foreach($member_array as $member_array1) {
                        $gp_mem=array('account_id' => $accId,
                                        'member_id' => $member_array1['id'],
                                        'product_id' => $productId,
                                        'status' => 3,
                                        'created_date' => date('Y-m-d'),
                                        'created_by' => 1);
                        $this->view->adm->addRecord('ourbank_group_acccounts',$gp_mem);
                    }
                    $noofmembers = count($member_array);
                    $splitamt = ($this->_request->getPost('tAmount')) / $noofmembers;

                    foreach($member_array as $member_array1) {
                        $gp_mem=array('transaction_id' => $tranID,
                                        'account_id' => $accId,
                                        'member_id' => $member_array1['id'],
                                        'transaction_date' => date('Y-m-d'),
                                        'transaction_type' => 1,
                                        'transaction_amount' => $splitamt,
                                        'transaction_interest' => $this->_request->getPost('interest'),
                                        'created_date' => date('Y-m-d'),
                                        'transaction_by' => 1);
                        $this->view->adm->addRecord('ourbank_group_recurringtransaction',$gp_mem);
                    }
                }

                    // Insertion into Assets ourbank_Assets
                    $assets =  array('office_id' => $officeid,
                                    'glsubcode_id_from' => '',
                                    'glsubcode_id_to' => $glsubID,
                                    'transaction_id' => $tranID,
                                    'credit' => $this->_request->getPost('tAmount'),
                                    'record_status' => 3);
                    $this->view->adm->addRecord('ourbank_Assets',$assets);
                    $this->_redirect("/fixedaccount/index/message/acNum/".base64_encode($b.$t.$pid.$p.$a));
                }
            }
        }
    }

    public function messageAction() 
    {
        $this->view->pageTitle = 'Accounting';
        $this->view->acNum = base64_decode($this->_request->getParam('acNum'));
    }

    public function getinterestsAction()
    {
        $this->_helper->layout->disableLayout();
        $id = $this->_request->getParam('interest');
        $value=explode('-',$id);
        $interestvalue = $this->view->accounts->getInterestvalue($value[0],$value[1]);
        foreach($interestvalue as $interestvalue1){
/*            echo $interestvalue1['Interest'];*/
             $this->view->interest = $interestvalue1['Interest'];
        }
    }

}

