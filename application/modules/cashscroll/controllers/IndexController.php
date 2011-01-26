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
 *  create an cashscroll controller for view and pdf
 */
class Cashscroll_IndexController extends Zend_Controller_Action
{
    public function init() 
    { 
        $this->view->pageTitle = $this->view->translate("Cash scroll");
        $this->view->title =  $this->view->translate('Reports');
        $this->view->type = $this->view->translate("others");
    }
	//view action
    public function indexAction() 
    {
        $searchForm = new Cashscroll_Form_Search();
        $this->view->form = $searchForm;
//         $sample = new Reports_Form_Sample();
//         $this->view->sample = $sample;
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
	$dateconvertor = new App_Model_dateConvertor();
        $formData = $this->_request->getPost();
        if ($searchForm->isValid($formData)) {
        $fromDate = $this->_request->getParam('datefrom');
        $this->view->field1 = $fromDate ;
	$fromDate = $dateconvertor->mysqlformat($fromDate);

            $title1 = $this->view->translate("Cash Scroll");
            $this->view->pageTitle = $title1;
            $formData = $this->_request->getPost();
                $this->view->savings = 10;
                $transaction = new Cashscroll_Model_Cashscroll();

                //Saving Account Credit and Debit
                $this->view->savingsCredit = $transaction->totalSavingsCredit($fromDate);
                $this->view->savingsDebit = $transaction->totalSavingsDebit($fromDate);

                // Opening Balance
                $osc = $transaction->openingBalance($fromDate);
                foreach($osc as $osc1) {
                $this->view->openingBalance = $osc1["openingBalance"];
                }
                if((!$this->view->savingsCredit) && (!$this->view->savingsDebit)){
                                echo "<font color='red'><b> Record not found</b> </font>";
                }
            }
         }
    }

	//report display
    public function reportdisplayAction() 
    {
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
	//disable layout
        $this->_helper->layout->disableLayout();
        $file1 = $this->_request->getParam('file'); 
        $this->view->filename = "/".$projname."/reports/".$file1;
    }

     //pdf transaction
    public function pdftransactionAction() 
    { 
        $fromDate = $this->_request->getParam('field1'); 
        $this->view->field1 = $fromDate;
	//date format instance
	$dateconvertor = new App_Model_dateConvertor();
	$cfromDate = $dateconvertor->mysqlformat($fromDate);
        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        //Path
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        // Image
        $image_name = "/var/www/".$projname."/public/images/logo.jpg";
        $image = Zend_Pdf_Image::imageWithPath($image_name);
    
        $page->drawImage($image, 30, 770, 130, 820);
        $page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
        $page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
        $page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
        $page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
        //set the font
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8);
    
        $text = array("Cash Scroll - As of From ".$fromDate,
                    "SL No.",
                    "Particulars",
                    "Amount",
                    "Total",
                    "Particulars",
                    "Opening Cash",
                    "Closing Cash");
        $this->view->savings = 10;
        $page->drawText("Date : ".date('d-m-Y'),500, 800); //date('Y-m-d')
        $page->drawText("Date : ".date('d-m-Y'),500, 800); 
        $page->drawText($text[0],240, 780);$page->drawText($text[0],240, 780);

        $x1 = 60; 
        $x2 = 120; 
        $x3 = 220;
        $x4 = 340;
        $x5 = 400;
        $x6 = 500;
    
        $page->drawLine(50, 740, 550, 740);
        $page->drawLine(50, 720, 550, 720);

        $page->drawText($text[1], $x1, 725);
        $page->drawText($text[2], $x2, 725);
        $page->drawText($text[3], $x3, 725);
        $page->drawText($text[1], $x4, 725);
        $page->drawText($text[5], $x5, 725);
        $page->drawText($text[3], $x6, 725);
    
        $y1 = 710;
        $y2 = 710;



        $transaction = new Cashscroll_Model_Cashscroll();

        $this->view->savings = 10;

        $this->view->savingsCredit = $transaction->totalSavingsCredit($cfromDate);
        $this->view->savingsDebit = $transaction->totalSavingsDebit($cfromDate);

        //Credit and Debit
        $savingsCredit = $transaction->totalSavingsCredit($cfromDate);
        $savingsDebit = $transaction->totalSavingsDebit($cfromDate);
       // Opening Cash 
        $openingBalance = 0; 
        $osc = $transaction->openingBalance($cfromDate);
        foreach($osc as $osc1) {
            $openingBalance = $osc1->openingBalance;
        }



        $this->view->openingBalance = $openingBalance;

        $amountCredit = "0";
        $amountDebit = "0";
        $i = 0; $j=0;

        foreach($savingsCredit as $savingsCredit) {
            $i++;
            $page->drawText($i,$x1, $y1);
            $page->drawText($savingsCredit->account_number,$x2, $y1);
            $page->drawText($savingsCredit->amount_to_bank,$x3, $y1);
            $amountCredit = $amountCredit + $savingsCredit->amount_to_bank;
            $y1 = $y1 - 15;
        }
        foreach($savingsDebit as $savingsDebit) {
            $j++;
            $page->drawText($j,$x4, $y2);
            $page->drawText($savingsDebit->account_number,$x5, $y2);
            $page->drawText($savingsDebit->amount_from_bank,$x6, $y2);
            $amountDebit = $amountDebit + $savingsDebit->amount_from_bank;
            $y2 = $y2 - 15;
        }
       
        $page->drawLine(50, $y1, 550, $y1);
        //opening balnce
        $page->drawText($text[6], $x1, $y1 - 10);
        $page->drawText(sprintf("%4.2f", $openingBalance), $x3, $y1 -10);

        //closing Balance
        $page->drawText($text[7], $x4, $y1 -10); 
        $page->drawText(sprintf("%4.2f", ( $sum = ($amountCredit + $openingBalance) - $amountDebit)), $x6, $y1 -10);

        $page->drawLine(50, $y1 = $y1 - 20, 550, $y1);
        $page->drawLine(50, $y1 -20, 550, $y1-20);
    

        $page->drawText($text[4], $x1, $y1 -15);$page->drawText($text[4], $x1, $y1 -15);
        $page->drawText(sprintf("%4.2f", ($amountCredit + $openingBalance)), $x3, $y1 -15);
        $page->drawText(sprintf("%4.2f", ($amountCredit + $openingBalance)), $x3, $y1 -15);
        $page->drawText($text[4], $x4, $y1 -15); $page->drawText($text[4], $x4, $y1 -15);
        $page->drawText(sprintf("%4.2f", $amountDebit + $sum), $x6, $y1 -15);
        $page->drawText(sprintf("%4.2f", $amountDebit + $sum), $x6, $y1 -15);  
    
        // Virtual table
        $page->setLineWidth(1)->drawLine(50, $y1 - 20, 50, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine(300, $y1 - 20, 300, 740); //Table center vertical
        $page->setLineWidth(1)->drawLine(550, $y1 - 20, 550, 740); //table rigth vertical
        //$page->drawText("ಭಾವನಾ. ಕೆ. ಎಸ್ ",$x6 + 30, $y1 -15, 'UTF-8'); 

        $pdfData = $pdf->render();
    
        $pdf->save('/var/www/'.$projname.'/reports/cashscroll.pdf');
	$path = '/var/www/'.$projname.'/reports/cashscroll.pdf';
    
        chmod($path,0777);

    }
}
