<?php

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


class Loansupplementary_IndexController extends Zend_Controller_Action
{

    function init() { 
        $this->view->pageTitle = $this->view->translate('Loan Supplementary');
	$this->view->title =$this->view->translate('Reports');
        $this->view->type = "others";
    }

    function indexAction() {
        $searchForm = new Loansupplementary_Form_Search();
        $this->view->form = $searchForm;
        
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
            $formData = $this->_request->getPost();
            if ($searchForm->isValid($formData)) {  
                $Dispdate = $this->_request->getParam('datefrom'); 
 	        $this->view->field1 = $Dispdate;
	        $dateconvertor = new App_Model_dateConvertor();
                $Date = $dateconvertor->mysqlformat($Dispdate);
                $this->view->loan = 11;
                $transaction = new Loansupplementary_Model_Loansupplementary();
// //              //Loan Account Credit and Debit
                $loanCredit = $transaction->totalloanCredit($Date);
		$this->view->loanCredit=$loanCredit;

	        $loanDebit = $transaction->totalloanDebit($Date);
	        $this->view->loanDedit=$loanDebit;
            }
         }
    }

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
// function projname(){
// // $app = $this->view->baseUrl();
// // $word=explode('/',$app);
// // $projname = $word[1];
// 
// 
// }


    function pdftransactionAction() {
	$app = $this->view->baseUrl();
	$word=explode('/',$app);
	$projname='';
	for($i=0; $i<count($word); $i++){
		if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
	}
 	
	
	$Dispdate = $this->_request->getParam('field1'); 
	$this->view->field1 = $Dispdate;
	
	$dateconvertor = new App_Model_dateConvertor();
	$Date = $dateconvertor->mysqlformat($Dispdate);

	$title1 = $this->view->translate('Loan Supplementary');
	$this->view->pageTitle = $title1;

        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        // Image
        $image_name = "/var/www/".$projname."/public/images/logo.jpg";
        $image = Zend_Pdf_Image::imageWithPath($image_name);
        //$page->drawImage($image, 25, 770, 570, 820);
    
        $page->drawImage($image, 20, 780, 120, 830);
        $page->setLineWidth(1)->drawLine(20, 20, 580, 20); //bottom horizontal
        $page->setLineWidth(1)->drawLine(20, 20, 20, 830); //left vertical
        $page->setLineWidth(1)->drawLine(580, 25, 580, 830); //right vertical
        $page->setLineWidth(1)->drawLine(20, 830, 580, 830); //top horizontal
        //set the font
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8);

  	   
        $text = array($this->view->translate('Loan Supplementary'),
                    $this->view->translate('Sl'),
                    $this->view->translate('Particulars'),
 		    $this->view->translate('A/C No.'),
                    $this->view->translate('Cash'),
                    $this->view->translate('Transfer'),
		    $this->view->translate('Total'));
	$criteria = $this->view->translate('As of').$Dispdate;
	$currency = "* ".$this->view->translate('Amount in Rs');
        $this->view->savings = 10;
//         $page->drawText("Date : ".date('d/m/Y'),500, 800); //date('Y-m-d')
//         $page->drawText("Date : ".date('d/m/Y'),500, 800); 
        $page->drawText($text[0],200, 780);
	$page->drawText($text[0],200, 780);

	$page->drawText($criteria,500, 780); //Search criteria
	$page->drawText($criteria,500, 780);

	 $page->drawText($currency,500, 770); //Currency
	$page->drawText($currency,500, 770); 

	$my=735;
        $x1 = 33; 
        $x2 = 45; 
	$x3 = 135;
        $x4 = 170;
        $x5 = 210;
        $x6 = 260;
	
	$x7 = 300;
        $x8 = 312;
	$x9 = 402;
	$x10 = 437;
	$x11 = 477;
	$x12 = 530;
    
        $page->drawLine(30, 750, 570, 750);
        $page->drawLine(30, 730, 570, 730);

        $page->drawText($text[1], $x1, $my);
        $page->drawText($text[2], $x2, $my);
        $page->drawText($text[3], $x3, $my);
        $page->drawText($text[4], $x4, $my);
        $page->drawText($text[5], $x5, $my);  
	$page->drawText($text[6], $x6, $my);

        $page->drawText($text[1], $x7, $my);
        $page->drawText($text[2], $x8, $my);
	$page->drawText($text[3], $x9, $my);
        $page->drawText($text[4], $x10, $my);
        $page->drawText($text[5], $x11, $my);  
        $page->drawText($text[6], $x12, $my);
    

    
        $y1 = 710;
        $y2 = 710;
 		
        $this->view->loan = 10;
  	$transaction = new Loansupplementary_Model_Loansupplementary();

