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
 *  create an Dcb controller for view and pdf
 */
class Dcb_IndexController extends Zend_Controller_Action
{
	
	public function init(){ 
         $this->view->pageTitle = $this->view->translate('Demand collections & balance');
         $this->view->dateconvert=new App_Model_dateConvertor();
         $this->view->tilte = $this->view->translate('Reports');
         $this->view->type = "others";
         $this->view->adm = new App_Model_Adm();
	}
        //view action
	public function indexAction()
	{ 
		$this->view->pageTitle = "Demand collections & balance";
		$this->view->tilte = "Reports";
		$searchForm = new Dcb_Form_Search();
		$this->view->form = $searchForm;
	
		if ($this->_request->isPost() && $this->_request->getPost('Search')){
			$fromDate = $this->_request->getParam('datefrom');
			$toDate = $this->_request->getParam('dateto');
			if($fromDate && $toDate) { $this->view->savings = "10"; 
				$this->view->resultshow = "From <font color=#039>".$fromDate."</font> <br>To <font color=#039>".$toDate."</font>";
				$Loandemand = new Dcb_Model_Dcb();
			
				$this->view->office= $Loandemand->office();

				$this->view->accounts= $Loandemand->fetchloanDetails();
				$dayArray=array();

				$fromDate=$this->view->dateconvert->phpmysqlformat($fromDate);

				$dayArray= $this->findFirstAndLastDay($fromDate);
					
				$this->view->fromdate = $dayArray[0];
				$this->view->todate = $dayArray[1];
			}
		}
	}
	
	function findFirstAndLastDay($anyDate)
	{
	
		list($yr,$mn,$dt) =    split('-',$anyDate);    // separate year, month and date
		$timeStamp        =    mktime(0,0,0,$mn,1,$yr);    //Create time stamp of the first day from the give date.
		$firstDay         =    date('Y-m-d',$timeStamp);    //get first day of the given month
		list($y,$m,$t)    =    split('-',date('Y-m-t',$timeStamp)); //Find the last date of the month and separating it
		$lastDayTimeStamp =    mktime(0,0,0,$m,$t,$y);//create time stamp of the last date of the give month
		$lastDay          =    date('Y-m-d',$lastDayTimeStamp);// Find last day of the month
		$arrDay           =    array("$firstDay","$lastDay"); // return the result in an array format.
	
		return $arrDay;
	}
        //report display
	public function reportdisplayAction() 
	{
	
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file'); 
	
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];
	
		$this->view->filename = "/".$projname."/reports/".$file1;    
	}
        //pdf display
	public function pdfdisplayAction() 
	{ 
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
		$pdf->pages[] = $page;
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];
		// Image path
		$image_name = "/var/www/".$projname."/public/images/logo.jpg";
		$Loandemand = new Dcb_Model_Dcb();
		$demand = $Loandemand->fetchloanDetails();
		$this->view->currentLoan = $demand;
		// Image
		$image = Zend_Pdf_Image::imageWithPath($image_name);
                $page->drawImage($image, 25, 520, 125, 570);

