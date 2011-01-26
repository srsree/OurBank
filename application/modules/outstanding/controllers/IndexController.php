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
class Outstanding_IndexController extends Zend_Controller_Action
{

     function init()
     { 
         $this->view->pageTitle = $this->view->translate("Clients Outstanding");
	$this->view->type='loans';
	$sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid;
        $login=new App_Model_Users();
        $loginname=$login->username($userid);
        foreach($loginname as $loginname) 
	{
          $this->view->username=$loginname['username'];
        }
     }

//find outstanding for clients
     function indexAction()
     {
	$searchForm = new Outstanding_Form_Search();
        $this->view->form = $searchForm;

        $outstanding = new Outstanding_Model_outstanding();
//load bank names 
        $subBranch = $outstanding->getBranchOffice();
        foreach($subBranch as $subBranch) 
            {
                $searchForm->bank->addMultiOption($subBranch['id'],$subBranch['name']);
            }
//load activity names
 	$subActivity = $outstanding->getActivity();
        foreach($subActivity as $subActivity) 
            {
                $searchForm->activity->addMultiOption($subActivity['id'],$subActivity['name']);
            }
//load credit line names
	$creditline = $outstanding->getcreditline();
        foreach($creditline as $creditline) 
            {
                $searchForm->creditline->addMultiOption($creditline['id'],$creditline['name']);
            }	

//month and year
	$start_year = date('Y')-50;
	$end_year = date('Y')+10;
	for ($i=$start_year; $i<=$end_year; $i++) {
	$searchForm->year->addMultiOption($i,$i);
	}
	$month=array(	'01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	$searchForm->month->addMultiOptions($month);

//searching client outstanding balance...
        if ($this->_request->isPost() && $this->_request->getPost('Search')) 
            {
                $formData = $this->_request->getPost();

		$this->view->bank = $bankname = $this->_request->getParam('bank');
		$this->view->activity = $activity = $this->_request->getParam('activity');
		$this->view->creditid = $credit_id = $this->_request->getParam('creditline');
		$this->view->month = $month = $this->_request->getParam('month');
		$this->view->year = $year = $this->_request->getParam('year');
		$bank = $outstanding->getbankname($bankname);
		foreach($bank as $bankresult) { $this->view->bankname = $bankresult['name']; }
		$active=$outstanding->getactivityname($activity);	
		foreach($active as $activename)	{$this->view->activityname =$activename['name']; }
		$creditname=$outstanding->getcreditname($credit_id);	
		foreach($creditname as $creditname)	{$this->view->creditname =$creditname['name']; }

//validation part
	      if ($searchForm->isValid($formData))
                {
                        $Balance=$outstanding->loanSearchh($bankname,$activity,$credit_id,$month,$year);
                    }
                   $this->view->clientView = $Balance;
		    if (!$Balance)
                    {
                      echo "<font color='red'>Record is not found and Try again </font>";
                    }
                    }
		
                 }

//display the pdf report in new windows
	function reportdisplayAction() {
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

//create pdf report for client outstanding reports...
	function pdftransactionAction()
	{	
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;
		$outstanding = new Outstanding_Model_outstanding();
                //set dynamic path...
		$baseURl=$this->view->baseUrl();
		$word=explode('/',$baseURl);
		$projname='';
		for($i=0; $i<count($word); $i++){
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
	

		$image_name = "/var/www".$baseURl."/images/logo.jpg";
		$image = Zend_Pdf_Image::imageWithPath($image_name);
		//$page->drawImage($image, 25, 770, 570, 820);
	
		$page->drawImage($image, 30, 770, 130, 820);
		$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
		$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
		$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
                //get the paramemters list
		$bankname = $this->_request->getParam('bankname');
        	$activity = $this->_request->getParam('activity');
		$credit_id = $this->_request->getParam('creditline');
		$month = $this->_request->getParam('month');
		$year = $this->_request->getParam('year');

		$bank = $outstanding->getbankname($bankname);
		foreach($bank as $bankresult) { 
			if($bankresult['name'])
			{$this->view->bankname=$bankresult['name'];}else{ $this->view->bankname="All banks"; } 
		}

		$active=$outstanding->getactivityname($activity);	
		foreach($active as $activename)	{ 
		if($activename['name'])	{
                $this->view->activityname=$activename['name'];}else{ $this->view->activityname="All activity"; }
		}

		$creditname1=$outstanding->getcreditname($credit_id);	
		foreach($creditname1 as $creditname){ 
		if($creditname['name'])
		{  $this->view->creditname=$creditname['name'];}else{ $this->view->creditname="All creditline"; }
		}
		$text=array($this->view->translate("Client outstanding Balance"),$this->view->translate("Account number"),$this->view->translate("Name"),$this->view->translate("Loan amount"),$this->view->translate("Outstanding balance"),$this->view->translate("Total"));
		$x1 = 80; 
		$x2=250;
		$x3 = 200;
		$x4 = 380;
		$x6 = 450;
		$y1= 670;
		$page->drawLine(50, 700, 550, 700);
	        $page->drawLine(50, 685, 550, 685);
		$page->drawText($this->view->translate("Bank:         ").$this->view->bankname, $x1, 740);
		$page->drawText($this->view->translate("Credit line: ").$this->view->activityname, $x1, 725);
		$page->drawText($this->view->translate("Activity:      ").$this->view->creditname, $x1, 710);
		$page->drawText($text[0], $x2, 760);
		$page->drawText($text[1], $x1, 688);
        	$page->drawText($text[2], $x3, 688);
		$page->drawText($text[3], $x4, 688);
		$page->drawText($text[4], $x6, 688);
		// calculate position from the left side...
		function position($amt,$posValue) {
                       $len=strlen($amt);
                       $pos=($posValue-35)-($len*4);
                       return $pos;
                }
		$this->view->clientView=$Balance=$outstanding->loanSearchh($bankname,$activity,$credit_id,$month,$year);
		$outstandingtotal = "0";
		$loantotal = "0";
		foreach($Balance as $resultbalance)
		{
		$outstandingtotal += $resultbalance['SUM(e.accountinstallment_amount)'];
		$loantotal += $resultbalance['loan_amount'];
		$page->drawText($resultbalance['account_number'],$x1, $y1);
		$page->drawText($resultbalance['member_name'],$x3, $y1);

		$pos=position(sprintf("%4.2f",$resultbalance['loan_amount']),$x6+15);
                $page->drawText(sprintf("%4.2f",$resultbalance['loan_amount']),$pos+2,$y1);
 // 		$page->drawText($resultbalance['loan_amount'],$x4, $y1);

 		$accamount = $resultbalance['SUM(e.accountinstallment_amount)'];
		$pos=position(sprintf("%4.2f",$accamount),565);
                $page->drawText(sprintf("%4.2f",$accamount),$pos+2,$y1);

 		//$page->drawText($accamount,$x6, $y1);
		$y1 -= 15;
		}
		$page->drawLine(50, $y1, 550, $y1);
        	$y2=$y1-10;
		$page->drawText($text[5], $x1, $y2);

		$pos=position(sprintf("%4.2f",$loantotal),$x6+15);
                $page->drawText(sprintf("%4.2f",$loantotal),$pos+2,$y1-10);

		$pos=position(sprintf("%4.2f",$loantotal),565);
                $page->drawText(sprintf("%4.2f",$outstandingtotal),$pos+2,$y1-10);
	
		$y3=$y2-5;
		$page->drawLine(50, $y3, 550, $y3);
		$pdfData = $pdf->render();	
                //save the file and give the permission...
		$pdf->save('/var/www'.$projname.'/reports/outstanding.pdf');
		$path = '/var/www'.$projname.'/reports/outstanding.pdf';
		chmod($path,0777);

		//$this->_redirect('/outstanding/index/reportdisplay/file/outstanding.pdf');	
               //s $this->_redirect('/outstanding');	
	}
        }


