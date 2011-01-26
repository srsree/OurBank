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

class Cbmonthlytransaction_IndexController extends Zend_Controller_Action
{
    function init() { 
        $this->view->pageTitle = "Community Bank Monthly Transaction";
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
        $searchForm = new Cbmonthlytransaction_Form_Search();
        $this->view->form = $searchForm;
$bankdetail = new Cbmonthlytransaction_Model_Cbmonthlytransaction();
$bank = $this->view->adm->viewRecord("ob_institution","id","DESC");
			foreach($bank as $bank){
				$searchForm->field3 ->addMultiOption($bank['id'],$bank['name']);
			}    
         if ($this->_request->isPost() && $this->_request->getPost('Search')) {
	   
            if ($this->_request->isPost()) {
		$month= $this->_request->getParam('field1');
		$year= $this->_request->getParam('field2');
		$bank= $this->_request->getParam('field3');
		$bankmonthlydetail = new Cbmonthlytransaction_Model_Cbmonthlytransaction();
 	
		if($month && $year && $bank) {
		$banktransaction = $bankmonthlydetail->Searchmonthlybanktransaction($month,$year,$bank);
		if (!$banktransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $banktransaction;
		}}

		elseif($bank && !$month && !$year) {
		$bankwisetransaction = $bankmonthlydetail->Searchbanktransaction($bank);
		if (!$bankwisetransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $bankwisetransaction;
		}}

		elseif(!$bank && $year && $month) {
		$datewisetransaction = $bankmonthlydetail->Searchmonthyearbanktransaction($year,$month);
		if (!$datewisetransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $datewisetransaction;
		}}

		elseif(!$bank && $year && !$month) {
		$yeartransaction = $bankmonthlydetail->Searchyearlybanktransaction($year);
		if (!$yeartransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $yeartransaction;
		}}

		elseif(!$bank && !$year && $month) {
		$yeartransaction = $bankmonthlydetail->Searchyearlybanktransaction($year);
		if (!$yeartransaction) {
		echo 'Please select a year';
		} else {
		}}

		elseif(!$bank && !$year && !$month) {
		$emptytransaction = $bankmonthlydetail->Searchalltransaction();
		if (!$emptytransaction) {
		echo 'No Transaction yet Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $emptytransaction;
		}}
$this->view->field1 = $month;
                $this->view->field2 = $year;
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
    
        $text = array("Account number",
                     "Transaction date",
                     "Activity name",
                     "bank name",
                     "credit",
                     "debit");
	$x0 = 60; 
	$x1 = 150; 
        $x2 = 230; 
        $x3 = 330;
        $x4 = 420;
        $x5 = 480;
        $x6 = 590;
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

	$month = $this->_request->getParam('field1'); 
	$year = $this->_request->getParam('field2');
	$bank = $this->_request->getParam('field3');

  

		$bankmonthlydetail = new Cbmonthlytransaction_Model_Cbmonthlytransaction();
		
		if($month && $year && $bank) {
		$banktransaction = $bankmonthlydetail->Searchmonthlybanktransaction($month,$year,$bank);
		if (!$banktransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $banktransaction;
		}}

		elseif($bank && !$month && !$year) {
		$bankwisetransaction = $bankmonthlydetail->Searchbanktransaction($bank);
		if (!$bankwisetransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $bankwisetransaction;
		}}

		elseif(!$bank && $year && $month) {
		$datewisetransaction = $bankmonthlydetail->Searchmonthyearbanktransaction($year,$month);
		if (!$datewisetransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $datewisetransaction;
		}}

		elseif(!$bank && $year && !$month) {
		$yeartransaction = $bankmonthlydetail->Searchyearlybanktransaction($year);
		if (!$yeartransaction) {
		echo 'No Transaction Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $yeartransaction;
		}}

		elseif(!$bank && !$year && $month) {
		$yeartransaction = $bankmonthlydetail->Searchyearlybanktransaction($year);
		if (!$yeartransaction) {
		echo 'Please select a year';
		} else {
		}}

		elseif(!$bank && !$year && !$month) {
		$emptytransaction = $bankmonthlydetail->Searchalltransaction();
		if (!$emptytransaction) {
		echo 'No Transaction yet Records';
		} else {
		$this->view->cbmonthlytransactiondetail = $emptytransaction;
		}}

		foreach($this->view->cbmonthlytransactiondetail as $savingsCredit) {
			$page->drawText($savingsCredit['account_number'],$x0, $y1);
			$page->drawText($savingsCredit['transaction_date'],$x1, $y1);
			$page->drawText($savingsCredit['activityname'],$x2, $y1);
			$page->drawText($savingsCredit['bankname'],$x3, $y1);
			$page->drawText($savingsCredit['amount_to_bank'],$x4, $y1);
			$page->drawText($savingsCredit['amount_from_bank'],$x5, $y1);

                       $y1 = $y1 - 25;
		}
    

		$pdfData = $pdf->render();

		$pdf->save('/var/www'.$projname.'/reports/Cbmonthtransaction.pdf');
		$path = '/var/www'.$projname.'/reports/Cbmonthtransaction.pdf';

        chmod($path,0777);


}
   
}