//                 $page->drawText("Date : ".date('d-m-Y'),550, 800); //date('Y-m-d')
//                 $page->drawText("Date : ".date('d-m-Y'),550, 800); 
		$page->setLineWidth(1)->drawLine(25, 25, 810, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 570); //left vertical
		$page->setLineWidth(1)->drawLine(810, 25, 810 ,570); //right vertical
		$page->setLineWidth(1)->drawLine(25, 570, 810, 570); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
	
		$text = array("Acc no.","pri 1","Int 2","Pri 3","Int 4","T.pri 5","T.int 6","pri 7","Int 8","Pri 9","pri 10","Int 11","pri 12","Int 13","Int 14");
		$pdfData = $pdf->render();
		$x0 = 25; 
		$x1 = 120;
		$x2 = 170;
		$x3 = 210;
		$x4 = 270;
		$x5 = 310;
		$x6 = 365;
		$x7 = 405;
		$x8 = 457;
		$x9 = 495;
		$x10 = 550;
		$x11 = 590;
		$x12 = 645;
		$x13 = 685;
		$x14 = 740;
	
		$this->view->title = "Reports";
	        $my = 500;
                $my1 = 515;
                
		$page->drawLine(25, $my1, 810, $my1);

		$page->drawLine(25, 495, 810, 495);

		$page->drawText($text[0], $x0, $my);
		$page->drawText($text[1], $x1, $my);
		$page->drawText($text[2], $x2, $my);
		$page->drawText($text[3], $x3, $my);
		$page->drawText($text[4], $x4, $my);
		$page->drawText($text[5], $x5, $my);
		$page->drawText($text[6], $x6, $my);
		$page->drawText($text[7], $x7, $my);
		$page->drawText($text[8], $x8, $my);
		$page->drawText($text[9], $x9, $my);
		$page->drawText($text[10], $x10, $my);
		$page->drawText($text[11], $x11, $my);
		$page->drawText($text[12], $x12, $my);
		$page->drawText($text[13], $x13, $my);
		$page->drawText($text[14], $x14, $my);
	
	
		$y1 = 480;
		$totalAmount="0"; 
		$totalinterest="0"; 
		$currentamount="0";
		$currentinterest="0";
		$totalprincipal="0"; 
		$totalint="0";
		$aprin="0";
		$aint="0"; 
		$npri="0"; 
		$nint="0"; 
		$totpri="0";
		$totint="0";
		$fprinci="0"; 
		$fint="0";
	
		$Loandemand = new Dcb_Model_Dcb();
		$demand = $Loandemand->fetchloanDetails();
	
		foreach($demand as $savingsCredit) {
		$page->drawText($savingsCredit->account_number,$x0, $y1);
		$page->drawText($savingsCredit->amount,$x1, $y1);
		$page->drawText($savingsCredit->interest,$x2, $y1);
		$page->drawText($savingsCredit->currentamount,$x3, $y1);
		$page->drawText($savingsCredit->currentinterest,$x4, $y1);
		$page->drawText($savingsCredit["amount"]+$savingsCredit["currentamount"],$x5, $y1);
		$page->drawText($savingsCredit["interest"]+$savingsCredit["currentinterest"],$x6, $y1);
		$page->drawText($savingsCredit->paidamount,$x7, $y1);
		$page->drawText($savingsCredit->paidinterest,$x8, $y1);
		$page->drawText($savingsCredit->nextamount,$x9, $y1);
		$page->drawText($savingsCredit->nextinterest,$x10, $y1);
		$page->drawText($savingsCredit["paidamount"]+$savingsCredit["nextamount"],$x11, $y1);
		$page->drawText($savingsCredit["paidinterest"]+$savingsCredit["paidinterest"],$x12, $y1);
		$page->drawText($savingsCredit["amount"]+$savingsCredit["currentamount"]-($savingsCredit["paidamount"]+$savingsCredit["nextamount"]),$x13, $y1);
		$page->drawText($savingsCredit["interest"]+$savingsCredit["currentinterest"]-($savingsCredit["paidinterest"]+$savingsCredit["paidinterest"]),$x14, $y1);
		$y1 = $y1 - 25;
					
	
					$totalAmount = $totalAmount + $savingsCredit->amount;
					$totalinterest = $totalinterest + $savingsCredit["interest"]; 
					$currentamount = $currentamount + $savingsCredit["currentamount"];
					$currentinterest = $currentinterest + $savingsCredit["currentinterest"];
					$totalprincipal = $totalprincipal + $savingsCredit["amount"]+$savingsCredit["currentamount"]; 
					$totalint = $totalint + $savingsCredit["interest"]+$savingsCredit["currentinterest"]; 
					$aprin = $aprin + $savingsCredit["paidamount"]; 
					$aint = $aint + $savingsCredit["paidinterest"]; 
					$npri = $npri + $savingsCredit["nextamount"];
					$nint = $nint + $savingsCredit["nextinterest"]; 
					$totpri = $totpri + $savingsCredit["paidamount"]+$savingsCredit["nextamount"]; 
					$totint = $totint + $savingsCredit["paidinterest"]+$savingsCredit["nextinterest"]; 
					$fprinci = $fprinci+$savingsCredit["amount"]+$savingsCredit["currentamount"]-($savingsCredit["paidamount"]+$savingsCredit["nextamount"]);
					$fint = $fint+$savingsCredit["interest"]+$savingsCredit["currentinterest"]-($savingsCredit["paidinterest"]+$savingsCredit["nextinterest"]);
	
		}
		$page->drawText("TOTAL",$x0,$y1);
		$page->drawText($totalAmount,$x1,$y1);
                $page->drawLine($x1-5, $y1-15, $x1-5, $my1);

		$page->drawText($totalinterest,$x2,$y1);
                $page->drawLine($x2-5, $y1-15, $x2-5, $my1);

		$page->drawText($currentamount,$x3,$y1);
                $page->drawLine($x3-5, $y1-15, $x3-5, $my1);

		$page->drawText($currentinterest,$x4,$y1);
                $page->drawLine($x4-5, $y1-15, $x4-5, $my1);

		$page->drawText($totalprincipal,$x5,$y1);
                $page->drawLine($x5-5, $y1-15, $x5-5, $my1);

		$page->drawText($totalint,$x6,$y1);
                $page->drawLine($x6-5, $y1-15, $x6-5, $my1);

		$page->drawText($aprin,$x7,$y1);
                $page->drawLine($x7-5, $y1-15, $x7-5, $my1);

		$page->drawText($aint,$x8,$y1);
                $page->drawLine($x8-5, $y1-15, $x8-5, $my1);

		$page->drawText($npri,$x9,$y1);
                $page->drawLine($x9-5, $y1-15, $x9-5, $my1);

		$page->drawText($nint,$x10,$y1);
                $page->drawLine($x10-5, $y1-15, $x10-5, $my1);

		$page->drawText($totpri,$x11,$y1);
                $page->drawLine($x11-5, $y1-15, $x11-5, $my1);

		$page->drawText($totint,$x12,$y1);
                $page->drawLine($x12-5, $y1-15, $x12-5, $my1);


		$page->drawText($fprinci,$x13,$y1);
                $page->drawLine($x13-5, $y1-15, $x13-5, $my1);

		$page->drawText($fint,$x14,$y1);
		$page->drawLine(25, $y1-15, 810, $y1-15);// after table horizontal line


                $page->drawLine($x14-5, $y1-15, $x14-5, $my1);

		$pdf->save('/var/www/'.$projname.'/reports/DCB.pdf');
		$path = '/var/www/'.$projname.'/reports/DCB.pdf';
	        chmod($path,0777);
                $this->_redirect('dcb/index');
	}
}
