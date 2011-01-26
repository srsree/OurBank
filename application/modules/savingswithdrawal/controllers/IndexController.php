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
class Savingswithdrawal_IndexController extends Zend_Controller_Action
{
	public function init() 
	{
    	$this->view->title = "Savings";
		$this->view->pageTitle = "Savings withdrawal";
		$this->view->type='savings';
        $this->view->savingsModel = new Savingswithdrawal_Model_Withdrawal ();
        $this->view->cl = new Creditline_Model_dateConvertor ();
        $this->view->adm = new App_Model_Adm ();
	}
	public function indexAction() 
	{
		$this->view->form = new Savingswithdrawal_Form_Search();
	}
	public function withdrawalAction()
	{
		$accNum = $this->view->accNum = $this->_request->getParam('accNum');
		$this->view->details = $this->view->savingsModel->search($this->_request->getParam('accNum'));
		$this->view->tran = $this->view->savingsModel->transaction($this->_request->getParam('accNum'));
		$form = new Savingswithdrawal_Form_Withdrawal($this->view->accNum);
		$this->view->form = $form;
		$mode = $this->view->adm->viewRecord("ourbank_paymenttypes","id","DESC");
		foreach($mode as $mode) {
			$form->transactionMode->addMultiOption($mode['id'],$mode['description']);
		}
		//if group members
		if (substr($accNum,4,1) == 2) {
			$this->view->group = $this->view->savingsModel->getMember($accNum);
		}
        if ($this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
				$this->view->savingsModel->deposit($this->view->accNum,$form->getValues());
				$this->_redirect("/savingswithdrawal/index/message/amt/".base64_encode($this->_request->getPost('amount'))."/accNum/".base64_encode($this->view->accNum));
			}
		}
	}
    public function messageAction() 
    {
        $this->view->amt = base64_decode($this->_request->getParam('amt'));
        $this->view->accNum = base64_decode($this->_request->getParam('accNum'));
    }
}


	

