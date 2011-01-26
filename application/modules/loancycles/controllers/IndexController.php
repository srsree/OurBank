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

class Loancycles_IndexController extends Zend_Controller_Action
{
	function init() { 
		$this->view->pageTitle = "Loan cycle details";
	$sessionName = new Zend_Session_Namespace('ourbank');
	$this->view->type = "others";
	$userid=$this->view->createdby = $sessionName->primaryuserid;
	$login=new App_Model_Users();
	$loginname=$login->username($userid);
	foreach($loginname as $loginname) {
	$this->view->username=$loginname['username'];
}
		$this->view->adm = new App_Model_Adm();

	}

	function indexAction() {
		$searchForm = new Loancycles_Form_Search();
		$this->view->form = $searchForm;
$bankdetail = new Loancycles_Model_Loancycle();

	$bankdetail = new Cbtransaction_Model_Cbtransaction();

       		$institution = $this->view->adm->viewRecord("ob_institution","id","DESC");

			foreach($institution as $institution) {
				$searchForm->field3->addMultiOption($institution['id'],$institution['name']);
			}
		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
			if ($this->_request->isPost()) {
		$date1= $this->_request->getParam('field1');
		$date2= $this->_request->getParam('field2');
		$bank= $this->_request->getParam('field3');
		$bankmonthlydetail = new Loancycles_Model_Loancycle();
		if($date1 && $date2 && $bank) {
			$banktransaction = $bankdetail->Searchyearbanktransaction($date1,$date2,$bank);
				if (!$banktransaction) {
					echo 'No Transactions yet Records';
				}else {
					$this->view->cbtransactiondetail = $banktransaction;
				}
			}

		if($bank && !$date1 && !$date2) {
		$bankacctransaction = $bankmonthlydetail->Searchbanktransaction($bank);
		if (!$bankacctransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $bankacctransaction;

		}}

		if(!$bank && $date1 && $date2) {
		$banknulltransaction = $bankmonthlydetail->Searchnullaccounttransaction($date1,$date2);
		if (!$banknulltransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $banknulltransaction;

		}}


		if(!$bank && !$date1 && !$date2) {
		$bankdacctransaction = $bankmonthlydetail->Searchalltransaction();
		if (!$bankdacctransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $bankdacctransaction;
		}}

				$this->view->field1 = $date1;
				$this->view->field2 = $date2;
				$this->view->field3 = $bank;
			
	}}}

public function reportdisplayAction() {
               $app = $this->view->baseUrl();
               $word=explode('/',$app);
               $projname='';
               for($i=0; $i<count($word); $i++){
                       if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
               }
               $this->_helper->layout->disableLayout();
               $file1 = $this->_request->getParam('file');
               $this->view->filename = $projname."/reports/".$file1;
       }

public function pdfdisplayAction() 
{ 

	$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;

	$app = $this->view->baseUrl();
	$word=explode('/',$app);
	$projname='';
			for($i=0; $i<count($word); $i++){
					if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
			}   
// Image
	$image_name = "/var/www".$app."/images/logo.jpg";
		$image = Zend_Pdf_Image::imageWithPath($image_name);
		//$page->drawImage($image, 25, 770, 570, 820);
	$page->drawImage($image, 30, 770, 130, 820);
		$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
		$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
		$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
	
		$text = array("Member name",
					"Account number",
					"Bank name",
					"Loan amount",
					"Paid",
					"Balance","Cycle","Close date");
		$x0 = 50; 
		$x1 = 120; 
		$x2 = 200; 
		$x3 = 260;
		$x4 = 340;
		$x5 = 375;
		$x6 = 430;
		$x7 = 485;



$y1 = 700;

//         $page->drawText("jinu", 300, 600);

		$page->drawLine(50, 740, 550, 740);
		$page->drawLine(50, 720, 550, 720);
		$page->drawText($text[0], $x0, 725);
		$page->drawText($text[1], $x1, 725);
		$page->drawText($text[2], $x2, 725);
		$page->drawText($text[3], $x3, 725);
		$page->drawText($text[4], $x4, 725);
		$page->drawText($text[5], $x5, 725);
		$page->drawText($text[6], $x6, 725);
		$page->drawText($text[7], $x7, 725);

	$date1 = $this->_request->getParam('field1'); 
	$date2= $this->_request->getParam('field2');
	$bank = $this->_request->getParam('field3');



		$bankmonthlydetail = new Loancycles_Model_Loancycle();
		if($date1 && $date2 && $bank) {
			$banktransaction = $bankdetail->Searchyearbanktransaction($date1,$date2,$bank);
				if (!$banktransaction) {
					echo 'No Transactions yet Records';
				}else {
					$this->view->cbtransactiondetail = $banktransaction;
				}
			}

		if($bank && !$date1 && !$date2) {
		$bankacctransaction = $bankmonthlydetail->Searchbanktransaction($bank);
		if (!$bankacctransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $bankacctransaction;

		}}

		if(!$bank && $date1 && $date2) {
		$banknulltransaction = $bankmonthlydetail->Searchnullaccounttransaction($date1,$date2);
		if (!$banknulltransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $banknulltransaction;

		}}


		if(!$bank && !$date1 && !$date2) {
		$bankdacctransaction = $bankmonthlydetail->Searchalltransaction();
		if (!$bankdacctransaction) {
		echo 'No Transactions yet Records';
		} else {
		$this->view->cbtransactiondetail = $bankdacctransaction;
		}}

			foreach($this->view->cbtransactiondetail as $savingsCredit) {
			$page->drawText($savingsCredit['member_name'],$x0, $y1);
			$page->drawText($savingsCredit['account_number'],$x1, $y1);
			$page->drawText($savingsCredit['Institute_bank_name'],$x2, $y1);
			$page->drawText($savingsCredit['loan_amount'],$x3, $y1);
			$page->drawText($savingsCredit['loaninstallmentpaid_amount'],$x4, $y1);
			$page->drawText($savingsCredit['balance'],$x5, $y1);
			$page->drawText($savingsCredit['totac'],$x6, $y1);
			$page->drawText($savingsCredit['accountinstallment_date'],$x7, $y1);
					$y1 = $y1 - 25;
		}
	

		$pdfData = $pdf->render();

		$pdf->save('/var/www'.$projname.'/reports/Loancycle.pdf');
		$path = '/var/www'.$projname.'/reports/Loancycle.pdf';

		chmod($path,0777);


}

}
