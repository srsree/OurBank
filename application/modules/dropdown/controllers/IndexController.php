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
class dropdown_IndexController extends Zend_Controller_Action {
    public function init() {
        $this->view->pageTitle='Settings';
    }

    public function indexAction() {


	$this->view->title = "Drop Down";
	$tableName = $this->_request->getParam('tableName'); 
	
	if(isset($tableName)) {
	$this->view->table = 10;
	switch($tableName) {

	case "ourbank_gender" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_gender";
	$this->view->sex=$ledger->sex; 

	}
	break;

	case "ourbank_membermaritalstatus" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_membermaritalstatus";
	$this->view->membermaritalstatusdescription=$ledger->membermaritalstatusdescription;
	}
	break;

	case "ourbank_membertypes" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_membertypes";
	$this->view->membertype=$ledger->membertype;
	}
	break;

	case "ourbank_currency" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_currency";
	$this->view->currencyname=$ledger->currencyname;
	}
	break;

	case "ourbank_feefrequency" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_feefrequency";
	$this->view->feefrequencytype =$ledger->feefrequencytype;
	}
	break;
	case "ourbank_frequencyofpayment" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_frequencyofpayment";
	$this->view->timefrequencytype =$ledger->timefrequencytype;
	}
	break;

	case "ourbank_interesttypes" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_interesttypes";
	$this->view->description =$ledger->description;
	}
	break;

	case "ourbank_graceperiods" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_graceperiods";
	$this->view->graceperiodtype =$ledger->graceperiodtype;
	}
	break;

	case "ourbank_holidayrepayment" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_holidayrepayment";
	$this->view->repaymentdescription =$ledger->repaymentdescription;
	}
	break;

	case "ourbank_paymenttypes" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_paymenttypes";
	$this->view->repaymentdescription =$ledger->paymenttype_description;
	}
	break;

	case "ourbank_transaction_type" : 
	$ledger = new Ledger();
	$arrayTable = $ledger->tableContent($tableName);
	$this->view->tblcontent = $arrayTable;
	foreach($this->view->tblcontent as $ledger) {
	$this->view->tableName = "ourbank_transaction_type";
	$this->view->transaction_type =$ledger->transaction_type;
	}
	break;
       
	}
        
	}
	$sub2 = $this->_request->getPost('Add');
	if($sub2 == 'Add') {
	$tName= $this->_request->getParam('tName');
	$tInsert= $this->_request->getParam('tInsert');
	$pK= $this->_request->getParam('pK');
	$attribute= $this->_request->getParam('attribute');
	$ledger = new Ledger();
	$arrayTable = $ledger->insertContent($tName,array($pK =>'',
	$attribute =>$tInsert));

	}
	


    }
	
}

