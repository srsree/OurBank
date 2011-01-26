<?php
class Loandetailsg_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
    	$this->view->title = "Loans";
		$this->view->pageTitle = "Loans details";
		$this->view->type='loans';
        $this->view->loanModel = new Loandetailsg_Model_loandetails();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();
    }

    public function indexAction() 
    {
		$loansearch = new Loandetailsg_Form_Search();
		$this->view->form = $loansearch;
		$loantransactions = new Loandisbursment_Model_loan();
    }

    public function loandetailsAction() 
    {
		$this->view->details = $this->view->loanModel->searchaccounts($this->_request->getParam('accNum'));
		$this->view->instalments = $this->view->loanModel->loanInstalments($this->_request->getParam('accNum'));
		$this->view->paid = $this->view->loanModel->paid($this->_request->getParam('accNum'));
		$this->view->unpaid = $this->view->loanModel->unpaid($this->_request->getParam('accNum'));
    }
}
