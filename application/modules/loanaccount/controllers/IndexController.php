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
class Loanaccount_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle = 'Loans';
        $this->view->title = 'Accounting';
        $this->view->accounts = new Loanaccount_Model_Accounts();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();
    }

    public function indexAction() 
    {
        $accountsForm = $this->view->form = new Savingaccount_Form_Accounts();
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
			$formData = $this->_request->getPost();
			if ($accountsForm->isValid($formData)) {
			    $this->view->result = $this->view->accounts->search($this->_request->getParam('membercode'));
			}
        }
    }

    public function detailsAction() 
    {
        $code = base64_decode($this->_request->getParam('code'));
        $this->view->result = $this->view->accounts->getDetails($code);
        $this->view->code = $code;
        $this->view->products = $this->view->accounts->fetchLoanProducts($code);
        $this->view->account = $this->view->accounts->accountsSearch($code);
    }

    public function createaccountAction()
    {
    	$productId = base64_decode($this->_request->getParam('Id'));
    	$code = base64_decode($this->_request->getParam('code'));
        $this->view->account = $this->view->accounts->details($productId,$code);
        $this->view->interestRates = $this->view->accounts->getInterestRates($productId);
        foreach ($this->view->account as $account) {
            $minDeposite = $account->minamount; // Validate for min balance
            $minInstallments = $account->minInstallments; 
            $maxInstallments = $account->maxInstallments; 
			$officeid = $account->officeid;
        }
        $app = $this->view->baseUrl();
        $loanForm = new Loanaccount_Form_Loans($minDeposite,$this->_request->getParam('Id'),$this->_request->getParam('code'),$app);
		if (substr($code,4,1) == 2) {
			$group = $this->view->accounts->getMember($officeid);
			foreach ($group as $group) {
				$loanForm->group->addMultiOption($group->id,$group->name);
			}
		}
        for($i=$minInstallments;$i<=$maxInstallments;$i++)  {
		$loanForm->installments->addMultiOption($i,$i);
		}
		$interesttypes = $this->view->adm->viewRecord('ourbank_interesttypes','id','DESC');
		foreach($interesttypes as $interesttypes) {
			$loanForm->interesttype_id->addMultiOption($interesttypes->id,$interesttypes->description);
		}
		$acc = $this->view->accounts->savingAcc($code);
		foreach($acc as $acc) {
			$loanForm->savingAccount->addMultiOption($acc->id,$acc->account_number);
		}
		
		$funder = $this->view->adm->viewRecord('ob_funding','id','DESC');
		foreach($funder as $funder) {
			$loanForm->funders->addMultiOption($funder->id,$funder->name);
		}
	
        $this->view->loanForm = $loanForm;
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
			$formData = $this->_request->getPost();
			if ($loanForm->isValid($formData)) {
		    	foreach ($this->view->account as $account) {
					$begindate = $account->begindate;
					$closedate = $account->closedate;	
					$officeid = $account->officeid;
					$typeID = $account->typeID;
					$glsubID = $account->glsubID; 
					$closedate = $account->closedate;
					$memberId = $account->memberId;	
				}
				if ($this->view->cl->phpmysqlformat($this->_request->getPost('date')) < $begindate) {
					$this->view->maxdate= "Date of account should be after - ".$this->view->cl->phpnormalformat($begindate) ;
				} else if ($this->view->cl->phpmysqlformat($this->_request->getPost('date')) > $closedate) {
					$this->view->maxdate= "Date of account should be before - ".$this->view->cl->phpnormalformat($closedate) ;
	
				} else {
					// Insertion into ourbank_account 
					$data = array('account_number' => 1,
										'member_id' => $memberId,
										'product_id' => $productId,
										'begin_date' => $begindate,
										'close_date' => $closedate,
										'membertype_id' => $typeID,
										'accountcreated_date'=> $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
										'created_by' => 1,
										'status_id'=>3);
					$accId = $this->view->adm->addRecord('ourbank_accounts',$data);
					// Account number formation 
					// <-----------14 digit number ---------->
					// <--3-->/<--2-->/<---->/<--3-->/<--6-->
					// 00office_id/0membertype_id/00typeofacc [L/S/F/R]/00000account_id
					$b=str_pad($officeid,3,"0",STR_PAD_LEFT); 
					$t=str_pad($typeID,2,"0",STR_PAD_LEFT);
					$p=str_pad($productId,2,"0",STR_PAD_LEFT);
					$i = "L";
					$a=str_pad($accId,6,"0",STR_PAD_LEFT);
							$account = array('account_number' =>$b.$t.$p.$i.$a);
							$this->view->accounts->accUpdate($accId,$account);
					//Insertion into loan account
					$input = array('account_id' => $accId,
										'funder_id' => $this->_request->getPost('funders') ,
										'loansanctioned_date' => $this->view->cl->phpmysqlformat($this->_request->getPost('date')),
										'loan_amount' => $this->_request->getPost('amount'),
										'loan_installments' => $this->_request->getPost('installments'),
										'loan_interest' => $this->_request->getPost('interest'),
										'interesttype_id' => $this->_request->getPost('interesttype_id'),
										'savingsaccount_id' => $this->_request->getPost('savingAccount'),
										'tieup_flag' => 0,
										'created_by' => 1);
					$this->view->adm->addRecord('ourbank_loanaccounts',$input);
					// Group Acc entry
					if ($this->_request->getPost('group')) {
						$this->view->accounts->goupAcc($this->_request->getPost('group'),
														$productId,
														$accId,
														$this->_request->getPost('amount'),
														$tranID,
														$this->view->cl->phpmysqlformat($this->_request->getPost('date')));
					}
					$this->_redirect("/loanaccount/index/message/acNum/".base64_encode($b.$t.$p.$i.$a));
		    	}
			}
	   }
    }
    
    public function interestAction() 
    {
		$this->_helper->layout()->disableLayout();
		$this->view->interest = $this->view->accounts->getInterest($this->_request->getParam('productId'),$this->_request->getParam('interest'));
    }
    
    public function messageAction() 
    {
        $this->view->pageTitle = 'Accounting';
		$this->view->acNum = base64_decode($this->_request->getParam('acNum'));
    }
}