//                 //Loan Account Credit and Debit
                $loanCredit = $transaction->totalloanCredit($Date);
		$this->view->loanCredit=$loanCredit;

	        $loanDebit = $transaction->totalloanDebit($Date);
	        $this->view->loanDedit=$loanDebit;
 
        $totalCredit = "0";
        $totalTransferCredit = "0";
        $totalDebit = "0";
        $totalTransferDebit = "0";
	$i=0;
	$columntotal1=0;
	$columntotal=0;
	$columntotald=0;
	$columntotald1=0;


        foreach($loanCredit as $loansCredit) { $i++; $columntotal=0;
if(($loansCredit->paymenttype_mode == 1) or ($loansCredit->paymenttype_mode == 5)) {
            $page->drawText($i,$x1, $y1);
	    $productname ="To ".$loansCredit->offerproductname;
            $page->drawText($productname,$x2, $y1);
	    $page->drawText($loansCredit->account_id,$x3, $y1);
            if($loansCredit->paymenttype_mode == 1) {
                $page->drawText($loansCredit->transaction_amount,$x4, $y1);
                $totalCredit = $totalCredit + $loansCredit->transaction_amount;
		$columntotal += $loansCredit->transaction_amount;
            } elseif($loansCredit->paymenttype_mode == 5) {
                $page->drawText($loansCredit->transaction_amount,$x5, $y1);
                $totalTransferCredit = $totalTransferCredit + $loansCredit->transaction_amount; 
		$columntotal += $loansCredit->transaction_amount;
            }
 		$page->drawText(sprintf("%4.2f",$columntotal),$x6, $y1);
		$page->drawText(sprintf("%4.2f",$columntotal),$x6, $y1);
		$columntotal1 += $columntotal;
            $y1 = $y1 - 15;
        } } $i=0;
        foreach($loanDebit as $loansDebit) {  $i++;$columntotald=0;
if($loansDebit->paymenttype_mode == 1 or $loansDebit->paymenttype_mode == 5 ) {
            $page->drawText($i,$x7, $y2);
	    $productnamed = "By ".$loansDebit->offerproductname;
            $page->drawText($productnamed,$x8, $y2);
	    $page->drawText($loansDebit->account_id,$x9, $y2);
            if($loansDebit->paymenttype_mode == 1) {
                $page->drawText($loansDebit->transaction_amount,$x10, $y2);
                $totalDebit = $totalCredit + $loansDebit->transaction_amount;
		$columntotald += $loansDebit->transaction_amount;
            } elseif($loansDebit->paymenttype_mode == 5) {
                $page->drawText($loansDebit->transaction_amount,$x11, $y2);
                $totalTransferDebit = $totalTransferDebit + $loansDebit->transaction_amount; 
		$columntotald += $loansDebit->transaction_amount;
            }
		$page->drawText(sprintf("%4.2f",$columntotald),$x12, $y2);
		$page->drawText(sprintf("%4.2f",$columntotald),$x12, $y2);
		$columntotald1 += $columntotald;
            $y2 = $y2 - 15;
        } }
    
       $page->drawLine(30, $y1, 570, $y1);
       $page->drawLine(30, $y1 -20, 570, $y1 -20);
    
        $page->drawText($text[6], $x1, $y1 -15);
	$page->drawText($text[6], $x1, $y1 -15);
 	if ($totalCredit != "0"){
        $page->drawText(sprintf("%4.2f", $totalCredit), $x4, $y1 -15);
        $page->drawText(sprintf("%4.2f", $totalCredit), $x4, $y1 -15);
	}
	else {
 	$page->drawText("----", $x4, $y1 -15);
        $page->drawText("----", $x4, $y1 -15);
	}

	if ($totalTransferCredit != "0"){
        $page->drawText(sprintf("%4.2f", $totalTransferCredit), $x5, $y1 -15);
        $page->drawText(sprintf("%4.2f", $totalTransferCredit), $x5, $y1 -15);
	}
	else {
 	$page->drawText("----", $x5, $y1 -15);
        $page->drawText("----", $x5, $y1 -15);
	}

	if ($columntotal1 != "0"){
       $page->drawText(sprintf("%4.2f", $columntotal1), $x6, $y1 -15);
        $page->drawText(sprintf("%4.2f", $columntotal1), $x6, $y1 -15);
	}
	else {
 	$page->drawText("----", $x6, $y1 -15);
        $page->drawText("----", $x6, $y1 -15);
	}

	if ($totalDebit != "0"){
        $page->drawText(sprintf("%4.2f", $totalDebit), $x10, $y1 -15);
        $page->drawText(sprintf("%4.2f", $totalDebit), $x10, $y1 -15);
	}
	else {
 	$page->drawText("----", $x10, $y1 -15);
        $page->drawText("----", $x10, $y1 -15);
	}

	if ($totalTransferDebit != "0"){
        $page->drawText(sprintf("%4.2f", $totalTransferDebit), $x11, $y1 -15);
        $page->drawText(sprintf("%4.2f", $totalTransferDebit), $x11, $y1 -15);
	}
	else {
 	$page->drawText("----", $x11, $y1 -15);
        $page->drawText("----", $x11, $y1 -15);
	}

	if ($columntotald1 != "0"){
       	$page->drawText(sprintf("%4.2f", $columntotald1), $x12, $y1 -15);
        $page->drawText(sprintf("%4.2f", $columntotald1), $x12, $y1 -15);
	}
	else {
 	$page->drawText("----", $x12, $y1 -15);
        $page->drawText("----", $x12, $y1 -15);
	}
        



        // Virtual table
        $page->setLineWidth(1)->drawLine(30, $y1 - 20, 30, 750); //Table left vertical
       $page->setLineWidth(1)->drawLine(298, $y1 - 20, 298, 750); //Table center vertical
       $page->setLineWidth(1)->drawLine(570, $y1 - 20, 570, 750); //table rigth vertical
    
        $pdfData = $pdf->render();
    
    
        $pdf->save('/var/www/'.$projname.'/reports/loansupplementary.pdf');
        $path = '/var/www/'.$projname.'/reports/loansupplementary.pdf';
        chmod($path,0777);

    }
 }
