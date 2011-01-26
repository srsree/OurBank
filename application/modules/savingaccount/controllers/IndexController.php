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

class Savingaccount_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle = 'Savings';
        $this->view->title = 'Accounting';
        $this->view->accounts = new Savingaccount_Model_Accounts();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();
    }
    public function indexAction() 
    {
        $accountsForm = $this->view->form = new Savingaccount_Form_Accounts();
        if ($this->_request->getPost('Submit')) {
			$formData = $this->_request->getPost();
			if ($accountsForm->isValid($formData)) {
			    $this->view->result = $this->view->accounts->search($this->_request->getParam('membercode'));
			}
        }
    }
    public function detailsAction() 
    {
        $code= base64_decode($this->_request->getParam('code'));
        $this->view->result = $this->view->accounts->getDetails($code);
        $this->view->code = $code;
        $this->view->savingsProducts = $this->view->accounts->fetchSavingsProducts($code);
        $this->view->account = $this->view->accounts->accountsSearch($code);
    }
    public function createaccountAction()
    {
    	$productId = base64_decode($this->_request->getParam('Id'));
    	$code = base64_decode($this->_request->getParam('code'));
        $this->view->account = $this->view->accounts->details($productId,$code);
        $this->view->interestRates = $this->view->accounts->getInterestRates($productId,$code);
        foreach ($this->view->account as $account) {
            $minDeposite = $account->minbalance; // Validate for min balance
			$officeid = $account->officeid;
        }
        $savingForm = new Savingaccount_Form_Savings(50,$this->_request->getParam('Id'),$this->_request->getParam('code'));
		if (substr($code,4,1) == 2) {
			$group = $this->view->accounts->getMember($officeid);
			foreach ($group as $group) {
				$savingForm->group->addMultiOption($group->id,$group->name);
			}
		}	
        $this->view->savingsForm = $savingForm;
        if ($this->_request->getPost('Submit')) {
	    	$formData = $this->_request->getPost();
			if ($savingForm->isValid($formData)) {
		    	foreach ($this->view->account as $account) {
					$begindate = $account->begindate;
					$officeid = $account->officeid;
					$typeID = $account->typeID;
					$glsubID = $account->glsubID;
					$memberId = $account->id;
		    	}
					if ($this->view->cl->phpmysqlformat($this->_request->getPost('date')) < $begindate) {
					$this->view->maxdate= "Date of account should be After - ".$this->view->cl->phpnormalformat($begindate) ;
					} else {
					// Insertion into ourbank_account 
					$data = array('account_number' => 1,
										'member_id' => $memberId,
										'product_id' => $productId,
										'begin_date' => $begindate,
										'membertype_id' => $typeID,
										'accountcreated_date'=> $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
										'created_by' => 1,
										'status_id'=>1);
					$accId = $this->view->adm->addRecord('ourbank_accounts',$data);
					// Account number formation 
					// <-----------14 digit number ---------->
					// <--3-->/<--2-->/<--2-->/<--1-->/<--6-->
					// 00office_id/0membertype_id/0product_id/typeofacc [L/S/F/R]/00000account_id
					$b=str_pad($officeid,3,"0",STR_PAD_LEFT); 
					$t=str_pad($typeID,2,"0",STR_PAD_LEFT);
					$p=str_pad($productId,2,"0",STR_PAD_LEFT);
					$i= "S";
					$a=str_pad($accId,6,"0",STR_PAD_LEFT);
                        $account = array('account_number' =>$b.$t.$p.$i.$a);
                        $this->view->accounts->accUpdate($accId,$account);
					// Insertion into transaction 
					$input = array('account_id' => $accId,
                                      'glsubcode_id_to' => $glsubID,
                                      'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                      'amount_to_bank' => $this->_request->getPost('amount'),
                                      'paymenttype_id' => 1,
                                      'transactiontype_id' => 1,
                                      'recordstatus_id' => 3,
                                      'transaction_description'=> "Opening amount",
                                      'balance' => $this->_request->getPost('amount'),
                                      'confirmation_flag' => 0,
                                      'created_by' => 1);
      		        $tranID = $this->view->adm->addRecord('ourbank_transaction',$input);
      		        // Insertion into saving transaction 
      		        $saving = array('transaction_id' => $tranID,
      		                      'account_id' => $accId,
                                      'transaction_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
                                      'transactiontype_id' => 1,
                                      'glsubcode_id_to' => $glsubID,
                                      'amount_to_bank' => $this->_request->getPost('amount'),
                                      'paymenttype_id' => 1,
                                      'transaction_description'=> "Opening amount",
                                      'transaction_by' => 1);
      		        $this->view->adm->addRecord('ourbank_savings_transaction',$saving);
					// Insertion into Liabilities
					$liabilities = array('office_id' => $officeid,
										'glsubcode_id_from' => '',
                                             'glsubcode_id_to' => $glsubID,
                                             'transaction_id' => $tranID,
                                             'credit' => $this->_request->getPost('amount'),
                                             'record_status'=> 3);
     		        $this->view->adm->addRecord('ourbank_Liabilities',$liabilities);
     		        $glresult = $this->view->accounts->getGlcode($officeid);
     		        foreach ($glresult as $glresult) {
     		             $cashglsubocde = $glresult->id;
     		        }
                    // Insertion into Assets ourbank_Assets
                    $assets =  array('office_id' => $officeid,
                                         'glsubcode_id_from' => '',
                                         'glsubcode_id_to' => $cashglsubocde,
                                         'transaction_id' => $tranID,
                                         'credit' => $this->_request->getPost('amount'),
                                         'record_status' => 3);
       		        $this->view->adm->addRecord('ourbank_Assets',$assets);
					// Group Acc + Transaction entry
					if ($this->_request->getPost('group')) {
						$this->view->accounts->goupAcc($this->_request->getPost('group'),
														$productId,
														$accId,
														$this->_request->getPost('amount'),
														$tranID,
														$this->view->cl->phpmysqlformat($this->_request->getPost('date')));

					}
       		        $this->_redirect("/savingaccount/index/message/acNum/".base64_encode($b.$t.$p.$i.$a));
        	    }
			}
	    }
    }
    public function messageAction() 
    {
        $this->view->pageTitle = 'Accounting';
		$this->view->acNum = base64_decode($this->_request->getParam('acNum'));
    }
}

