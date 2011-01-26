<?php
class Loancount_IndexController extends Zend_Controller_Action {
	public function init() {
		$this->view->pageTitle='Loan count';
		$this->view->type='loans';
                $sessionName = new Zend_Session_Namespace('ourbank');
		$userid=$this->view->createdby = $sessionName->primaryuserid;
		$login=new App_Model_Users();
		$loginname=$login->username($userid);
		foreach($loginname as $loginname) {
		$this->view->username=$loginname['login_name'];
		}

	}

	public function indexAction() 
	{

		$this->view->title = "Loan Count";
 		$dbobj = new Loancount_Model_Loancount();
		$countaccount = $dbobj->countofloanaccount(); //clear task 1
		$this->view->loancount = $countaccount;
	}
        public function reportdisplayAction() {
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file'); 
		$this->view->filename = "/".$projname."/reports/".$file1;
	}
        function pdftransactionAction() {
                
                $dbobj = new Loancount_Model_Loancount();
		$countaccount = $dbobj->countofloanaccount(); //clear task 1
		$result = $this->view->loancount = $countaccount;
		
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];
		
		$title1 = "Loan count";
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
	
		
        	$text = array("Report for loancount",
                    "Member code",
                    "Member name",
                    "Number of accounts");

		$page->drawText("Date : ".date('d-m-Y'),500, 800); //date('Y-m-d')
		$page->drawText("Date : ".date('d-m-Y'),500, 800); 
		
		$page->drawText($text[0],185, 780);
		$page->drawText($text[0],185, 780);

		$my=735;
		$x1 = 60; 
		$x2 = 240; 
		
		$x3 = 400;
   
		$page->drawLine(50, 750, 500, 750);
		$page->drawLine(50, 730, 500, 730);
	
		$page->drawText($text[1], $x1, $my);
		$page->drawText($text[2], $x2, $my);
		$page->drawText($text[3], $x3, $my);

		$y1 = 710;
		$y2 = 710;
	
		$acc = 0;
		$Lamt = 0;
		$folio = 0;
         	foreach($result as $loanslist) {

		$page->drawText($loanslist['membercode'],$x1, $y1);
		$page->drawText($loanslist['member_name'],$x2, $y1);
		$page->drawText($loanslist['Account'],$x3, $y1);
		
		
		$y1 = $y1 - 15;
            	}
		$page->drawLine(50, $y1, 500, $y1);  
// 		$page->drawLine(30, $y1, 570, $y1);  
	
      
		// Virtual table
		$page->setLineWidth(1)->drawLine(50, $y1, 50, 750); //Table left vertical
		$page->setLineWidth(1)->drawLine(500, $y1, 500, 750); //table rigth vertical
		$pdfData = $pdf->render();
	
		$pdf->save('/var/www/'.$projname.'/reports/loancount.pdf');
		$path = '/var/www/'.$projname.'/reports/loancount.pdf';
		chmod($path,0777);

	    }

}
